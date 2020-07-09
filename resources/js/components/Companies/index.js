import React, { Component } from "react";
import ReactDOM from "react-dom";
import CompanyTable from "./companyTable";
import Pagination from "../common/pagination";
import {
    getCompanies,
    searchCompany,
    deleteCompany,
    getResult
} from "../../services/companyService";
import { paginate } from "../../utils/paginate";
import _ from "lodash";
import SearchBox from "../common/searchBox";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

class Index extends Component {
    state = {
        companies: [],
        currentPage: 1,
        pageSize: 4,
        searchQuery: "",
        total: 0,
        sortColumn: { path: "name", order: "asc" }
    };

    async componentDidMount() {
        const companyList = await getCompanies();
        const companies = companyList.data.companies.data;
        const currentPage = companyList.data.companies.current_page;
        const pageSize = companyList.data.companies.per_page - 1;
        const total = companyList.data.companies.total;
        this.setState({ companies, currentPage, pageSize, total });
    }

    handlePageChange = async selectedPage => {
        const result = await getResult(selectedPage);
        const currentPage = result.data.companies.current_page;
        const companies = result.data.companies.data;
        this.setState({ currentPage, companies });
    };

    handleSearch = async e => {
        if (e.key === "Enter") {
            const query = e.target.value;
            const companies = await this.getSearchResult(query);
            this.setState({ searchQuery: query, companies, currentPage: 1 });
        }
    };

    handleSort = sortColumn => {
        this.setState({ sortColumn });
    };

    getPagedData = () => {
        const {
            pageSize,
            currentPage,
            sortColumn,
            companies: allCompanies,
            total: AllTotal
        } = this.state;

        const filtered = allCompanies;
        const totalCount = AllTotal;

        const sorted = _.orderBy(
            filtered,
            [sortColumn.path],
            [sortColumn.order]
        );
        const latestPage = currentPage > 1 ? 1 : currentPage;
        const companies = paginate(sorted, latestPage, pageSize);

        return { totalCount, companies };
    };

    handleDelete = async company => {
        const originalCompanies = this.state.companies;
        const companies = originalCompanies.filter(m => m.id !== company.id);
        this.setState({ companies });

        try {
            await deleteCompany(company.id)
                .then(response => {
                    const result = response.data;
                    toast.success(result.message, {
                        position: toast.POSITION.TOP_RIGHT
                    });

                    this.setState({ total: companies.length });
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
                toast.error("This company has already been deleted.", {
                    position: toast.POSITION.TOP_RIGHT
                });

            this.setState({ companies: originalCompanies });
        }
    };

    getSearchResult = async searchQuery => {
        const result = await searchCompany(searchQuery);
        const companies = result.data.companies.data;
        return companies;
    };
    render() {
        const { length: count } = this.state.companies;
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

        const { totalCount, companies } = this.getPagedData();

        return (
            <React.Fragment>
                <ToastContainer />
                <div className="row">
                    <div className="col-lg-12">
                        <p>Showing {totalCount} companies in the database.</p>
                        <SearchBox onKeyPress={this.handleSearch} />
                        <CompanyTable
                            companies={companies}
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

if (document.getElementById("company")) {
    ReactDOM.render(<Index />, document.getElementById("company"));
}
