window.Vue = require('vue');

require('./bootstrap');

import dayjs from 'dayjs';
import 'dayjs/locale/ja';
dayjs.locale('ja');

import Vue from 'vue';
import VueRouter from 'vue-router';

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(Loading);

Vue.use(VueRouter);
Vue.prototype.$dayjs = dayjs;

Vue.component('navbar', require('./components/Layouts/Navbar.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/attendance', component: require('./components/Attendance.vue').default },
        { path: '/user', component: require('./components/User.vue').default },
        { path: '/overtime', component: require('./components/Overtime.vue').default },
        { path: '/late', component: require('./components/Late.vue').default },
    ]
});

new Vue({
    router,
    el: '#app',
});
