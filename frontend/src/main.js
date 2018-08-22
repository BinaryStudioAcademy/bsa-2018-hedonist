// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import App from './App';
import router from './router';
import store from './store/index';
import {sync} from 'vuex-router-sync';
import Buefy from 'buefy';
import Vuelidate from 'vuelidate';
import vClickOutside from 'v-click-outside';
import VueImg from 'v-img';
import vuexI18n from 'vuex-i18n';

import translationEn from './localization/en.json';
import translationsUa from './localization/ua.json';

Vue.use(Buefy);
Vue.use(Vuelidate);
Vue.use(vClickOutside);
Vue.use(VueImg);
Vue.use(vuexI18n.plugin, store);

Vue.i18n.add('en', translationEn);
Vue.i18n.add('ua', translationsUa);

Vue.i18n.set('en');

sync(store, router);

Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    components: {App},
    template: '<App/>',
    store
});
