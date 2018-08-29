import Vue from 'vue';

export default {
    SET_TASTES: (state, tastes) => {
        state.allTastes = Object.assign({}, tastes);
    },

    SET_CUSTOM_TASTES: (state, tastes) => {
        state.customTastes = Object.assign({}, tastes);
    },

    ADD_CUSTOM_TASTE: (state, taste) => {
        Vue.set(state.customTastes.byId, taste.id, taste);
    },

    DELETE_CUSTOM_TASTE: (state, id) => {
        Vue.delete(state.customTastes.byId, id);
    },

    SET_MY_TASTES: (state, tastes) => {
        state.myTastes = Object.assign({}, tastes);
    },

    ADD_MY_TASTE: (state, taste) => {
        state.myTastes.byId[taste.id] = taste;
    },

    DELETE_MY_TASTE: (state, id) => {
        delete state.myTastes[id];
    }
};