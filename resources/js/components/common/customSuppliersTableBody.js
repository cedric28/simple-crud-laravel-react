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
                    <Moment format="MMMM Do YYYY">
                    {item.created_at}
                    </Moment>
                </td>              
          </tr>
        ))}
      </tbody>
    );
  }
}

export default TableBody;
