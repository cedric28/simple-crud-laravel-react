import React, { Component } from "react";
import Moment from 'react-moment';
import _ from "lodash";

class TableBody extends Component {
  renderCell = (item, column) => {
    if (column.content) return column.content(item);

    return _.get(item, column.path);
  };

  createKey = (item, column) => {
    return item.id + (column.path || column.key);
  };

  render() {
    const { data, columns } = this.props;
   
    return (
      <tbody>
        {data.map(item => (
          <tr key={item.id}>
                <td>
                  {item.name}
                </td>


                <td>
                  {item.email}
                </td>

                <td>
                    {item.roles.map(item => (
                        <span key={item.id}>{item.name}</span>
                    ))}
                </td>
              
                <td>
                    <a 
                        style={{cursor: "pointer"}} 
                        className="btn btn-primary mr-2" 
                        onClick={event =>  window.location.href=`/users/${item.id}`}
                    >
                        <i className="icon-list-unordered  mr-2"></i> 
                        View
                    </a>
                    <a 
                        style={{cursor: "pointer"}} 
                        className="btn btn-success mr-2" 
                        onClick={event =>  window.location.href=`/users/${item.id}/edit`}
                    >
                        <i className="icon-pencil7  mr-2"></i> 
                        Edit
                    </a>
                </td>
          </tr>
        ))}
      </tbody>
    );
  }
}

export default TableBody;
