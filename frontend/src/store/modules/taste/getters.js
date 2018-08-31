export default {
    getMyTastesIds: state => {
        return Object.keys(state.myTastes.byId);
    },
    getAllTastesIds: state => {
        return Object.keys(state.allTastes.byId);
    }
};
