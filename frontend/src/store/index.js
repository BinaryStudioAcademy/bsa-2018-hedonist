import Vue from 'vue';
import Vuex from 'vuex';
import state from './common/state';
import actions from './common/actions';
import getters from './common/getters';
import mutations from './common/mutations';
import auth from './modules/auth';
import search from './modules/search';
import category from './modules/category';
import features from './modules/features';
import place from './modules/place';
import review from './modules/review';
import userList from './modules/userList';
import taste from './modules/taste';
import user from './modules/user';
import profile from './modules/profile';

Vue.use(Vuex);

export default new Vuex.Store({
    state,
    actions,
    getters,
    mutations,
    strict: process.env.NODE_ENV !== 'production',
    modules: {
        auth,
        category,
        features,
        place,
        search,
        review,
        userList,
        taste,
        user,
        profile
    }
});