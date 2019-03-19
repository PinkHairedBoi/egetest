import Vue from 'vue';
import Buefy from 'buefy'
import axios from 'axios';
import router from './routes';

window.axios = axios;
window.Vue = Vue;
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};
import VueRouter from 'vue-router';
Vue.use(VueRouter);
Vue.use(Buefy, {"defaultIconPack": 'fa'});
new Vue({
    data: {
        isOpen: false
    },
    el: '#admin',
    router
});