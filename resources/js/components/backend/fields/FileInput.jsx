import React, { Component } from 'react';
import toastr from 'toastr'; // Asegúrate de que toastr esté importado

class FileInput extends Component {
    constructor(props) {
        super(props);
        this.state = {
            file: null,
            previewUrl: props.previewUrl
        };

        this.handleDrop = this.handleDrop.bind(this);
        this.handleDragOver = this.handleDragOver.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.handleRemove = this.handleRemove.bind(this); // Método para eliminar archivo
    }

    handleDragOver(event) {
        event.preventDefault();
        event.stopPropagation();
    }

    handleDrop(event) {
        event.preventDefault();
        event.stopPropagation();
        
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            this.uploadFile(files[0]); // Subir el archivo
        }
    }

    handleChange(event) {
        const files = event.target.files;
        if (files.length > 0) {
            this.uploadFile(files[0]); // Subir el archivo
        }
    }

    async uploadFile(file) {
        const formData = new FormData();
        formData.append('file', file);

        try {
            const response = await fetch(this.props.uploadUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                this.setState({ 
                    file: file,
                    previewUrl: result.url // Asumimos que `result.url` es la URL completa
                });
                this.props.onChange(this.props.name, result.filename); // Pasa la URL al componente padre
                toastr.success(result.message);
            } else {
                toastr.error(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            toastr.error('An error occurred.');
        }
    }

    handleRemove() {
        this.setState({ 
            file: null,
            previewUrl: null
        });
        this.props.onChange(this.props.name, null); // Indica al componente padre que no hay archivo
    }

    render() {
        const { previewUrl } = this.state;
        const { acceptedFileTypes, label } = this.props; // Tipos de archivos aceptados y la label

        let previewContent;

        if (previewUrl) {
            if (previewUrl.endsWith('.jpg') || previewUrl.endsWith('.jpeg') || previewUrl.endsWith('.png') || previewUrl.endsWith('.gif')) {
                previewContent = <img src={previewUrl} alt="Preview" style={{ maxWidth: '100%', marginTop: '10px' }} />;
            } else if (previewUrl.endsWith('.mp3')) {
                previewContent = (
                    <audio controls style={{ marginTop: '10px', maxWidth: '100%' }}>
                        <source src={previewUrl} type="audio/mpeg" />
                        Your browser does not support the audio element.
                    </audio>
                );
            } else {
                previewContent = <img src="path/to/generic-file-icon.png" alt="File Icon" style={{ maxWidth: '100%', marginTop: '10px' }} />;
            }
        }

        return (
            <div
                className="file-input-area"
                onDrop={this.handleDrop}
                onDragOver={this.handleDragOver}
            >
                {/* Mostrar la etiqueta si se proporciona */}
                {label && <label className="block text-gray-700 text-sm font-bold mb-2">{label}</label>}

                {!previewContent &&
                    <div>
                        <input
                            type="file"
                            accept={acceptedFileTypes} // Usa la prop para definir tipos de archivo aceptados
                            onChange={this.handleChange}
                            style={{ display: 'none' }}
                            ref={(ref) => this.fileInput = ref}
                        />
                        <button
                            type="button"
                            onClick={() => this.fileInput.click()}
                            className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        >
                            Choose File
                        </button>
                    </div>
                }
                {previewContent && (
                    <div className="preview">
                        {previewContent}
                        <button
                            type="button"
                            onClick={this.handleRemove}
                            className="remove-image-button bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-2"
                        >
                            Remove File
                        </button>
                    </div>
                )}
            </div>
        );
    }
}

FileInput.defaultProps = {
    acceptedFileTypes: 'image/*,audio/*', // Tipos de archivo por defecto
};

export default FileInput;
