import Vue from 'vue';
import Vuex from 'vuex';
import state from './common/state';
import actions from './common/actions';
import getters from './common/getters';
import mutations from './common/mutations';
import auth from './modules/auth/index';

Vue.use(Vuex);

export default new Vuex.Store({
    state,
    actions,
    getters,
    mutations,
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        auth: auth,
    }
});