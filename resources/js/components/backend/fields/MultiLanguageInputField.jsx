// resources/js/components/backend/fields/MultiLanguageInputField.js
import React from 'react';
import InputField from './InputField';

class MultiLanguageInputField extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            values: props.values || {},  // Valores por idioma, ejemplo: { 1: 'Hello', 2: 'Hola' }
        };

        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(languageId, event) {
        const { values } = this.state;
        const updatedValues = { ...values, [languageId]: event.target.value };

        this.setState({ values: updatedValues });

        // Pasamos los valores actualizados al componente padre
        this.props.onChange(updatedValues);
    }

    renderYoutubeEmbed(videoId) {
        if (!videoId) return null;

        // Construye la URL de embed del video de YouTube
        const embedUrl = `https://www.youtube.com/embed/${videoId}`;

        return (
            <div className="youtube-embed mt-4">
                <iframe
                    width="560"
                    height="315"
                    src={embedUrl}
                    frameBorder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowFullScreen
                    title="YouTube video"
                ></iframe>
            </div>
        );
    }

    render() {
        const { label, name, languages, required, YoutubeVideo = false } = this.props;

        const { values } = this.state;

        return (
            <div>
                {languages.map((language) => (
                    <div key={language.id} className="mb-4">
                        <InputField
                            label={`${label} (${language.iso.toUpperCase()})`} // Muestra el código ISO en el label
                            name={`${name}_${language.id}`}
                            type="text"
                            value={values[language.id] || ''} // Valor correspondiente al idioma actual
                            onChange={(event) => this.handleChange(language.id, event)}
                            required={required}
                        />

                        {/* Si YoutubeVideo está habilitado y hay un video ID, mostrar el embed */}
                        {YoutubeVideo && values[language.id] && this.renderYoutubeEmbed(values[language.id])}
           
                    </div>
                ))}
            </div>
        );
    }
}

export default MultiLanguageInputField;
