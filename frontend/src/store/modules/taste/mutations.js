export default {
    SET_TASTES: (state, tastes) => {
        state.tastes = tastes;
    },

    SET_USER_TASTES: (state, tastes) => {
        state.userTastes = tastes;
    },

    ADD_USER_TASTE: (state, taste) => {
        let result = state.userTastes.find((obj) => { return obj.id === taste.id; });
        if (!result) {
            state.userTastes.push(taste);
        }
    },

    DELETE_USER_TASTE: (state, id) => {
        state.userTastes = state.userTastes.filter((obj) => { return obj.id !== id; });
    }
};