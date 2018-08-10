export default {
    getFilteredPlaces: state => name => {
        return state.places.filter(
          place => place.name.toLowerCase().indexOf(name.toLowerCase()) > -1
        );
    }
}