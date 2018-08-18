import Vue from 'vue';
import App from './App';
import router from './router';
import store from './store/index';
import {sync} from 'vuex-router-sync';
import Buefy from 'buefy';
import Vuelidate from 'vuelidate';
import vClickOutside from 'v-click-outside';
import VueImg from 'v-img';
import { enableSentryErrorReporting } from './services/common/errorReportingService';

Vue.use(Buefy);
Vue.use(Vuelidate);
Vue.use(vClickOutside);
Vue.use(VueImg);

sync(store, router);

Vue.config.productionTip = false;

if (process.env.NODE_ENV === 'production') {
    enableSentryErrorReporting(Vue);
}

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    components: {App},
    template: '<App/>',
    store
});
