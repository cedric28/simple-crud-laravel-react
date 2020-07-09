import React from "react";

const Input = ({ name, label, error, ...rest }) => {
  return (
    <div className="form-group row">
      <label className="col-lg-2 col-form-label" htmlFor={name}>{label}</label>
      <div className="col-lg-10">
        <input {...rest} name={name} id={name} className="form-control h-auto" />
        {error && <span className="text-danger">{error}</span>}
      </div>
    </div>
  );
};

export default Input;
