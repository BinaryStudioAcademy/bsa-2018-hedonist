import Vue from 'vue';
import Router from 'vue-router';
import PlacePage from '@/pages/PlacePage';
import ProfilePage from '@/pages/ProfilePage';
import NewPlacePage from '@/pages/NewPlacePage';
import UserListsPage from '@/pages/UserListsPage';
import PlacesList from  '@/components/placesList/PlacesList';
import HistoryPage from '@/pages/HistoryPage';
import SeachPlacePage from  '@/pages/SeachPlacePage';
import store from '../store/index';
import middlewares from './middlewares';
import UserListAddPage from '@/pages/UserListAddPage';
import SignUpPage from '@/pages/SignUpPage';
import LoginPage from '@/pages/LoginPage';
import ResetPasswordPage from '@/pages/ResetPasswordPage';
import RecoverPasswordPage from '@/pages/RecoverPasswordPage';
import MyTastesPage from '@/pages/MyTastesPage';
import ReviewList from '@/components/review/ReviewList';

Vue.use(Router);

const middleware = handler => (
    routes => routes.map(route => Object.assign({}, route, { beforeEnter: handler }))
);

export default new Router({
    mode: 'history',
    base: '/',
    scrollBehavior: () => ({y: 0}),
    routes: [
        ...middleware(middlewares.auth(store))([
            {
                path: '/',
                name: 'home',
                redirect: '/search'
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
            },
            {
                path: '/places/add',
                name: 'NewPlacePage',
                component: NewPlacePage
            },
            {
                path: '/search',
                name: 'SeachPlacePage',
                component: SeachPlacePage
            },
            {
                path: '/places/:id',
                name: 'PlacePage',
                component: PlacePage
            },
            {
                path: '/reviews',
                name: 'ReviewList',
                component: ReviewList
            },
            {
                path: '/users/lists/add',
                name: 'UserListAddPage',
                component: UserListAddPage
            },
            {
                path: '/user/lists',
                name: 'UserListsPage',
                component: UserListsPage
            },
            {
                path: '/tastes',
                name: 'MyTastesPage',
                component: MyTastesPage
            },
            {
                path: '/history',
                name: 'HistoryPage',
                component: HistoryPage
            }
        ]),
        ...middleware(middlewares.guest(store))([
            {
                path: '/login',
                name: 'LoginPage',
                component: LoginPage
            },
            {
                path: '/signup',
                name: 'SignUpPage',
                component: SignUpPage
            },
            {
                path: '/reset',
                name: 'ResetPasswordPage',
                component: ResetPasswordPage
            },
            {
                path: '/recover',
                name: 'RecoverPasswordPage',
                component: RecoverPasswordPage
            },
        ])
    ]
});