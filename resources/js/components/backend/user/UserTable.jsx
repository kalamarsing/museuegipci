// resources/js/components/UserTable.js
import React, { Component } from "react";
import CustomDataTable from "./../common/DataTable";
import axios from "axios";

class UserTable extends Component {
    constructor(props) {
        super(props);
        this.state = {
            users: [], // Datos de los usuarios
            loading: true, // Estado de carga
        };
    }

    componentDidMount() {
        this.fetchUsers();
    }

    fetchUsers() {
        axios.get("/admin/users/all")
            .then((response) => {
                this.setState({
                    users: response.data, // Datos de usuarios
                    loading: false,
                });
            })
            .catch((error) => {
                console.error("Error fetching users:", error);
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
                name: "Name",
                selector:  row => row.name,
                sortable: true,
            },
            {
                name: "Email",
                selector:  row => row.email,
                sortable: true,
            }
        ];

        return (
            <div>
                {this.state.loading ? (
                    <p>Loading...</p>
                ) : (
                    <CustomDataTable
                        title="Users"
                        columns={columns}
                        data={this.state.users}
                        editRoute="/admin/user" 
                    />
                )}
            </div>
        );
    }
}

export default UserTable;
