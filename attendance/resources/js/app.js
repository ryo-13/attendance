window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

Vue.component('navbar', require('./components/Layouts/Navbar.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/attendance', component: require('./components/Attendance.vue').default },
    ]
})

new Vue({
    router,
    el: '#app'
})
