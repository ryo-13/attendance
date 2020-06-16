require('./bootstrap')

window.Vue = require('vue');

import dayjs from 'dayjs'
import 'dayjs/locale/ja';
dayjs.locale('ja');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
Vue.prototype.$dayjs = dayjs;

Vue.component('navbar', require('./components/Layouts/Navbar.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/attendance', component: require('./components/Attendance.vue').default },
        { path: '/user', component: require('./components/User.vue').default },
    ]
})

new Vue({
    router,
    el: '#app',
})
