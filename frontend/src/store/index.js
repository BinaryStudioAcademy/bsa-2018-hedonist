import Vue from 'vue';
import Vuex from 'vuex';
import state from './common/state';
import actions from './common/actions';
import getters from './common/getters';
import mutations from './common/mutations';
import auth from './modules/auth/index';
import place from './modules/place/index';
import placeCategory from './modules/place/category/index';
import map from './modules/map/index';
import review from './modules/review/index';
import userlist from './modules/userList/index';

Vue.use(Vuex);

export default new Vuex.Store({
    state,
    actions,
    getters,
    mutations,
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        auth,
        place,
        map,
        placeCategory,
        review,
        userlist
    }
});