export default {
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