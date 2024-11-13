// resources/js/components/LanguageTable.js
import React, { Component } from "react";
import CustomDataTable from "./../common/DataTable";
import axios from "axios";

class LanguageTable extends Component {
    constructor(props) {
        super(props);
        this.state = {
            languages: [], // Datos de los usuarios
            loading: true, // Estado de carga
        };
    }

    componentDidMount() {
        this.fetchLanguages();
    }

    fetchLanguages() {
        axios.get("/admin/languages/all")
            .then((response) => {
                this.setState({
                    languages: response.data, // Datos de usuarios
                    loading: false,
                });
            })
            .catch((error) => {
                console.error("Error fetching languages:", error);
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
                name: "name",
                selector:  row => row.name,
                sortable: true,
            },
            {
                name: "iso",
                selector:  row => row.iso,
                sortable: true,
            }
            
        ];

        return (
            <div>
                {this.state.loading ? (
                    <p>Loading...</p>
                ) : (
                    <CustomDataTable
                        title="Languages"
                        columns={columns}
                        data={this.state.languages}
                        editRoute="/admin/language" 
                    />
                )}
            </div>
        );
    }
}

export default LanguageTable;
