import React, { Component } from "react";
import ReactDOM from "react-dom";
import EmployeeTable from "./employeeTable";
import Pagination from "../common/pagination";
import {
    getEmployees,
    searchEmployee,
    deleteEmployee,
    getResult
} from "../../services/employeeService";
import { paginate } from "../../utils/paginate";
import _ from "lodash";
import SearchBox from "../common/searchBox";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

class Index extends Component {
    state = {
        employees: [],
        currentPage: 1,
        pageSize: 4,
        searchQuery: "",
        total: 0,
        sortColumn: { path: "first_name", order: "asc" }
    };

    async componentDidMount() {
        const employeeList = await getEmployees();
        const employees = employeeList.data.employees.data;
        const currentPage = employeeList.data.employees.current_page;
        const pageSize = employeeList.data.employees.per_page - 1;
        const total = employeeList.data.employees.total;
        this.setState({ employees, currentPage, pageSize, total });
    }

    handlePageChange = async selectedPage => {
        const result = await getResult(selectedPage);
        const currentPage = result.data.employees.current_page;
        const employees = result.data.employees.data;
        this.setState({ currentPage, employees });
    };

    handleSearch = async e => {
        if (e.key === "Enter") {
            const query = e.target.value;
            const employees = await this.getSearchResult(query);
            this.setState({ searchQuery: query, employees, currentPage: 1 });
        }
    };

    handleSort = sortColumn => {
        this.setState({ sortColumn });
    };

    handleDelete = async employee => {
        const originalEmployees = this.state.employees;
        const employees = originalEmployees.filter(m => m.id !== employee.id);
        this.setState({ employees });

        try {
            await deleteEmployee(employee.id)
                .then(response => {
                    const result = response.data;
                    toast.success(result.message, {
                        position: toast.POSITION.TOP_RIGHT
                    });

                    this.setState({ total: employees.length });
                })
                .catch(error => {
                    if (
                        error.response &&
                        (error.response.status === 404 ||
                            error.response.status === 500)
                    ) {
                        const errors = error.response.data.message;
                        this.setState({ errors });
                    }
                });
        } catch (ex) {
            if (ex.response && ex.response.status === 404)
                toast.error("This employee has already been deleted.", {
                    position: toast.POSITION.TOP_RIGHT
                });

            this.setState({ employees: originalEmployees });
        }
    };

    getPagedData = () => {
        const {
            pageSize,
            currentPage,
            sortColumn,
            employees: allEmployees,
            total: AllTotal
        } = this.state;

        const filtered = allEmployees;
        const totalCount = AllTotal;

        const sorted = _.orderBy(
            filtered,
            [sortColumn.path],
            [sortColumn.order]
        );
        const latestPage = currentPage > 1 ? 1 : currentPage;
        const employees = paginate(sorted, latestPage, pageSize);

        return { totalCount, employees };
    };

    getSearchResult = async searchQuery => {
        const result = await searchEmployee(searchQuery);
        const employees = result.data.employees.data;
        return employees;
    };
    render() {
        const { length: count } = this.state.employees;
        const { pageSize, currentPage, sortColumn } = this.state;

        if (count === 0)
            return (
                <div className="pace-demo bg-dark">
                    <div className="theme_squares">
                        <div
                            className="pace-progress"
                            data-progress-text="60%"
                            data-progress="60"
                        ></div>
                        <div className="pace_activity"></div>
                    </div>
                </div>
            );

        const { totalCount, employees } = this.getPagedData();

        return (
            <React.Fragment>
                <ToastContainer />

                <div className="row">
                    <div className="col-lg-12">
                        <p>Showing {totalCount} employees in the database.</p>
                        <SearchBox onKeyPress={this.handleSearch} />
                        <EmployeeTable
                            employees={employees}
                            sortColumn={sortColumn}
                            onDelete={this.handleDelete}
                            onSort={this.handleSort}
                        />
                        <div className="text-center">
                            <Pagination
                                itemsCount={totalCount}
                                pageSize={pageSize}
                                currentPage={currentPage}
                                onPageChange={this.handlePageChange}
                            />
                        </div>
                    </div>
                </div>
            </React.Fragment>
        );
    }
}

export default Index;

if (document.getElementById("employee")) {
    ReactDOM.render(<Index />, document.getElementById("employee"));
}
