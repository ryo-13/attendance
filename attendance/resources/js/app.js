window.Vue = require('vue');

import Dayjs from 'vue-dayjs';
Vue.use(Dayjs)
import 'dayjs/locale/ja';

import Vue from 'vue'
import VueRouter from 'vue-router'

require('./bootstrap')

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
