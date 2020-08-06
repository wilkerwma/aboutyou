
require('./bootstrap');
require('./utils');

window.Vue = require('vue');

Vue.component('matrix', require('./components/MatrixMultiplicationComponent.vue').default);

const app = new Vue({
    el: '#app',
});
