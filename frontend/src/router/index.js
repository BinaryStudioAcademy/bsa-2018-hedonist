import Vue from 'vue'
import Router from 'vue-router'
import store from '@/store'
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

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.notRequiresAuth)) {
        next()
    } else {
        if (!store.getters['auth/isLoggedIn']) {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
              })
        } else {
            next()
        }
    }
})

export default router
