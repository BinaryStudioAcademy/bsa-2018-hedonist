import Vue from 'vue';
import App from './App';
import router from './router';
import store from './store/index';
import {sync} from 'vuex-router-sync';
import Buefy from 'buefy';
import Vuelidate from 'vuelidate';
import vClickOutside from 'v-click-outside';
import VueImg from 'v-img';
import VueScrollTo from 'vue-scrollto';
import Tooltip from 'vue-directive-tooltip';
import vuexI18n from 'vuex-i18n';
import { enableSentryErrorReporting } from './services/common/errorReportingService';

import translationEn from './localization/en.json';
import translationsUa from './localization/ua.json';
import translationsRu from './localization/ru.json';

Vue.use(Buefy);
Vue.use(Vuelidate);
Vue.use(vClickOutside);
Vue.use(VueImg);
Vue.use(VueScrollTo);
Vue.use(Tooltip);
Vue.use(vuexI18n.plugin, store);

Vue.i18n.add('en', translationEn);
Vue.i18n.add('ua', translationsUa);
Vue.i18n.add('ru', translationsRu);

Vue.i18n.set('en');

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
    store,
});
