import React from "react";
import ReactDOM from 'react-dom';
import Joi from "joi-browser";
import Form from "../common/form";
import http from "../../services/httpService";
import { ToastContainer, toast } from 'react-toastify';
import "react-toastify/dist/ReactToastify.css";

class MediaForm extends Form {
  state = {
    data: {
      title: "",
      content: "",
      link: ""
    },
    errors: {}
  };

  schema = {
    id: Joi.number(),
    title: Joi.string()
      .required()
      .label("Title"),
    content: Joi.string()
      .required()
      .label("Content"),
    link: Joi.string()
      .required()
      .label("Link")
  };

  async populateMedia() {
   
    try {
        const media = this.props.data;
        if (media === "") return;
  
        this.setState({ data: this.mapToViewModel(JSON.parse(media)) });
    } catch (ex) {
        if (ex)
            toast.error("An unexpected error occurrred.", {
                position: toast.POSITION.TOP_RIGHT
            });
    }
  }

  async componentDidMount() {

    await this.populateMedia();
  }

  mapToViewModel(media) {
    return {
      id: media.id,
      title: media.title,
      content: media.content,
      link: media.link
    };
  }

  doSubmit = async () => {
    // Call the server
    const apiEndpointMediaStore = "/media-features/";
    const { data } = this.state;
   
    if (data.id) {
      const body = { ...data };
      delete body.id;
      await http.put(apiEndpointMediaStore + data.id, body).then( response => {
        const result = response.data;
        toast.success(result.message, {
          position: toast.POSITION.TOP_RIGHT
        });
        
      }).catch( error => {
        if (error.response && (error.response.status === 404 || error.response.status === 500)){
          const errors = error.response.data.message;
          this.setState({ errors });
        }
      });
    } else {
      await http.post(apiEndpointMediaStore,
        data
      ).then( response => {
        const result = response.data;
        toast.success(result.message, {
          position: toast.POSITION.TOP_RIGHT
        });
        
      }).catch( error => {
        if (error.response && (error.response.status === 404 || error.response.status === 500)){
          const errors = error.response.data.message;
          this.setState({ errors });
        }
      });
    }
  };

  render() {
    return (
        <div>
          <ToastContainer />
            <form onSubmit={this.handleSubmit}>
            {this.renderInput("title", "Title","text","Title")}
            {this.renderTextArea("content", "Content","text","Content")}
            {this.renderInput("link", "Link","text","Ex. https://www.google.com")}
            {this.renderButton("Save")}
            </form>
        </div>
    );
  }
}

export default MediaForm;

if (document.getElementById('media-form')) {
    var data = document.getElementById('media-form').getAttribute('data');
    ReactDOM.render(
        <MediaForm data={data}/>
    , document.getElementById('media-form'));
}

