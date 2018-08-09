import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import PlacePage from '@/pages/PlacePage'
import ProfilePage from '@/pages/ProfilePage';
import PlacesList from  '@/components/PlacesList/PlacesList'

Vue.use(Router)

export default new Router({
    mode: 'history',
    base: '/',
    scrollBehavior: () => ({y: 0}),
    routes: [
        {
            path: '/',
            name: 'HelloWorld',
            component: HelloWorld
        },
        {
            path: '/profile',
            name: 'ProfilePage',
            component: ProfilePage
        },
        {
            path: '/place-info',
            name: 'PlacePage',
            component: PlacePage
        },
        {
            path: '/places/list',
            name: 'PlacesList',
            component: PlacesList
        }
    ]
})
