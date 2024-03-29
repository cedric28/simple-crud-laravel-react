import React from "react";
import TableHeader from "./tableHeader";
import TableBody from "./customUsersTableBody";

const Table = ({ columns, sortColumn, onSort, data }) => {
  return (
    <table className="table table-bordered table-hover">
      <TableHeader columns={columns} sortColumn={sortColumn} onSort={onSort} />
      <TableBody columns={columns} data={data} />
    </table>
  );
};

export default Table;
