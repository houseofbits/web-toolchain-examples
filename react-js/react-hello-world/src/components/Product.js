import React from 'react';

export default
class Product extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            brand: "",
            model: "",
            color: ""
        };
    }
    render() {
        let imageLink = "https://picsum.photos/200?random=" + this.props.imageId;
        return (<div className="card bg-light">
            <img className="card-img-top" src={imageLink} alt="Card"/>
                <div className="card-body">
                    <h4 className="card-title">{this.props.title}</h4>
                    <div className="btn-group btn-group-sm">
                        <span className="btn btn-primary" onClick={this.props.editHandler}>Edit</span>
                        <span className="btn btn-danger" onClick={this.props.deleteHandler}>Delete</span>
                    </div>
                </div>
        </div>);
    }
}

