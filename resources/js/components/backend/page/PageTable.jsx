// resources/js/components/PageTable.js
import React, { Component } from "react";
import CustomDataTable from "./../common/DataTable";
import axios from "axios";

class PageTable extends Component {
    constructor(props) {
        super(props);
        this.state = {
            pages: [], // Datos de los usuarios
            loading: true, // Estado de carga
        };
    }

    componentDidMount() {
        this.fetchPages();
    }

    fetchPages() {
        axios.get("/admin/pages/all")
            .then((response) => {
                this.setState({
                    pages: response.data, // Datos de usuarios
                    loading: false,
                });
            })
            .catch((error) => {
                console.error("Error fetching pages:", error);
                this.setState({ loading: false });
            });
    }

    render() {
        // Definir las columnas para la tabla
        const columns = [
            {
                name: "Identifier",
                selector: row => row.identifier,
                sortable: true,
            },
            {
                name: "type",
                selector:  row => row.type,
                sortable: true,
            }
            
        ];

        return (
            <div>
                {this.state.loading ? (
                    <p>Loading...</p>
                ) : (
                    <CustomDataTable
                        title="Pages"
                        columns={columns}
                        data={this.state.pages}
                        editRoute={'/admin/page'}
                    />
                )}
            </div>
        );
    }
}

export default PageTable;
