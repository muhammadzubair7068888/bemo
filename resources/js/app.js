require('./bootstrap');

import Vue from 'vue'
import { sync } from 'vuex-router-sync'

import App from './App.vue'
import router from './router/index'
import store from './store/index'

Vue.config.productionTip = false

sync(store,router)

/* eslint-disable no-new */
new Vue({
    el: '#app',
    template: '<App/>',
    components: { App },
    router,
    store
})

