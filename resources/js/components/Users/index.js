import React, { Component } from "react";
import ReactDOM from 'react-dom';
import UsersTable from "./usersTable";
import Pagination from "../common/pagination";
import { getUsers, searchUser, getResult } from "../../services/userService";
import { paginate } from "../../utils/paginate";
import _ from "lodash";
import SearchBox from "../common/searchBox";

class Index extends Component {
  
  state = {
      users: [],
      currentPage: 1,
      pageSize: 4,
      searchQuery: "",
      total: 0,
      sortColumn: { path: "firstName", order: "asc" }
  };

  async componentDidMount() {
    const usersList = await getUsers();
    const users = usersList.data.users.data;
    const currentPage = usersList.data.users.current_page;
    const pageSize = usersList.data.users.per_page - 1;
    const total = usersList.data.users.total;
    this.setState({ users, currentPage, pageSize, total });
  }

  handlePageChange = async selectedPage => {
    const result = await getResult(selectedPage);
    const currentPage = result.data.users.current_page;
    const users = result.data.users.data;
    this.setState({ currentPage, users });
  };

  handleSearch = async e => {
    if(e.key === 'Enter'){
      const query = e.target.value;
      const users = await this.getSearchResult(query);
      this.setState({ searchQuery: query, users, currentPage: 1 });
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
        users: allUsers,
        total: AllTotal
      } = this.state;

      const filtered = allUsers;
      const totalCount = AllTotal;
        
      const sorted = _.orderBy(filtered, [sortColumn.path], [sortColumn.order]);
      const latestPage = currentPage > 1 ?  1 : currentPage; 
      const users = paginate(sorted, latestPage, pageSize);
      
      return { totalCount, users };
  };

  getSearchResult = async searchQuery => {
    const result = await searchUser(searchQuery);
    const users = result.data.users.data;
    return users;
  }
  render() {

    const { length: count } = this.state.users;
    const { pageSize, currentPage, sortColumn } = this.state;
    

    if (count === 0) return (
      <div className="pace-demo bg-dark">
        <div className="theme_squares">
          <div className="pace-progress" data-progress-text="60%" data-progress="60"></div>
          <div className="pace_activity"></div>
        </div>
      </div>
    );

    const { totalCount, users } = this.getPagedData();

    return (
      <div className="row">
        <div className="col-lg-12">
            <p>Showing {totalCount} users in the database.</p>          
            <SearchBox onKeyPress={this.handleSearch} />
            <UsersTable
                users={users}
                sortColumn={sortColumn}
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
    );
  }
}

export default Index;

if (document.getElementById('user')) {
    ReactDOM.render(
        <Index />
    , document.getElementById('user'));
}
