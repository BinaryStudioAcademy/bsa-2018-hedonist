const TOKEN_EXPIRED = 'token_expired';

export default {
    auth: store => (to, from, next) => {
        if (!store.getters.hasToken()) {
            next({
                path: '/login'
            });
            return;
        }

        fetchUser(store)
            .then(() => {
                next( {path: to} );
            })
            .catch(() => {
                store.commit('USER_LOGOUT');
                next({ path: '/login' });
            });

        next();
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
};

const refreshAuth = (store) => {
    return new Promise((resolve, reject) => {
        store.dispatch('refreshToken')
            .then(() => {
                store.dispatch('fetchAuthenticatedUser')
                    .then(() => {
                        resolve();
                    })
                    .catch(() => {
                        reject();
                    });
            })
            .catch(error => {
                reject(error);
            });
    });
};

const fetchUser = (store) => {
    return new Promise((resolve, reject) => {
        // show loading spinner
        store.commit('SET_LOADING', true);

        store.dispatch('fetchAuthenticatedUser')
            .catch(response => {
                if (response.code === TOKEN_EXPIRED) {
                    refreshAuth(store)
                        .then(() => {
                            store.commit('SET_LOADING', false);
                            resolve();
                        })
                        .catch(error => {
                            store.commit('SET_LOADING', false);
                            reject();
                        });
                }
            });
    });
};

