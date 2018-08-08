import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import ProfilePage from '@/pages/ProfilePage';

Vue.use(Router)

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
})

const [ isLoggedIn ] = mapGetters('auth', [
    'isLoggedIn'
])

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.guest)) {
        if (isLoggedIn()) {
            next('/')
        } else {
            next()
        }
    } else {
        if (isLoggedIn()) {
            next()
        } else {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            })
        }
    }
})

export default router
