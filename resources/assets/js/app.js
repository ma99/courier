
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);


//Vue.component('example-component', require('./components/ExampleComponent.vue'));

// import App from './views/App'
// import Hello from './views/Hello'
// import Home from './views/Home'

// const app = new Vue({
//     el: '#app',

//     router
// });
Vue.component('show-alert', require('./components/Alert.vue'));
Vue.component('high-light', require('./components/Highlighter.vue'));
Vue.component('loader', require('./components/Loader.vue'));
Vue.component('vue-pagination', require('./components/Pagination.vue'));

//components
import App from './views/App'
import Booking from './views/Booking'
import Shipment from './views/Shipment'
import Home from './views/Home'
import Report  from './views/Report'
import Search  from './views/Search'
import Register  from './views/Register'
import Item  from './views/Item'


const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/main',
            name: 'home',
            component: Home
        },
        {
            path: '/booking',
            name: 'booking',
            component: Booking
        },
        {
            path: '/shipment',            
            component: Shipment
        },
        {
            path: '/report',            
            component: Report
        },
        {
            path: '/search',            
            component: Search
        },
        {
            path: '/item',            
            component: Item
        },          
        {
            path: '/user-register', 
            'name': 'register',           
            component: Register
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
