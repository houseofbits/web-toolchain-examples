<template>
    <div class="container mt-3">
        <h2>Products</h2>

        <b-alert variant="danger" show dismissible v-for="(error, index) in errors" :key="index">{{error}}</b-alert>

        <b-table
                ref="selectableTable"
                selectable
                select-mode="multi"
                :items="products"
                :fields="['id', 'product_type', 'name', 'created_at', 'updated_at']"
                @row-selected="onRowSelected"
                responsive="sm"
                :busy="isBusy">
            <template v-slot:table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>
            <template v-slot:cell(product_type)="data">
                {{ productTypeStr(data.value) }}
            </template>
            <template v-slot:cell(name)="data">
                <b-link @click="editProduct(data.item.id)">{{ data.value }}</b-link>
            </template>
        </b-table>

        <p>
            <b-button variant="primary" size="sm" v-b-modal.modal-create>Create product</b-button>
            <b-button size="sm" @click="selectAllRows">Select all</b-button>
            <b-button size="sm" @click="clearSelected">Clear selected</b-button>
            <b-button v-if="selected&&selected.length>0" variant="danger" size="sm" @click="deleteSelected">Delete</b-button>
        </p>

        <b-modal id="modal-create" title="Create product" @ok="createProduct" footer-bg-variant="light" header-bg-variant="light">
            <b-form>
                <b-form-group
                        id="fieldset-1"
                        label="Choose product type"
                        label-for="type-select"
                        :invalid-feedback="formError('product_type')"
                        :state="isValid('product_type')">
                    <b-form-select v-model="formCreate.product_type" :options="options" id="type-select" :state="isValid('product_type')"></b-form-select>
                </b-form-group>
                <b-form-group
                        id="fieldset-1"
                        label="Choose product type"
                        label-for="name-text"
                        :invalid-feedback="formError('name')"
                        :state="isValid('name')">
                    <b-form-input v-model="formCreate.name" placeholder="Enter name of product" id="name-text" :state="isValid('name')"></b-form-input>
                </b-form-group>
                <template v-slot:modal-footer="{ok, cancel}" style="">
                    <b-button variant="success" @click="ok()">Create</b-button>
                    <b-button variant="secondary" @click="cancel()">Cancel</b-button>
                </template>
            </b-form>
        </b-modal>

        <b-modal id="modal-edit" title="Edit product" @ok="updateProduct" footer-bg-variant="light" header-bg-variant="light">
            <b-form>
                <b-form-group
                        id="fieldset-1"
                        label="Choose product type"
                        label-for="type-select"
                        :invalid-feedback="formError('product_type')"
                        :state="isValid('product_type')">
                    <b-form-select v-model="formEdit.product_type" :options="options" id="type-select" :state="isValid('product_type')"></b-form-select>
                </b-form-group>
                <b-form-group
                        id="fieldset-1"
                        label="Choose product type"
                        label-for="name-text"
                        :invalid-feedback="formError('name')"
                        :state="isValid('name')">
                    <b-form-input v-model="formEdit.name" placeholder="Name of product" id="name-text" :state="isValid('name')"></b-form-input>
                </b-form-group>
                <template v-slot:modal-footer="{ok, cancel}" style="">
                    <b-button variant="success" @click="ok()">Save</b-button>
                    <b-button variant="secondary" @click="cancel()">Cancel</b-button>
                </template>
            </b-form>
        </b-modal>

    </div>
</template>

<script>

    import axios from 'axios';

    export default {
        name: "Main",
        data() {
            return {
                products: [],
                errors: [],
                options:[
                    { value: null, text: 'Please select an option' },
                    { value: 1, text: 'TV' },
                    { value: 2, text: 'Computer' },
                    { value: 3, text: 'Toaster' },
                    { value: 4, text: 'Chair' },
                    { value: 5, text: 'Table' },
                ],
                selected:[],
                isBusy:true,
                formCreate:{
                    name:'',
                    product_type:null,
                },
                formEdit:{
                    name:'',
                    product_type:null,
                },
                formErrors:[],
            }
        },
        methods:{
            isValid:function(fieldName) {
                return (typeof this.formErrors[fieldName] === 'undefined');
            },
            formError:function(fieldName){
                if (typeof this.formErrors[fieldName] !== 'undefined') {
                    return this.formErrors[fieldName];
                }
                return '';
            },
            createProduct:function(bvEvent){
                this.errors = [];
                bvEvent.preventDefault();
                this.isBusy = true;
                axios.post(`products/create`, this.formCreate)
                    .then(response => {
                        this.isBusy = false;
                        if(typeof response.data.formErrors !== 'undefined'){
                            this.formErrors = response.data.formErrors;
                            return;
                        }
                        this.products = response.data;
                        this.$bvModal.hide('modal-create');
                    })
                    .catch(e => {
                        this.isBusy = false;
                        this.errors.push(e);
                        this.$bvModal.hide('modal-create');
                    });
            },
            updateProduct:function(bvEvent){
                this.errors = [];
                bvEvent.preventDefault();
                this.isBusy = true;
                axios.post(`products/update/`+this.formEdit.id, this.formEdit)
                    .then(response => {
                        this.isBusy = false;
                        if(typeof response.data.formErrors !== 'undefined'){
                            this.formErrors = response.data.formErrors;
                            return;
                        }
                        this.products = response.data;
                        this.$bvModal.hide('modal-edit');
                    })
                    .catch(e => {
                        this.isBusy = false;
                        this.errors.push(e);
                        this.$bvModal.hide('modal-edit');
                    });
            },
            editProduct:function(id){
                let data = this.products.filter(x => x.id === id);
                if(data.length > 0) {
                    this.formEdit = data[0];
                    this.$bvModal.show('modal-edit');
                }
            },
            deleteSelected:function(){
                this.errors = [];
                this.formErrors = [];
                this.$bvModal.msgBoxConfirm('Are you sure?')
                    .then(value => {
                        if(value === true && this.selected && this.selected.length > 0) {
                            this.isBusy = true;
                            axios.post(`products/delete`, this.selected)
                                .then(response => {
                                    this.products = response.data;
                                    this.isBusy = false;
                                })
                                .catch(e => {
                                    this.isBusy = false;
                                    this.errors.push(e);
                                });

                        }
                    });
            },
            productTypeStr:function(productType){
                let data = this.options.filter(x => x.value === parseInt(productType));
                if(data.length > 0) {
                    return data[0].text;
                }
                return '';
            },
            onRowSelected(items) {
                this.selected = items;
            },
            selectAllRows() {
                this.$refs.selectableTable.selectAllRows()
            },
            clearSelected() {
                this.$refs.selectableTable.clearSelected()
            },
        },
        created() {
            axios.get(`products`)
                .then(response => {
                    this.products = response.data;
                    this.isBusy = false;
                })
                .catch(e => {
                    this.errors.push(e)
                });
        }
    }
</script>
