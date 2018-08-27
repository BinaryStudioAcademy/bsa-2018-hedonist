export default {
    getFilteredByName: state => (userLists, name) => {
        let filtered = {};
        Object.keys(userLists).forEach( (key) => {
            let userList = userLists[key];
            if(userList.name
                    .toLowerCase()
                    .indexOf(
                        name.toLowerCase()
                    ) > -1)
                filtered[userList.id] = userList;
        });
        return filtered;
    },

    getById: state => id => {
        return state.userListsNormalized.byId[id];
    },

    getUniqueCitiesNormalized: (state, getters) => userList => {
        let cities = {};
        userList.places
            .map(id => state.placesNormalized.byId[id].city_id)
            .forEach((id) => {
                cities[id] = state.citiesNormalized.byId[id]
            });
        return cities;
    },

    getFilteredNormalizedByCity: (state, getters) => (userLists, cityId) => {
        let filtered = {};
        Object.keys(userLists).forEach( (key) => {
            let userList = userLists[key];
            let cities = Object.keys(
                getters.getUniqueCitiesNormalized(userList)
            ).filter(
                id => parseInt(id) === cityId
            );
            if(cities.length > 0) filtered[userList.id] = userList;
        });
        return filtered;
    },

    getPlaceById: (state, getters) => (id) => {
        return state.placesNormalized.byId[id];
    }
};
