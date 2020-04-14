import React from 'react';
import {Modal,Button} from 'react-bootstrap';

export default
class EditProduct extends React.Component {
    constructor(props) {
        super(props);
        let data = {};
        if(this.props.data !== null)data = this.props.data;
        this.state = {
            name: data.name || '',
            imageId: data.imageId || ''
        };
    }
    saveClose = () => {
        let productId = null;
        if (typeof this.props.productKey !== 'undefined' && this.props.productKey !== null) {
            productId = this.props.productKey;
        }
        this.props.saveHandler(productId, this.state);
    };
    myChangeHandler = (event) => {
        let nam = event.target.name;
        let val = event.target.value;
        this.setState({[nam]: val});
    };
    render() {
        let title = "New product";
        let headerStyle = 'bg-primary pt-2 pb-2';
        if (typeof this.props.productKey !== 'undefined' && this.props.productKey !== null) {
           title = "Edit product";
            headerStyle = 'bg-success pt-2 pb-2';
        }

        return(<Modal show={true} onHide={this.props.closeHandler}>
            <Modal.Header closeButton className={headerStyle}>
                <Modal.Title>{title}</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <div className="form-group">
                    <label htmlFor="name">Name:</label>
                    <input type="text" className="form-control" id="name" name="name" value={this.state.name} onChange={this.myChangeHandler}/>
                </div>
                <div className="form-group">
                    <label htmlFor="imageId">Image Id:</label>
                    <select className="form-control" id="imageId" name="imageId" value={this.state.imageId} onChange={this.myChangeHandler}>
                        <option></option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
            </Modal.Body>
            <Modal.Footer className="bg-light">
                <Button variant="secondary" onClick={this.props.closeHandler}>
                    Close
                </Button>
                <Button variant="primary" onClick={this.saveClose}>
                    Save Changes
                </Button>
            </Modal.Footer>
        </Modal>);
    }
}

