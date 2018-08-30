export default {
    getFilter: state => name => {
        return state.filters[name];
    },
  
    getSelectedCity: state => {
        return state.city;
    },

    getSelectedPlaceCategory: state => {
        return state.placeCategory;
    },

    getSelectedPlace: state => {
        return state.place;
    }
};
