// resources/js/components/backend/fields/InputField.js
import React from 'react';

class InputField extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            error: ''
        };

        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(event) {
        const { value, name } = event.target;
        const { type } = this.props;

        // Verificación de formato de email si el campo es de tipo email
        if (type === 'email') {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(value)) {
                this.setState({ error: 'Please enter a valid email address.' });
            } else {
                this.setState({ error: '' });
            }
        }

        this.props.onChange(event);  // Pasamos el cambio al padre
    }

    render() {
        const { label, name, value, type, required } = this.props;
        const { error } = this.state;

        return (
            <div className="mb-4">
                <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor={name}>
                    {label}
                </label>
                <input
                    className={`shadow appearance-none border ${error ? 'border-red-500' : ''} rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline`}
                    id={name}
                    name={name}
                    type={type}
                    value={value}
                    onChange={this.handleChange}
                    required={required}
                />
                {error && <p className="text-red-500 text-xs italic">{error}</p>}
            </div>
        );
    }
}

export default InputField;

