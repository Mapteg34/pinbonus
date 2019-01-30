require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';

import App from './components/App.vue';

import Home from './components/Home.vue';
import Login from './components/Login.vue';
import Accounts from './components/Accounts.vue';
import Account from './components/Account.vue';
import Campaigns from './components/Campaigns.vue';
import Campaign from './components/Campaign.vue';
import Ads from './components/Ads.vue';

window.alertify = require('alertifyjs');

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

axios.defaults.baseURL = $('meta[name=app-url]').attr('content') + '/api';

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
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
            path: '/ads/:accountId?/:campaignId?',
            name: 'ads',
            component: Ads,
            meta: {
                auth: true,
                title: 'Объявления',
            }
        },
        {
            path: '/campaigns/:accountId?',
            name: 'campaigns',
            component: Campaigns,
            meta: {
                auth: true,
                title: 'Кампании',
            }
        },
        {
            path: '/campaigns/:accountId/:campaignId',
            name: 'campaign',
            component: Campaign,
            meta: {
                auth: true,
                title: 'Кампания',
            }
        },
        {
            path: '/accounts/:accountId',
            name: 'account',
            component: Account,
            meta: {
                auth: true,
                title: 'Кабинет',
            }
        },
        {
            path: '/accounts',
            name: 'accounts',
            component: Accounts,
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
