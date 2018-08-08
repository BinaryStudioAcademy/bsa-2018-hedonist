import Vue from 'vue';
import Router from 'vue-router';
import HelloWorld from '@/components/HelloWorld';
import ProfilePage from '@/pages/ProfilePage';

Vue.use(Router);

const router = new Router({
    routes: [
        {
            path: '/',
            name: 'HelloWorld',
            component: HelloWorld,
        },
        {
            path: '/profile',
            name: 'ProfilePage',
            component: ProfilePage,
        },
        {
            path: '/login',
            name: 'Login',
            component: LoginPage,
            meta: { guest: true }
        }
    ]
});

const [ isLoggedIn ] = mapGetters('auth', [ 'isLoggedIn' ]);

router.beforeEach((to, from, next) => {
    const isGuestRoute = to.matched.some(record => record.meta.guest);

    if (isLoggedIn()) {
        if (isGuestRoute) {
            return next('/');
        }
    } else {
        if (!isGuestRoute) {
            return next({
                path: '/login',
                query: { redirect: to.fullPath }
            });
        }
    }

    next();
});

export default router
