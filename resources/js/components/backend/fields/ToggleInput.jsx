import React, { Component } from 'react';

class ToggleInput extends Component {
    constructor(props) {
        super(props);
        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(event) {
        this.props.onChange(event.target.checked);
    }

    render() {
        const { label, name, checked } = this.props;

        return (
            <div className="flex items-center">
                <label htmlFor={name} className="mr-2">{label}</label> {/* Ajustamos el margen */}
                <label className="toggle-wrapper">
                    <input
                        id={name}
                        name={name}
                        type="checkbox"
                        checked={checked}
                        onChange={this.handleChange}
                        className="toggle-checkbox"
                    />
                    <span className="toggle-slider"></span>
                </label>
            </div>
        );
    }
}

export default ToggleInput;
