export default {
    getFilter: state => name => {
        return state.filters[name];
    },

};
