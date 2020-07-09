import React, { Component } from "react";
import Table from "../common/table";

class CompanyTable extends Component {
    columns = [
        {
            path: "name",
            label: "Company Name"
        },
        { path: "email", label: "Email" },
        { path: "website", label: "Website" },
        {
            key: "view",
            label: "Action",
            content: company => (
                <React.Fragment>
                    <a
                        style={{ cursor: "pointer" }}
                        className="btn btn-primary  mr-2"
                        onClick={event =>
                            (window.location.href = `/companies/${company.id}`)
                        }
                    >
                        <i className="icon-list-unordered"></i>
                        View
                    </a>
                    <a
                        style={{ cursor: "pointer" }}
                        className="btn btn-success"
                        onClick={event =>
                            (window.location.href = `/companies/${company.id}/edit`)
                        }
                    >
                        <i className="icon-pencil7  mr-2"></i>
                        Edit
                    </a>

                    <a
                        style={{ cursor: "pointer" }}
                        className="btn btn-danger"
                        onClick={() => this.props.onDelete(company)}
                    >
                        <i className="icon-trash mr-2"></i>
                        Delete
                    </a>
                </React.Fragment>
            )
        }
    ];

    render() {
        const { companies, onSort, sortColumn } = this.props;

        return (
            <Table
                columns={this.columns}
                data={companies}
                sortColumn={sortColumn}
                onSort={onSort}
            />
        );
    }
}

export default CompanyTable;
