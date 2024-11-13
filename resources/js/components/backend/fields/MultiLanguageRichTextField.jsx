import React, { Component } from 'react';
import RichTextField from './RichTextField';

class MultiLanguageRichTextField extends Component {
    constructor(props) {
        super(props);
        this.state = {
            values: props.values || {},  // Valores por idioma, ejemplo: { 1: '<p>Hello</p>', 2: '<p>Hola</p>' }
        };

        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(languageId, value) {
        const { values } = this.state;
        const updatedValues = { ...values, [languageId]: value };

        this.setState({ values: updatedValues });

        // Pasamos los valores actualizados al componente padre
        this.props.onChange(updatedValues);
    }

    render() {
        const { label, name, languages, required } = this.props;
        const { values } = this.state;

        return (
            <div>
                {languages.map((language) => (
                    <div key={language.id} className="mb-4">
                        <RichTextField
                            label={`${label} (${language.iso.toUpperCase()})`}  // Muestra el código ISO en el label
                            name={`${name}_${language.id}`}
                            value={values[language.id] || ''}  // Valor correspondiente al idioma actual
                            onChange={(value) => this.handleChange(language.id, value)}
                            required={required}
                        />
                    </div>
                ))}
            </div>
        );
    }
}

export default MultiLanguageRichTextField;
