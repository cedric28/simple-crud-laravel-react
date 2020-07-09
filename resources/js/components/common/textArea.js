import React from "react";

const TextArea = ({ name, label, error, ...rest }) => {
  return (
    <div className="form-group row">
      <label className="col-lg-2 col-form-label" htmlFor={name}>{label}</label>
      <div className="col-lg-10">
        <textarea {...rest} className="form-control h-auto" name={name} id={name}></textarea>
        {error && <span className="text-danger">{error}</span>}
      </div>
    </div>
  );
};

export default TextArea;
