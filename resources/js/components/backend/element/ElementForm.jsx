import React, { Component } from 'react';
import InputField from './../fields/InputField'; 
import MultiLanguageInputField from './../fields/MultiLanguageInputField'; 
import MultiLanguageRichTextField from './../fields/MultiLanguageRichTextField'; 
import ImageMapWithPointers from './../common/ImageWithPointers'; 

import MultiLanguageFileInput from './../fields/MultiLanguageFileInput'; 

import FileInput from './../fields/FileInput'; 
import toastr from 'toastr'; 
import ToggleInput from './../fields/ToggleInput';

class ElementForm extends Component {
    constructor(props) {
        super(props);

        this.state = {
            latitude: props.element && props.element.latitude ? props.element.latitude : '',
            longitude: props.element && props.element.longitude ? props.element.longitude : '',
            permanent_exposition: props.element && props.element.permanent_exposition ? props.element.permanent_exposition : false,
            audio_image: props.element && props.element.audio_image ? props.element.audio_image : null, // Ejemplo de valores por idioma
            video_image: props.element && props.element.video_image ? props.element.video_image : null, // Ejemplo de valores por idioma
            number: props.element && props.element.number ? props.element.number : '',

            title: props.fields ? props.fields.title : {}, // Ejemplo de valores por idioma
            subtitle: props.fields ? props.fields.subtitle : {}, // Ejemplo de valores por idioma

            audio: props.fields ? props.fields.audio : {}, // Ejemplo de valores por idioma
            text: props.fields && props.fields.text ? props.fields.text : {}, // Ejemplo de valores por idioma
            video: props.fields && props.fields.video ? props.fields.video : {}, // Ejemplo de valores por idioma

        };

        this.handleTitlesChange = this.handleTitlesChange.bind(this);
        this.handleSubtitlesChange = this.handleSubtitlesChange.bind(this);

        this.handleTextChange = this.handleTextChange.bind(this);
        this.handleVideoChange = this.handleVideoChange.bind(this);

        this.handleFileChange = this.handleFileChange.bind(this);
        this.handleToggleChange = this.handleToggleChange.bind(this); // Manejador para el toggle
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.handleChangeCoords = this.handleChangeCoords.bind(this);
        this.handleAudioChange = this.handleAudioChange.bind(this);
        
    }

    handleChange(event) {
        this.setState({ [event.target.name]: event.target.value });
    }

    handleChangeCoords(updatedPointers) {
        console.log('AAAA',updatedPointers[0].latitude);
        this.setState({ latitude: updatedPointers[0].latitude,  longitude : updatedPointers[0].longitude});
    }

    handleToggleChange(isChecked) {
        this.setState({ permanent_exposition: isChecked }); // Actualiza el estado del toggle
    }

    handleMapChange(event) {
        this.setState({ map: event.target.value });
    }

    handleTitlesChange(updatedTitles) {
        this.setState({ title: updatedTitles });
    }

    handleSubtitlesChange(updatedSubitles) {
        this.setState({ subtitle: updatedSubitles });
    }

    handleVideoChange(updatedVideo) {
        this.setState({ video: updatedVideo });
    }

    handleTextChange(updatedTitles) {
        this.setState({ text: updatedTitles });
    }

    handleFileChange(name, filename) {
        this.setState({ [name]: filename });
    }

    handleAudioChange(updatedFiles) {
        this.setState({ audio: updatedFiles });
    }

