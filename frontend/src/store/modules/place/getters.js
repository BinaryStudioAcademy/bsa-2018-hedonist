export default {
    getFilteredByName: state => name => {
        return state.places.filter(
          place => place.name.toLowerCase().indexOf(name.toLowerCase()) > -1
        );
    }
}