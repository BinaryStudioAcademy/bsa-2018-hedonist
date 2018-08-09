const auth = store => (to, from, next) => {
    if (!store.getters.isLoggedIn) {
        next({
            path: '/login'
        });
    } else {
        next();
    }
};

const guest = store => (to, from, next) => {
    if (store.getters.isLoggedIn) {
        next({
            path: '/'
        });
    } else {
        next();
    }
};