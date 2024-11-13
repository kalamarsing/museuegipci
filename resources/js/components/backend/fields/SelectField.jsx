import React from 'react';

class SelectComponent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            value: props.value || null
        };

        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(event) {
        const value = event.target.value; // Obtener el valor del evento
        this.setState({ value });
        // Pasamos el valor actualizado al padre
        console.log = 
        this.props.handleOnChange(value);
    }


    render() {
        const { nombre, label, options } = this.props;
        const { value } = this.state;

        return (
        <div style={{ marginBottom: '1rem' }}>
            <label htmlFor={nombre} style={{ display: 'block', marginBottom: '0.5rem' }}>
            {label}
            </label>
            <select
            id={nombre}
            name={nombre}
            value={value}
            onChange={this.handleChange}
            style={{ width: '100%', padding: '0.5rem', borderRadius: '4px' }}
            >
            {options.map((option, index) => (
                <option key={index} value={option.value}>
                {option.label}
                </option>
            ))}
            </select>
        </div>
        );
    }
}

export default SelectComponent;
