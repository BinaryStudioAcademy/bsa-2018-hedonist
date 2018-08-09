<<<<<<< HEAD
import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import SignUp from '@/components/auth/SignUp'
import Login from '@/components/auth/Login'
import Reset from '@/components/auth/Reset'
import Recover from '@/components/auth/Recover'
=======
import Vue from 'vue';
import Router from 'vue-router';
import HelloWorld from '@/components/HelloWorld';
>>>>>>> development
import ProfilePage from '@/pages/ProfilePage';
import PlacesList from  '@/components/PlacesList/PlacesList';
import store from '../store/index';
import middlewares from './middlewares';

Vue.use(Router);

const middleware = handler => (
    routes => routes.map(route => Object.assign({}, route, { beforeEnter: handler }))
);

export default new Router({
<<<<<<< HEAD
  routes: [
    {
      path: '/',
      name: 'HelloWorld',
      component: HelloWorld
    },
    {
      path: '/signup',
      name: 'SignUp',
      component: SignUp
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/reset',
      name: 'Reset',
      component: Reset
    },
    {
      path: '/recover',
      name: 'Recover',
      component: Recover
    },
    {
      path: '/profile',
      name: 'ProfilePage',
      component: ProfilePage
    }
  ]
})
=======
    mode: 'history',
    base: '/',
    scrollBehavior: () => ({y: 0}),
    routes: [
        ...middleware(middlewares.auth(store))([
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
                path: '/places/list',
                name: 'PlacesList',
                component: PlacesList
            }
        ]),
        ...middleware(middlewares.guest(store))([
            {
                path: '/login',
                name: 'Login',
            }
        ])
    ]
});
>>>>>>> development
