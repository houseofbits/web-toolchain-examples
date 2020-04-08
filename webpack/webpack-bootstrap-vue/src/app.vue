<template>
  <div class="container">

    <div class="form-group">
      <a href="https://bootstrap-vue.js.org/docs" class="btn btn-info" >BootstrapVue</a>
    </div>

    <div class="form-group">
        <b-alert variant="success" show>Success Alert</b-alert>
    </div>

    <div class="form-group">
        <div>
          <b-dropdown id="dropdown-1" text="Dropdown Button" class="m-md-2">
            <b-dropdown-item>First Action</b-dropdown-item>
            <b-dropdown-item>Second Action</b-dropdown-item>
            <b-dropdown-item>Third Action</b-dropdown-item>
            <b-dropdown-divider></b-dropdown-divider>
            <b-dropdown-item active>Active action</b-dropdown-item>
            <b-dropdown-item disabled>Disabled action</b-dropdown-item>
          </b-dropdown>
        </div>
    </div>

    <div class="form-group">
      <div class="mb-4">
        <b-avatar></b-avatar>
        <b-avatar variant="primary" text="BV"></b-avatar>
        <b-avatar variant="info" src="https://placekitten.com/300/300"></b-avatar>
        <b-avatar variant="success" icon="people-fill"></b-avatar>
      </div>
    </div>

    <div class="form-group">
      <h2>Example heading <b-badge>New</b-badge></h2>
      <h3>Example heading <b-badge>New</b-badge></h3>
      <h4>Example heading <b-badge>New</b-badge></h4>
      <h5>Example heading <b-badge>New</b-badge></h5>
      <h6>Example heading <b-badge>New</b-badge></h6>
    </div>

    <div class="form-group">
      <div class="mt-3">
        <b-button-group>
          <b-button variant="success">Success</b-button>
          <b-button variant="info">Info</b-button>
          <b-button variant="warning">Warning</b-button>
        </b-button-group>
      </div>
    </div>

    <div class="form-group">
      <b-form-datepicker id="example-datepicker" v-model="value" class="mb-2"></b-form-datepicker>
    </div>

    <div class="form-group">
      <b-form-spinbutton id="demo-sb" v-model="value" min="1" max="100"></b-form-spinbutton>
    </div>

    <div class="form-group">
      <b-form-timepicker v-model="value" locale="en"></b-form-timepicker>
    </div>

    <div class="form-group">
      <div class="text-center">
        <b-spinner label="Spinning"></b-spinner>
        <b-spinner type="grow" label="Spinning"></b-spinner>
        <b-spinner variant="primary" label="Spinning"></b-spinner>
        <b-spinner variant="primary" type="grow" label="Spinning"></b-spinner>
        <b-spinner variant="success" label="Spinning"></b-spinner>
        <b-spinner variant="success" type="grow" label="Spinning"></b-spinner>
      </div>
    </div>            

  </div>
</template>

<script>

  export default {
    name: "app",
    data: function(){
      return {
        message: 'Hello from Vue!'
      }
    },
    mounted:function() { }
  }

</script>

<style scoped>

</style>