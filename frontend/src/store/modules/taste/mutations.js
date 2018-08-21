export default {
    SET_TASTES: (state, tastes) => {
        state.tastes = Object.assign({}, tastes);
    },

    SET_USER_TASTES: (state, tastes) => {
        state.userTastes = Object.assign({}, tastes);
    },

    ADD_USER_TASTE: (state, taste) => {
        state.userTastes.byId[taste.id] = taste;
    },

    DELETE_USER_TASTE: (state, id) => {
        delete state.userTastes[id];
    }
};