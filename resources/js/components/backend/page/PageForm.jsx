import React, { Component } from 'react';

import InputField from './../fields/InputField'; 
import RichTextField from './../fields/RichTextField'; 
import FileInput from './../fields/FileInput'; 

import MultiLanguageInputField from './../fields/MultiLanguageInputField'; 
import MultiLanguageRichTextField from './../fields/MultiLanguageRichTextField'; 
import MultiLanguageFileInput from './../fields/MultiLanguageFileInput'; 
import SelectField from './../fields/SelectField';


import toastr from 'toastr'; 

class PageForm extends Component {
    constructor(props) {
        super(props);

        this.state = {
            identifier: props.page && props.page.identifier ? props.page.identifier : '',
            type: props.page && props.page.type ? props.page.type : '',
            fields: props.fields ? props.fields : null, // Ejemplo de valores por idioma

        };
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleTypeChange = this.handleTypeChange.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.handleFieldsChange = this.handleFieldsChange.bind(this);

    }


    handleTypeChange(updatedType) {
        this.setState({
             type: updatedType,
             fields: null
        });
    }

    handleChange(event) {
        this.setState({ [event.target.name]: event.target.value });
    }


    handleFieldsChange(data,filename) {
        const { type } = this.state;
        switch (type) {
            case 'file':
                this.setState({ fields: filename });
                break;
            case 'text':
                this.setState({ fields: data.target.value });
                break;
            case 'richtext':
                this.setState({ fields: data });
                break;
          
            case 'MultiLanguageText':
                this.setState({ fields: data });
                break;
            case 'MultiLanguageRichtext':
                this.setState({ fields: data });
                break;
            default:
                fieldComponent = null;
        }
    }


    async handleSubmit(event) {
        event.preventDefault();
    
        const { type, identifier, fields } = this.state;
        const { page } = this.props;

        const url = page ? `/admin/page/${page.id}` : '/admin/page';
        const method = page ? 'PUT' : 'POST';
    
        const data = {
            identifier: identifier,
            type: type,
            fields: fields
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
                toastr.success(page ? 'Successfully updated page item.' : 'Successfully created page item.');
                setTimeout(() => {
                    window.location.href = '/admin/pages/'+this.props.page.id+'/index'; // Redirecciona después de 1 segundo
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
        const { type, identifier, fields } = this.state;

        const options = [
            { value: 'null', label: 'Select a page item type' },
            { value: 'file', label: 'Image' },
            { value: 'text', label: 'Text' },
            { value: 'richtext', label: 'Richext' },
            { value: 'MultiLanguageText', label: 'MultiLanguage text' },
            { value: 'MultiLanguageRichtext', label: 'MultiLanguage richext' },
          ];


        let fieldComponent;

        switch (type) {
            case 'file':
                fieldComponent = (
                    <FileInput
                        acceptedFileTypes="image/*" 
                        onChange={this.handleFieldsChange}
                        uploadUrl="/admin/media/upload"
                        previewUrl={fields && fields != '' ? '/storage/medias/original/'+fields : null}
                        label="Image"
                        name="fields" // Este name será usado para actualizar el campo correcto
                    />
                );
                break;
            case 'text':
                fieldComponent = (
                    <InputField
                        label="Text Field"
                        type="text"
                        name="fields"
                        value={fields}
                        onChange={this.handleFieldsChange}
                    />
                );
                break;
            case 'richtext':
                fieldComponent = (

                    <RichTextField
                        label="Rich Text Field"
                        name="fields"
                        value={fields}  // Valor correspondiente al idioma actual
                        onChange={this.handleFieldsChange}
                    />
                );
                break;
            /*case 'MultiLanguageFile':
                fieldComponent = (
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
                    );
                break;*/
            case 'MultiLanguageText':
                fieldComponent = (

                    <MultiLanguageInputField
                        label="MultiLanguage Text Field"
                        name="fields"
                        values={fields}
                        languages={window.LANGUAGES}  // Proporciona los idiomas desde window.LANGUAGES
                        onChange={this.handleFieldsChange}
                    />
                );
                break;
            case 'MultiLanguageRichtext':
                fieldComponent = (
                    <MultiLanguageRichTextField
                        label="MultiLanguage Rich Text Field"
                        name="fields"
                        values={fields}  
                        languages={window.LANGUAGES}  // Proporciona los idiomas desde window.LANGUAGES
                        onChange={this.handleFieldsChange}
                    />
                );
                break;
            default:
                fieldComponent = null;
        }

        return (
            <form onSubmit={this.handleSubmit} className="space-y-4">


                <InputField
                    label="Identifier"
                    type="text"
                    name="identifier"
                    value={identifier}
                    onChange={this.handleChange}
                    required
                />

               
                <SelectField
                    nombre="type"
                    label="Select a Page Item type"
                    value={type}
                    handleOnChange={this.handleTypeChange}
                    options={options}  // Aquí pasas las opciones
                />

                {fieldComponent} {/* Mostrar el campo correspondiente según el tipo */}

                <br></br>

                <button
                    className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit"
                >
                    {this.props.page ? 'Update' : 'Create'}
                </button>
            </form>
        );
    }
}

export default PageForm;
