import Vue from 'vue';
import Vuex from 'vuex';
import state from './common/state';
import actions from './common/actions';
import getters from './common/getters';
import mutations from './common/mutations';
import auth from './modules/auth';
import search from './modules/search';
import place from './modules/place';
import placeCategory from './modules/place/category';
import map from './modules/map';
import review from './modules/review';
import userlist from './modules/userList';

Vue.use(Vuex);

export default new Vuex.Store({
    state,
    actions,
    getters,
    mutations,
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        auth,
        map,
        place,
        placeCategory,
        search,
        review,
        userlist
    }
});