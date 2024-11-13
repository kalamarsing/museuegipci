// resources/js/components/ElementTable.js
import React, { Component } from "react";
import CustomDataTable from "./../common/DataTable";
import axios from "axios";

class ElementTable extends Component {
    constructor(props) {
        super(props);
        this.state = {
            elements: [], // Datos de los usuarios
            loading: true, // Estado de carga
        };
    }

    componentDidMount() {
        this.fetchElements();
    }

    fetchElements() {
        axios.get("/admin/elements/"+this.props.floor.id+"/all/title")
            .then((response) => {
                this.setState({
                    elements: response.data, // Datos de usuarios
                    loading: false,
                });
            })
            .catch((error) => {
                console.error("Error fetching elements:", error);
                this.setState({ loading: false });
            });
    }

    render() {
        // Definir las columnas para la tabla
        const columns = [
            {
                name: "Number",
                selector: row => row.number,
                sortable: true,
            },
            {
                name: "title",
                selector:  row => row.title,
                sortable: true,
            }
            
        ];

        return (
            <div>
                {this.state.loading ? (
                    <p>Loading...</p>
                ) : (
                    <CustomDataTable
                        title="Elements"
                        columns={columns}
                        data={this.state.elements}
                        editRoute={'/admin/floor/'+this.props.floor.id+'/element'}
                    />
                )}
            </div>
        );
    }
}

export default ElementTable;
