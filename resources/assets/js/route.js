import VueRouter from 'vue-router';

let routes = [
    {
        path: '/main',
        component: require('./views/Home')
    },

    {       
        path: '/booking',
        component: require('./views/Booking')
    },

    {
        path: '/shipment',
        component: require('./views/Shipment')
    },
    // {
    //     path: '/report',
    //     component: require('./views/Report')
    // },      
    
    // {   
    //     path: '*',
    //     //component: fourohfour
    //     component: require('./views/Fourohfour')
    // },
];

export default new VueRouter({
    routes,
    linkActiveClass: 'active',
    mode: 'history'
    //base: '/'
});