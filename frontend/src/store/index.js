import Vue from 'vue';
import Vuex from 'vuex';
import state from './common/state';
import actions from './common/actions';
import getters from './common/getters';
import mutations from './common/mutations';
import auth from './modules/auth';
import city from './modules/city';
import place from './modules/place';
import placeCategory from './modules/place/category';
import map from './modules/map';

Vue.use(Vuex);

export default new Vuex.Store({
    state,
    actions,
    getters,
    mutations,
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        auth,
        city,
        place,
        map,
        placeCategory
    }
});