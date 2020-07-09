import React from "react";

const Select = ({ name, label, options, error, ...rest }) => {
  return (
    <div className="form-group row">
      <label className="col-lg-2 col-form-label" htmlFor={name}>{label}</label>
      <div className="col-lg-10">
        <select name={name} id={name} {...rest} className="form-control">
          <option value="" >Select Type</option>
          {options.map(option => (
            <option key={option.id} value={option.type}>
              {option.type.toUpperCase()}
            </option>
          ))}
        </select>
        {error && <div className="alert alert-danger">{error}</div>}
      </div>
    </div>
  );
};

export default Select;
