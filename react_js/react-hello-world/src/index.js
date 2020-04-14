import React from 'react';
import ReactDOM from 'react-dom';
import "bootstrap/dist/css/bootstrap.min.css"
import {Button} from 'react-bootstrap';
import Product from './components/Product';
import EditProduct from './components/EditProduct';

class ProductList extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            editorModalVisible: false,
            products: [],
            editId: null
        };
    }
    closeModal = () => {
        this.setState({editorModalVisible: false});
    };
    deleteProduct = (id) => {
        if(id !== null){
            let produstsList = this.state.products;
            produstsList.splice(id, 1);
            this.setState({products:produstsList});
        }
    };
    openEditModal = (id) => {
        this.setState({editId: id});
        this.setState({editorModalVisible: true});
    };
    openCreateModal = () => {
        this.setState({editId: null});
        this.setState({editorModalVisible: true});
    };
    saveProduct = (id, data) => {
        if(id !== null){
            let produstsList = this.state.products;
            produstsList[id] = data;
            this.setState({products:produstsList});
        } else {
            this.state.products.push(data);
        }
        this.closeModal();
    };
    getProduct = (id) => {
        if(typeof id !== 'undefined'){
            if(this.state.products.hasOwnProperty(id)){
                return this.state.products[id];
            }
        }
        return null;
    };
    render() {

        const productList= this.state.products.map((d, index) => <Product key={index} imageId={d.imageId} title={d.name} deleteHandler={() => this.deleteProduct(index)} editHandler={() => this.openEditModal(index)}/>);

        let editor = null;

        if(this.state.editorModalVisible){
            editor = <EditProduct closeHandler={this.closeModal}
                              saveHandler={this.saveProduct}
                              productKey={this.state.editId}
                              data={this.getProduct(this.state.editId)}/>
        }

        return (
            <div>
                <nav className="navbar navbar-expand-sm bg-dark mb-3">
                    <Button variant="primary" onClick={this.openCreateModal}>Add product</Button>
                </nav>
                <div className="container">
                    <div className="card-deck">
                        {productList}
                    </div>
                </div>
                {editor}
            </div>
        );
    }
}

ReactDOM.render(<ProductList />, document.getElementById('root'));
