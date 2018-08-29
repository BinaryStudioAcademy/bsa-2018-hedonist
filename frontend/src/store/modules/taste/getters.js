export default {
    getMyTastesIds: state => {
        if (state.myTastes.byId !== undefined) {
            return Object.keys(state.myTastes.byId);
        } else {
            return [];
        }
    },
    getAllTastesIds: state => {
        if (state.allTastes.byId !== undefined) {
            return Object.keys(state.allTastes.byId);
        } else {
            return [];
        }
    },
    getTasteByName: (state, getters) => name => {
        let ids = getters.getAllTastesIds;
        const id = ids.find(id => {
            return state.allTastes.byId[id].name === name;
        });

        return id ? state.allTastes.byId[id] : null;
    }
};
