import React, { Component } from 'react';
import InputField from './../fields/InputField';
import toastr from 'toastr'; // Asegúrate de que toastr está correctamente importado

class CodeForm extends Component {
    constructor(props) {
        super(props);

        // Si hay code en las props, prellenar los campos, excepto el password.
        this.state = {
            value: props.code ? props.code.value : '',
        };

        this.handleChange = this.handleChange.bind(this);
        this.handlePasswordChange = this.handlePasswordChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(event) {
        this.setState({ [event.target.name]: event.target.value });
    }

    handlePasswordChange(name, value) {
        this.setState({ [name]: value });
    }

    async handleSubmit(event) {
        event.preventDefault();

        const { value } = this.state;
        const { code } = this.props;

        const url = code ? `/admin/code/${code.id}` : '/admin/code';
        const method = code ? 'PUT' : 'POST';

        const data = {
            value,
           
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
                toastr.success(code ? 'Successfully updated code.' : 'Successfully created code.');
                setTimeout(() => {
                    window.location.href = '/admin/codes'; // Redirecciona después de 1 segundo
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
        const { value } = this.state;
        const { code } = this.props;

        return (
            <form onSubmit={this.handleSubmit} className="space-y-4">
                <InputField
                    label="Value"
                    type="text"
                    name="value"
                    value={value}
                    onChange={this.handleChange}
                    required
                />
                <button
                    className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit"
                >
                    {code ? 'Update' : 'Create'}
                </button>
            </form>
        );
    }
}

export default CodeForm;
