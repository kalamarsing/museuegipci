// resources/js/components/CodeTable.js
import React, { Component } from "react";
import CustomDataTable from "./../common/DataTable";
import axios from "axios";

class CodeTable extends Component {
    constructor(props) {
        super(props);
        this.state = {
            codes: [], // Datos de los usuarios
            loading: true, // Estado de carga
        };
    }

    componentDidMount() {
        this.fetchCodes();
    }

    fetchCodes() {
        axios.get("/admin/codes/all")
            .then((response) => {
                this.setState({
                    codes: response.data, // Datos de usuarios
                    loading: false,
                });
            })
            .catch((error) => {
                console.error("Error fetching codes:", error);
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
                name: "value",
                selector:  row => row.value,
                sortable: true,
            }
            
        ];

        return (
            <div>
                {this.state.loading ? (
                    <p>Loading...</p>
                ) : (
                    <CustomDataTable
                        title="Codes"
                        columns={columns}
                        data={this.state.codes}
                        editRoute="/admin/code" 
                    />
                )}
            </div>
        );
    }
}

export default CodeTable;
