import React, { Component } from 'react';
import InputField from './../fields/InputField';
import ToggleInput from './../fields/ToggleInput'; // Importamos el componente Toggle
import toastr from 'toastr'; 

class LanguageForm extends Component {
    constructor(props) {
        super(props);

        this.state = {
            name: props.language ? props.language.name : '',
            iso: props.language ? props.language.iso : '',
            isDefault: props.language ? props.language.isDefault : false, // Estado del toggle
        };

        this.handleChange = this.handleChange.bind(this);
        this.handleToggleChange = this.handleToggleChange.bind(this); // Manejador para el toggle
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(event) {
        this.setState({ [event.target.name]: event.target.value });
    }

    handleToggleChange(isChecked) {
        this.setState({ isDefault: isChecked }); // Actualiza el estado del toggle
    }

    async handleSubmit(event) {
        event.preventDefault();

        const { name, iso, isDefault } = this.state;
        const { language } = this.props;

        const url = language ? `/admin/language/${language.id}` : '/admin/language';
        const method = language ? 'PUT' : 'POST';

        const data = {
            name,
            iso,
            isDefault, // Añadir este campo para el toggle
        };

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                toastr.success(language ? 'Successfully updated language.' : 'Successfully created language.');
                setTimeout(() => {
                    window.location.href = '/admin/languages'; // Redirecciona después de 1 segundo
                }, 1000);
            } else {
                if (result.message) {
                    window.toastr.error('Validation error: ' + Object.values(result.message).flat().join(', '));
                } else {
                    window.toastr.error('An error occurred.');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            toastr.error('An error occurred.');
        }
    }

    render() {
        const { name, iso, isDefault } = this.state;
        const { language } = this.props;

        return (
            <form onSubmit={this.handleSubmit} className="space-y-4">
                <InputField
                    label="Name"
                    type="text"
                    name="name"
                    value={name}
                    onChange={this.handleChange}
                    required
                />

                <InputField
                    label="ISO (related to country code flag)"
                    type="text"
                    name="iso"
                    value={iso}
                    onChange={this.handleChange}
                    required
                />

                {/* Toggle Input para seleccionar si es el lenguaje por defecto */}
                <ToggleInput
                    label="Default Language"
                    name="isDefault"
                    checked={isDefault}
                    onChange={this.handleToggleChange}
                />
                <br></br>
                <button
                    className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit"
                >
                    {language ? 'Update' : 'Create'}
                </button>
            </form>
        );
    }
}

export default LanguageForm;
