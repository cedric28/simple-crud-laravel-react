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
                {item.refId}
              </td>
              <td>
                <Moment format="MMMM Do YYYY">
                  {item.created_at}
                </Moment>
               
              </td>
              <td>
                {item.billing.firstName}  {item.billing.lastName}
              </td>
              <td>
                ₱{item.total}
              </td>
              <td>
                
                {item.status === 'S' ? 
                  <span className="badge bg-success badge-pill">{item.status}</span> 
                  : 
                  <span className="badge bg-danger badge-pill">{item.status}</span>
                }
              </td>
              <td>
                {item.shipped === 0 ? 
                  <span className="badge bg-warning badge-pill">Pending</span> 
                  : 
                  <span className="badge bg-success badge-pill">Success</span>
                }
              </td>
              <td>
                <a 
                    style={{cursor: "pointer"}} 
                    className="btn btn-primary mr-2" 
                    onClick={event =>  window.location.href=`/orders/${item.id}`}
                  >
                    <i className="icon-list-unordered  mr-2"></i> 
                    View
                  </a>
                  <a 
                    style={{cursor: "pointer"}} 
                    className="btn btn-success mr-2" 
                    onClick={event =>  window.location.href=`/orders/${item.id}/edit`}
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
