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
        let taste = null;
        ids.forEach(id => {
            if (state.allTastes.byId[id].name === name) {
                taste = state.allTastes.byId[id];
                return true;
            }
        });
        return taste;
    }
};
