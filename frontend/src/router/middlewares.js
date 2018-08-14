export default {
    auth: store => (to, from, next) => {
        if (!store.getters.hasToken()) {
            next({
                path: '/login'
            });
        } else {
            next();
        }
    },
    guest: store => (to, from, next) => {
        if (store.getters.hasToken()) {
            next({
                path: '/'
            });
        } else {
            next();
        }
    }
}
