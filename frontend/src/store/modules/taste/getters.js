export default {
    getById: state => id => {
        return state.tastes.find((taste) => {
            return taste.id === parseInt(id);
        });
    }
};