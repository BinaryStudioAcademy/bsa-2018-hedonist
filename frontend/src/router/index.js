import Vue from 'vue';
import Router from 'vue-router';
import RouterMiddleware from 'vue-router-middleware';
import HelloWorld from '@/components/HelloWorld';
import ProfilePage from '@/pages/ProfilePage';
import PlacesList from  '@/components/PlacesList/PlacesList';
import store from '../store/index';

Vue.use(Router);

const middleware = handler => (
    routes => routes.map(route => Object.assign({}, route, { beforeEnter: handler }))
);

export default new Router({
    mode: 'history',
    base: '/',
    scrollBehavior: () => ({y: 0}),
    routes: [
        ...middleware(auth(store))([
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
        ...middleware(guest(store))([
            {
                path: '/login',
                name: 'Login',
            }
        ])
    ]
});