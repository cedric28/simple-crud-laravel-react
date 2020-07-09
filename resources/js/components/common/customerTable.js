import React from "react";
import TableHeader from "./tableHeader";
import TableBody from "./customerTableBody";

const Table = ({ columns, sortColumn, onSort, data }) => {
  return (
    <table className="table table-dark table-bordered table-hover">
      <TableHeader columns={columns} sortColumn={sortColumn} onSort={onSort} />
      <TableBody columns={columns} data={data} />
    </table>
  );
};

export default Table;
