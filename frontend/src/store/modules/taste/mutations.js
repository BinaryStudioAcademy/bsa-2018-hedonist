export default {
    SET_TASTES: (state, tastes) => {
        state.allTastes = Object.assign({}, tastes);
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