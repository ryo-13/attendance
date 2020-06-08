window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

Vue.component('navbar', require('./components/Layouts/Navbar.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/index', component: require('./components/Articles/Index.vue').default },
        { path: '/attendance', component: require('./components/Attendance.vue').default },
    ]
})

new Vue({
    router,
    el: '#app'
})
