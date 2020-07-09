// import React from "react";
// import PropTypes from "prop-types";
// import _ from "lodash";

// const Pagination = ({ itemsCount, pageSize, currentPage, onPageChange }) => {
// //   const pagesCount = Math.ceil(itemsCount / pageSize);
// //   if (pagesCount === 1) return null;
// //   const pages = _.range(1, pagesCount + 1);

// //   return (

// //       <ul className="pagination pagination-flat align-self-center">
// //         <li className="page-item"><a href="#" className="page-link">&larr; &nbsp; Prev</a></li>
// //         {pages.map(page => (
// //           <li
// //             key={page}
// //             className={page === currentPage ? "page-item active" : "page-item"}
// //           >
// //             <a className="page-link" onClick={() => onPageChange(page)}>
// //               {page}
// //             </a>
// //           </li>
// //         ))}
// //         <li className="page-item"><a href="#" className="page-link">Next &nbsp; &rarr;</a></li>
// //       </ul>
    
// //   );
// };

// Pagination.propTypes = {
//   itemsCount: PropTypes.number.isRequired,
//   pageSize: PropTypes.number.isRequired,
//   currentPage: PropTypes.number.isRequired,
//   onPageChange: PropTypes.func.isRequired
// };

// export default Pagination;

import React from "react";
import PropTypes from "prop-types";
import _ from "lodash";
import Pagination from '@material-ui/lab/Pagination';
import { withStyles } from '@material-ui/core/styles';

const styles = theme  => ({
  paginate: {
    marginTop: theme.spacing(3),
    marginLeft: 'auto',
    marginRight: 'auto'
  },
});

const PaginationMain = ({ itemsCount, pageSize, currentPage, onPageChange, classes}) => {
  const pagesCount = Math.ceil(itemsCount / pageSize);
  if (pagesCount === 1) return null;
  const pages = _.range(1, pagesCount + 1);
  const count = pages.length;
  const handleChange = (event, value) => {
    onPageChange(value);
  };

  return (
    <div className={classes.paginate}>
      <Pagination
        page={currentPage}
        count={count}
        color="primary"
        onChange={handleChange}
      />
    </div>
    
  );
};

PaginationMain.propTypes = {
  itemsCount: PropTypes.number.isRequired,
  pageSize: PropTypes.number.isRequired,
  currentPage: PropTypes.number.isRequired,
  onPageChange: PropTypes.func.isRequired
};

export default withStyles(styles)(PaginationMain);