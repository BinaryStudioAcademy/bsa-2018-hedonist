export default {
    getByUserId: state => id => {
        return state.lists.filter(list => list.user_id === id);
    }
}