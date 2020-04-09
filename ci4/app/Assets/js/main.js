import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap-vue/dist/bootstrap-vue.css"
import App from '../vue/app.vue'

Vue.use(BootstrapVue)

new Vue({
    el: '#app',
    render: h => h(App)
});
