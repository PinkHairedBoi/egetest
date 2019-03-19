import Vue from 'vue';
import Buefy from 'buefy'
import axios from 'axios';

window.axios = axios;
window.Vue = Vue;
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};
Vue.use(Buefy, {
    "defaultIconPack": 'fa'
});

Vue.component('test', require('./Test.vue').default);

new Vue({
    el: '#test',
});
