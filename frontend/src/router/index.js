import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import PlaceView from '@/components/place/PlaceView'
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
            name: 'PlaceView',
            component: PlaceView
        },
        {
            path: '/places/list',
            name: 'PlacesList',
            component: PlacesList
        }
    ]
})
