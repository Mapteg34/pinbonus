require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';

import App from './components/App.vue';

import Home from './components/Home.vue';
import Register from './components/Register.vue';
import Login from './components/Login.vue';
import Cabinets from './components/Cabinets.vue';
import Cabinet from './components/Cabinet.vue';
import Campaign from './components/Campaign.vue';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

axios.defaults.baseURL = $('meta[name=app-url]').attr('content')+'/api';

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },

        {
            path: '/register',
            name: 'register',
            component: Register,
            meta: {
                auth: false,
                title: 'Регистрация',
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                auth: false,
                title: 'Вход в систему',
            }
        },

        {
            path: '/cabinets/:cabinetId/:id',
            name: 'campaign',
            component: Campaign,
            meta: {
                auth: true,
                title: 'Кампания',
            }
        },
        {
            path: '/cabinets/:id',
            name: 'cabinet',
            component: Cabinet,
            meta: {
                auth: true,
                title: 'Кабинет',
            }
        },
        {
            path: '/cabinets',
            name: 'cabinets',
            component: Cabinets,
            meta: {
                auth: true,
                title: 'Кабинеты',
            }
        },
    ],
});

router.afterEach((to) => {
    Vue.nextTick(() => {
        document.title = to.meta.title ? to.meta.title : 'PinBonus';
    });
});

Vue.router = router;

Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});

App.router = Vue.router;

new Vue(App).$mount('#app');
