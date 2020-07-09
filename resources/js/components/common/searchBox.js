import React from "react";

const SearchBox = ({ onKeyPress }) => {
  return (
    <div className="form-group form-group-feedback form-group-feedback-left my-3">
        <input 
            type="text" 
            className="form-control form-control-lg" 
            placeholder="Search..."
            name="query"
            onKeyPress={e => onKeyPress(e)}
        />
        <div className="form-control-feedback form-control-feedback-lg">
            <i className="icon-search4"></i>
        </div>
    </div>
  );
};

export default SearchBox;
