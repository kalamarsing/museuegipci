import React, { Component } from 'react';

class ImageMapWithPointers extends Component {
    constructor(props) {
        super(props);

        this.state = {
            currentPointers: props.pointers, // Inicializamos con los pointers que recibimos por props
        };

        this.handleDragStart = this.handleDragStart.bind(this);
        this.handleDrop = this.handleDrop.bind(this);
        this.handleDragOver = this.handleDragOver.bind(this);
    }

    handleDragStart(event, index) {
        event.dataTransfer.setData('index', index);
    }

    handleDrop(event) {
        event.preventDefault();
        const index = event.dataTransfer.getData('index');

        const imgElement = event.target.closest('img');
        const rect = imgElement.getBoundingClientRect(); // Obtener posición y dimensiones

        const imgWidth = rect.width;
        const imgHeight = rect.height;

        // Calcular nuevas coordenadas normalizadas
        const newLongitude = (event.clientX - rect.left) / imgWidth; 
        const newLatitude = (event.clientY - rect.top) / imgHeight;

        const updatedPointers = [...this.state.currentPointers];
        updatedPointers[index] = {
            ...updatedPointers[index],
            latitude: newLatitude,
            longitude: newLongitude,
        };

        this.setState({ currentPointers: updatedPointers });
        if (this.props.onChange) {
            console.log(updatedPointers);
            this.props.onChange(updatedPointers);
        }
    }

    handleDragOver(event) {
        event.preventDefault();
    }

    getPointerStyle(latitude, longitude) {
        return {
            position: 'absolute',
            top: `${latitude * 100}%`,
            left: `${longitude * 100}%`,
            transform: 'translate(-50%, -50%)', // Para centrar el pointer
            cursor: this.props.edit ? 'move' : 'pointer',
        };
    }

    render() {
        const { image, edit } = this.props;
        const { currentPointers } = this.state;

        return (
            <div style={{ position: 'relative', display: 'inline-block' }} onDragOver={this.handleDragOver} onDrop={this.handleDrop}>
                <img src={image} alt="Map" style={{ width: '100%', height: 'auto', display: 'block' }} />
                {currentPointers.map((pointer, index) => {
                    const { latitude, longitude, url, number, permanentExposition } = pointer;

                    // Verifica si latitude y longitude son nulos o vacíos
                    if (!latitude || !longitude) {
                        // Si está en modo edición, coloca el pointer en el centro
                        if (edit) {
                            return (
                                <div
                                    key={index}
                                    draggable={edit}
                                    onDragStart={(event) => this.handleDragStart(event, index)}
                                    style={this.getPointerStyle(0.5, 0.5)} // Centro de la imagen
                                >
                                    <div
                                        src="/storage/images/mapIcon.png"
                                        alt="Pointer"
                                        className={permanentExposition ? 'permanent-map-pointer' : 'map-pointer '}
                                        style={{ width: '30px', height: '30px' , borderRadius:'50%'}}
                                    >
                                    </div>
                                    <div
                                        className='map-pointer-text'
                                        style={{
                                            position: 'absolute',
                                            top: '50%',
                                            left: '50%',
                                            transform: 'translate(-50%, -50%)',
                                            fontWeight: 'bold',
                                        }}
                                    >
                                        {number}
                                    </div>
                                </div>
                            );
                        }
                        // Si no está en modo edición, no muestra el pointer
                        return null;
                    }

                    return (
                        <div
                            key={index}
                            draggable={edit}
                            onDragStart={(event) => this.handleDragStart(event, index)}
                            style={this.getPointerStyle(latitude, longitude)}
                        >
                            {edit ? (
                               <div
                                    src="/storage/images/mapIcon.png"
                                    alt="Pointer"
                                    className={permanentExposition ? 'permanent-map-pointer' : 'map-pointer '}
                                    style={{ width: '30px', height: '30px' , borderRadius:'50%'}}
                                >
                                </div>
                            ) : (
                                <a href={url || '#'}  rel="noopener noreferrer">
                                    <div
                                        src="/storage/images/mapIcon.png"
                                        alt="Pointer"
                                        className={permanentExposition ? 'permanent-map-pointer' : 'map-pointer '}
                                        style={{ width: '30px', height: '30px' , borderRadius:'50%'}}
                                    >
                                    </div>
                                    
                                </a>
                            )}
                            <div
                                className='map-pointer-text'
                                style={{
                                    position: 'absolute',
                                    top: '50%',
                                    left: '50%',
                                    transform: 'translate(-50%, -50%)',
                                    fontWeight: 'bold',
                    
                                }}
                            >
                                {number}
                            </div>
                        </div>
                    );
                })}
            </div>
        );
    }
}

export default ImageMapWithPointers;
