import React, { Component } from "react";
import Table from "../common/table";

class EmployeeTable extends Component {
    columns = [
        {
            path: "first_name",
            label: "Firstname"
        },
        {
            path: "last_name",
            label: "Lastname"
        },
        { path: "email", label: "Email" },
        { path: "phone", label: "Phone" },
        {
            key: "view",
            label: "Action",
            content: employee => (
                <React.Fragment>
                    <a
                        style={{ cursor: "pointer" }}
                        className="btn btn-primary  mr-2"
                        onClick={event =>
                            (window.location.href = `/employees/${employee.id}`)
                        }
                    >
                        <i className="icon-list-unordered  mr-2"></i>
                        View
                    </a>
                    <a
                        style={{ cursor: "pointer" }}
                        className="btn btn-success mr-2"
                        onClick={event =>
                            (window.location.href = `/employees/${employee.id}/edit`)
                        }
                    >
                        <i className="icon-pencil7  mr-2"></i>
                        Edit
                    </a>

                    <a
                        style={{ cursor: "pointer" }}
                        className="btn btn-danger"
                        onClick={() => this.props.onDelete(employee)}
                    >
                        <i className="icon-trash mr-2"></i>
                        Delete
                    </a>
                </React.Fragment>
            )
        }
    ];

    render() {
        const { employees, onSort, sortColumn } = this.props;

        return (
            <Table
                columns={this.columns}
                data={employees}
                sortColumn={sortColumn}
                onSort={onSort}
            />
        );
    }
}

export default EmployeeTable;
