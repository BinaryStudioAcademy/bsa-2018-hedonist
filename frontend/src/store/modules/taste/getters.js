export default {
    getMyTastesIds: state => {
        if (state.myTastes.byId !== undefined) {
            return Object.keys(state.myTastes.byId);
        } else {
            return [];
        }
    },
    getCustomTastesIds: state => {
        if (state.customTastes.byId !== undefined) {
            return Object.keys(state.customTastes.byId);
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
    },
    getCustomTasteByName: (state, getters) => name => {
        let ids = getters.getCustomTastesIds;
        const id = ids.find(id => {
            return state.customTastes.byId[id].name === name;
        });

        return id ? state.customTastes.byId[id] : null;
    }
};
