// resources/js/components/FloorTable.js
import React, { Component } from "react";
import CustomDataTable from "./../common/DataTable";
import axios from "axios";

class FloorTable extends Component {
    constructor(props) {
        super(props);
        this.state = {
            floors: [], // Datos de los usuarios
            loading: true, // Estado de carga
        };
    }

    componentDidMount() {
        this.fetchFloors();
    }

    fetchFloors() {
        axios.get("/admin/floors/all/title")
            .then((response) => {
                this.setState({
                    floors: response.data, // Datos de usuarios
                    loading: false,
                });
            })
            .catch((error) => {
                console.error("Error fetching floors:", error);
                this.setState({ loading: false });
            });
    }

    render() {
        // Definir las columnas para la tabla
        const columns = [
            {
                name: "ID",
                selector: row => row.id,
                sortable: true,
            },
            {
                name: "Title",
                selector: row => row.title,
                sortable: true,
            },
            {
                name: "map",
                selector:  row => row.map,
                sortable: true,
                cell: row => (
                    row.map ? (
                        <img
                            src={`/storage/medias/thumbnail/${row.map}`}
                            alt="Floor Map"
                            style={{ maxWidth: "300px", height: "auto" }}
                        />
                    ) : (
                        <span>No image available</span> // Texto alternativo si no hay mapa
                    )
                ),
            }
            
        ];

        return (
            <div>
                {this.state.loading ? (
                    <p>Loading...</p>
                ) : (
                    <CustomDataTable
                        title="Floors"
                        columns={columns}
                        data={this.state.floors}
                        editRoute="/admin/floor" 
                    />
                )}
            </div>
        );
    }
}

export default FloorTable;
