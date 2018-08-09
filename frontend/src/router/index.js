import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import ProfilePage from '@/pages/ProfilePage';
import PlacesList from  '@/components/PlacesList/PlacesList'

Vue.use(Router)

export default new Router({
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
            path: '/places/list',
            name: 'PlacesList',
            component: PlacesList
        }
    ]
})
