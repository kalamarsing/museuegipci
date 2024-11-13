import React, { Component } from 'react';
import InputField from './../fields/InputField'; // Asegúrate de que la ruta sea correcta
import MultiLanguageInputField from './../fields/MultiLanguageInputField'; // Asegúrate de que la ruta sea correcta
import FileInput from './../fields/FileInput'; // Asegúrate de que la ruta sea correcta
import toastr from 'toastr'; // Asegúrate de que toastr esté importado

class FloorForm extends Component {
    constructor(props) {
        super(props);

        this.state = {
            map: props.floor ? props.floor.map : '',
            map2: props.floor ? props.floor.map2 : '',
            image: props.floor ? props.floor.image : '',
            title: props.fields ? props.fields.title : {}, 
            order: props.floor ? props.floor.order : '0'
        };

        this.handleTitlesChange = this.handleTitlesChange.bind(this);
        this.handleFileChange = this.handleFileChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);

    }

    handleChange(event) {
        this.setState({ [event.target.name]: event.target.value });
    }

    handleTitlesChange(updatedTitles) {
        this.setState({ title: updatedTitles });
    }

    handleFileChange(name, filename) {
        this.setState({ [name]: filename });
    }


    async handleSubmit(event) {
        event.preventDefault();
    
        const { map, map2, image, title, order } = this.state; 
        const { floor } = this.props;
    
        const url = floor ? `/admin/floor/${floor.id}` : '/admin/floor';
        const method = floor ? 'PUT' : 'POST';
    
        const data = {
            map: map,
            map2: map2,
            image: image,
            title: title,
            order: order
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
                    window.location.href = '/admin/floors'; // Redirecciona después de 1 segundo
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
        const { map, map2, image, title, order } = this.state;

        return (
            <form onSubmit={this.handleSubmit} className="space-y-4">

                <FileInput
                    acceptedFileTypes="image/*" 
                    onChange={this.handleFileChange}
                    uploadUrl="/admin/media/upload"
                    previewUrl={map2 && map2 != '' ? '/storage/medias/original/'+map2 : null}
                    label="Map Gral Image (no pointers)"
                    name="map2" // Este name será usado para actualizar el campo correcto
                />
                <br></br>
                <FileInput
                    acceptedFileTypes="image/*" 
                    onChange={this.handleFileChange}
                    uploadUrl="/admin/media/upload"
                    previewUrl={map && map != '' ? '/storage/medias/original/'+map : null}
                    label="Map Image (for pointers)"
                    name="map" // Este name será usado para actualizar el campo correcto
                />
                <br></br>
                <FileInput
                    acceptedFileTypes="image/*" 
                    onChange={this.handleFileChange}
                    uploadUrl="/admin/media/upload"
                    previewUrl={image && image != '' ? '/storage/medias/original/'+image : null}
                    label="Section Image"
                    name="image" // Este name será usado para actualizar el campo correcto
                />

                <MultiLanguageInputField
                    label="Title"
                    name="title"
                    values={title}
                    languages={window.LANGUAGES} // Proporciona los idiomas desde window.LANGUAGES
                    onChange={this.handleTitlesChange}
                />

                <InputField
                    label="Order"
                    type="text"
                    name="order"
                    value={order}
                    onChange={this.handleChange}
                    required
                />
                <button
                    className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit"
                >
                    {this.props.floor ? 'Update' : 'Create'}
                </button>
            </form>
        );
    }
}

export default FloorForm;
