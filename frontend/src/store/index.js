import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth/index';
import places from './modules/places/index';

Vue.use(Vuex);

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        auth: auth,
        places
    }
});