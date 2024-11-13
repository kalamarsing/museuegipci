import React, { Component } from 'react';
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css'; // Importa los estilos de Quill

class RichTextField extends Component {
    constructor(props) {
        super(props);
        this.state = {
            value: props.value || ''
        };

        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(value) {
        this.setState({ value });
        // Pasamos el valor actualizado al padre
        this.props.onChange(value);
    }

    render() {
        const { label, name, required } = this.props;
        const { value } = this.state;

        return (
            <div className="mb-4">
                <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor={name}>
                    {label}
                </label>
                <ReactQuill 
                    value={value} 
                    onChange={this.handleChange} 
                    className="bg-white" 
                />
                {required && (
                    <input 
                        type="hidden" 
                        name={name} 
                        value={value || ''} 
                        required={required} 
                    />
                )}
            </div>
        );
    }
}

export default RichTextField;
