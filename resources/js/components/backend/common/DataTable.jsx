// resources/js/components/DataTable.js
import React, { Component } from "react";
import DataTable from "react-data-table-component";

class CustomDataTable extends Component {
    handleRowClicked(row) {
        const { editRoute } = this.props;
        window.location.href = `${editRoute}/${row.id}`;
    }

    render() {
        // Agregar una columna para 'Actions' si se solicita
        const columns = [
            ...this.props.columns,
            {
                name: "Actions",
                selector: "actions",
                cell: row => (
                    <div style={{ padding: '10px' }}>
                        <a href={`${this.props.editRoute}/${row.id}`}  >
                            <i className="fas fa-pencil-alt"></i> {/* Icono de lápiz */}
                        </a>
                        
                    </div>
                ),
                ignoreRowClick: true, // Para evitar la interacción no deseada en esta columna
                allowOverflow: true,
                button: true,
            },
        ];

        return (
            <DataTable
                title={this.props.title}
                columns={columns}
                data={this.props.data}
                highlightOnHover // Resaltar filas al pasar el ratón
                onRowClicked={row => this.handleRowClicked(row)} // Manejar clic en la fila
                customStyles={{
                    rows: {
                        style: {
                            cursor: 'pointer' 
                        },
                    },
                }}
            />
        );
    }
}



export default CustomDataTable;
