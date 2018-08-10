import Vue from 'vue';
import Vuex from 'vuex';
import state from './common/index';
import auth from './modules/auth/index';

Vue.use(Vuex);

export default new Vuex.Store({
    state: state,
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        auth: auth,
    }
});