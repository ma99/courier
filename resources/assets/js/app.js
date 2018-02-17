
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);


//Vue.component('example-component', require('./components/ExampleComponent.vue'));

// import App from './views/App'
// import Hello from './views/Hello'
// import Home from './views/Home'

// const app = new Vue({
//     el: '#app',

//     router
// });

//components
import App from './views/App'
import Booking from './views/Booking'
import Shipment from './views/Shipment'
import Home from './views/Home'

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
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
