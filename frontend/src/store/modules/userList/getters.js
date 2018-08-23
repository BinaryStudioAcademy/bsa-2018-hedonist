export default {
    getFilteredByName: state => name => {
        return state.userLists.filter(
            userList => userList.name.toLowerCase().indexOf(name.toLowerCase()) > -1
        );
    },
    getById: state => id => {
        return state.userLists.find( (userLists) => {
            return userLists.id === parseInt(id); }
        );
    },
    getUniqueCities: (state, getters) => userList => {
        const places = userList.places;
        const cities = places.map(place => place.city);
        return cities.filter((a, i) =>
            i === cities.length - 1 ||
            a.id !== cities[i + 1].id
        );
    },
    getUniqueCitiesByPlaceId: (state, getters) => id => {
        const userList = getters.getById(id);
        return getters.getUniqueCities(userList);
    },
    getFilteredByCity: (state, getters) => (userLists, cityId) => {
        return userLists.filter(
            ul => ul.places.filter(
                pl => pl.city_id === cityId
            ).length > 0);
    }
};
