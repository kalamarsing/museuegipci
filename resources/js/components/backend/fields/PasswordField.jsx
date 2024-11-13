// resources/js/components/backend/fields/PasswordField.js
import React, { Component } from 'react';

class PasswordField extends Component {
    constructor(props) {
        super(props);
        this.state = {
            password: '',
            confirmPassword: '',
            error: ''
        };

        this.handlePasswordChange = this.handlePasswordChange.bind(this);
        this.handleConfirmPasswordChange = this.handleConfirmPasswordChange.bind(this);
        this.validatePasswords = this.validatePasswords.bind(this);
    }

    handlePasswordChange(event) {
        const password = event.target.value;
        this.setState({ password }, () => this.validatePasswords());
        this.props.onPasswordChange(password);
    }

    handleConfirmPasswordChange(event) {
        const confirmPassword = event.target.value;
        this.setState({ confirmPassword }, () => this.validatePasswords());
        this.props.onConfirmPasswordChange(confirmPassword);
    }

    validatePasswords() {
        const { password, confirmPassword } = this.state;
        const { required } = this.props;

        let error = '';

        // Verificación si el campo es requerido
        if (required) {
            if (password.length < 8) {
                error = 'Password must be at least 8 characters long.';
            }
        }

        // Validación de que las contraseñas coincidan
        if (!error && password !== confirmPassword) {
            error = 'Passwords do not match.';
        }

        this.setState({ error });
    }

    render() {
        const { required } = this.props;
        const { password, confirmPassword, error } = this.state;

        return (
            <div className="mb-4">
                <label className="block text-gray-700 text-sm font-bold mb-2">
                    Password
                </label>
                <input
                    className={`shadow appearance-none border ${error ? 'border-red-500' : ''} rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline`}
                    type="password"
                    value={password}
                    onChange={this.handlePasswordChange}
                    required={required}
                    minLength={required ? 8 : undefined} // Aplica el mínimo solo si es requerido
                />
                <label className="block text-gray-700 text-sm font-bold mb-2 mt-2">
                    Confirm Password
                </label>
                <input
                    className={`shadow appearance-none border ${error ? 'border-red-500' : ''} rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline`}
                    type="password"
                    value={confirmPassword}
                    onChange={this.handleConfirmPasswordChange}
                    required={required}
                />
                {error && <p className="text-red-500 text-xs italic">{error}</p>}
            </div>
        );
    }
}

export default PasswordField;
