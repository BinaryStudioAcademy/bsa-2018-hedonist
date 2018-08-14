export default {
    auth: store => (to, from, next) => {
        if (!store.getters.isLoggedIn) {
            next({
                path: '/login'
            });
        } else {
            next();
        }
    },
    guest: store => (to, from, next) => {
        if (store.getters.isLoggedIn) {
            next({
                path: '/'
            });
        } else {
            next();
        }
    }
};
