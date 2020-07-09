import React, { Component } from "react";
import Table from "../common/customUsersTable";

class UsersTable extends Component {
  columns = [
   
    { path: "name", label: "Fullname" },
    { path: "email", label: "Email" },
    { path: "role", label: "Role" },
    {
      key: "view",
      label: "Action",
      content: user => (
        <React.Fragment>
          <a 
            style={{cursor: "pointer"}} 
            className="btn btn-primary  mr-2" 
            onClick={event =>  window.location.href=`/users/${user.id}`}
          >
            <i className="icon-list-unordered  mr-2"></i> 
            View
          </a>
          <a 
            style={{cursor: "pointer"}} 
            className="btn btn-success" 
            onClick={event =>  window.location.href=`/users/${user.id}/edit`}
          >
            <i className="icon-pencil7  mr-2"></i> 
            Edit
          </a>
        </React.Fragment>
      )
    }
  ];

  render() {
    const { users, onSort, sortColumn } = this.props;

    return (
      <Table
        columns={this.columns}
        data={users}
        sortColumn={sortColumn}
        onSort={onSort}
      />
    );
  }
}

export default UsersTable;
