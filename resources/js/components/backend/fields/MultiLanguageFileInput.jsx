// resources/js/components/backend/fields/MultiLanguageFileInput.js
import React, { Component } from 'react';
import FileInput from './FileInput';

class MultiLanguageFileInput extends Component {
    constructor(props) {
        super(props);
        this.state = {
            files: props.files || {},  // Almacena los archivos por idioma, ejemplo: { 1: 'file1.mp3', 2: 'file2.mp3' }
        };

        this.handleFileChange = this.handleFileChange.bind(this);
    }

    handleFileChange(languageId, name, filename) {
        const { files } = this.state;
        const updatedFiles = { ...files, [languageId]: filename };

        this.setState({ files: updatedFiles });

        // Pasamos los archivos actualizados al componente padre
        this.props.onChange(updatedFiles);
    }

    render() {
        const { label, name, languages, uploadUrl, acceptedFileTypes } = this.props;
        const { files } = this.state;

        return (
            <div>
                {languages.map((language) => (
                    <div key={language.id} className="mb-4">
                        <FileInput
                            label={`${label} (${language.iso.toUpperCase()})`}  // Muestra el código ISO del idioma
                            name={`${name}_${language.id}`}
                            uploadUrl={uploadUrl}  // URL para subir archivos
                            previewUrl={files[language.id] ? `${this.props.previewUrlFolder}/${files[language.id]}` : null}
                            acceptedFileTypes={acceptedFileTypes}  // Tipos de archivos permitidos (imagen/audio)
                            onChange={(name, filename) => this.handleFileChange(language.id, name, filename)}  // Actualiza el archivo seleccionado
                        />
                    </div>
                ))}
            </div>
        );
    }
}

export default MultiLanguageFileInput;