    async handleSubmit(event) {
        event.preventDefault();
    
        const { latitude, longitude, number, title, subtitle, audio_image, video_image, permanent_exposition, text, audio, video } = this.state;
        const { floor, element } = this.props;

        const url = element ? `/admin/element/${element.id}` : '/admin/element';
        const method = element ? 'PUT' : 'POST';
    
        const data = {
            title: title,
            subtitle: subtitle,
            audio_image: audio_image,
            video_image: video_image,
            permanent_exposition: permanent_exposition,
            number: number,
            latitude : latitude,
            longitude : longitude,
            floor_id: floor.id,
            text : text,
            audio: audio,
            video: video
        };
    
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json', // Enviar JSON
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data) // Convertir datos a JSON
            });
    
            const result = await response.json();
    
            if (response.ok) {
                toastr.success(floor ? 'Successfully updated floor.' : 'Successfully created floor.');
                setTimeout(() => {
                    window.location.href = '/admin/elements/'+this.props.floor.id+'/index'; // Redirecciona después de 1 segundo
                }, 1000);
            } else {
                if (result.message) {
                    toastr.error('Validation error: ' + Object.values(result.message).flat().join(', '));
                } else {
                    toastr.error('An error occurred.');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            toastr.error('An error occurred.');
        }
    }

    render() {
        const { latitude, longitude, number, audio_image, video_image, permanent_exposition, title, subtitle, text, audio, video } = this.state;
        const pointers = [
            { latitude: latitude, longitude: longitude, number: number, url: null },
        ];

        return (
            <form onSubmit={this.handleSubmit} className="space-y-4">

     
                <ImageMapWithPointers
                    image={"/storage/medias/original/"+this.props.floor.map}
                    pointers={pointers}
                    edit={true}
                    onChange={this.handleChangeCoords}
                />


                <InputField
                    label="Number for pointer"
                    type="text"
                    name="number"
                    value={number}
                    onChange={this.handleChange}
                    required
                />

                <ToggleInput
                    label="Is permantent Exposition?"
                    name="permanent_exposition"
                    checked={permanent_exposition}
                    onChange={this.handleToggleChange}
                />
                <br></br>

                 <FileInput
                    acceptedFileTypes="image/*" 
                    onChange={this.handleFileChange}
                    uploadUrl="/admin/media/upload"
                    previewUrl={audio_image && audio_image != '' ? '/storage/medias/original/'+audio_image : null}
                    label="Image For audio player background"
                    name="audio_image" // Este name será usado para actualizar el campo correcto
                />

                <FileInput
                    acceptedFileTypes="image/*" 
                    onChange={this.handleFileChange}
                    uploadUrl="/admin/media/upload"
                    previewUrl={video_image && video_image != '' ? '/storage/medias/original/'+video_image : null}
                    label="Image For video player background"
                    name="video_image" // Este name será usado para actualizar el campo correcto
                />

                

                <MultiLanguageInputField
                    label="Title"
                    name="title"
                    values={title}
                    languages={window.LANGUAGES} // Proporciona los idiomas desde window.LANGUAGES
                    onChange={this.handleTitlesChange}
                />

                <MultiLanguageInputField
                    label="Subtitle"
                    name="subtitle"
                    values={subtitle}
                    languages={window.LANGUAGES} // Proporciona los idiomas desde window.LANGUAGES
                    onChange={this.handleSubtitlesChange}
                />


                <MultiLanguageRichTextField
                    label="Text"
                    name="text"
                    values={text}  
                    languages={window.LANGUAGES}  // Proporciona los idiomas desde window.LANGUAGES
                    onChange={this.handleTextChange}
                />

                <MultiLanguageFileInput
                    label="Audio File"
                    name="audio"
                    files={audio}  // Objeto con los archivos por idioma, por ejemplo: {1: 'audio1.mp3', 2: 'audio2.mp3'}
                    languages={window.LANGUAGES}  // Proporciona los idiomas desde window.LANGUAGES
                    uploadUrl="/admin/media/upload"  // URL para subir los archivos
                    acceptedFileTypes="audio/*"  // Tipos de archivos aceptados (en este caso, solo audio)
                    onChange={this.handleAudioChange}
                    previewUrlFolder="/storage/files"
                />

                <MultiLanguageInputField
                    label="Video"
                    name="video"
                    values={video}
                    languages={window.LANGUAGES} // Proporciona los idiomas desde window.LANGUAGES
                    onChange={this.handleVideoChange}
                    YoutubeVideo={true}
                />





                <button
                    className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit"
                >
                    {this.props.element ? 'Update' : 'Create'}
                </button>
            </form>
        );
    }
}

export default ElementForm;
