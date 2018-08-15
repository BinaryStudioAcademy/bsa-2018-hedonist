export default {
    auth: store => (to, from, next) => {
        if (!store.getters['auth/hasToken']()) {
            next({
                path: '/login'
            });
        } else {
            next();
        }
    },
    guest: store => (to, from, next) => {
        if (store.getters['auth/hasToken']()) {
            next({
                path: '/'
            });
        } else {
            next();
        }
    }
};
