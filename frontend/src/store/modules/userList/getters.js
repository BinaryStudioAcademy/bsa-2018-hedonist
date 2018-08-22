export default {
    getFilteredByName: state => name => {
        return state.userLists.filter(
            userList => userList.name.toLowerCase().indexOf(name.toLowerCase()) > -1
        );
    },
    getById: state => id => {
        return new Promise(resolve => {
            setTimeout(() => {
                resolve(state.userLists.find( (userLists) => { return userLists.id === parseInt(id); }));
            }, 500);
        });
    }
};
