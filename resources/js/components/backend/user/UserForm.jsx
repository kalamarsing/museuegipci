import React, { Component } from 'react';
import InputField from './../fields/InputField';
import PasswordField from './../fields/PasswordField';
import toastr from 'toastr'; // Asegúrate de que toastr está correctamente importado

class UserForm extends Component {
    constructor(props) {
        super(props);

        // Si hay user en las props, prellenar los campos, excepto el password.
        this.state = {
            name: props.user ? props.user.name : '',
            email: props.user ? props.user.email : '',
            password: '',
            confirmPassword: '',
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

        const { name, email, password, confirmPassword } = this.state;
        const { user } = this.props;

        const url = user ? `/admin/user/${user.id}` : '/admin/user';
        const method = user ? 'PUT' : 'POST';

        const data = {
            name,
            email,
            password: password || undefined, // Solo si no está vacío
            confirmPassword: confirmPassword || undefined, // Solo si no está vacío
        };

        // Si es una actualización y las contraseñas están vacías, no las envíes
        if (user && !password && !confirmPassword) {
            delete data.password;
            delete data.confirmPassword;
        }

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
                toastr.success(user ? 'Successfully updated user.' : 'Successfully created user.');
                setTimeout(() => {
                    window.location.href = '/admin/users'; // Redirecciona después de 1 segundo
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
        const { name, email, password, confirmPassword } = this.state;
        const { user } = this.props;

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
                    label="Email"
                    type="email"
                    name="email"
                    value={email}
                    onChange={this.handleChange}
                    required
                />
                <PasswordField
                    password={password}
                    confirmPassword={confirmPassword}
                    onPasswordChange={(value) => this.handlePasswordChange('password', value)}
                    onConfirmPasswordChange={(value) => this.handlePasswordChange('confirmPassword', value)}
                    required={!user}  // Solo es requerido si es un usuario nuevo
                />
                <button
                    className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit"
                >
                    {user ? 'Update' : 'Create'}
                </button>
            </form>
        );
    }
}

export default UserForm;
