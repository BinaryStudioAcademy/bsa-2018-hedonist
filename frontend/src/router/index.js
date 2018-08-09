import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import PlacesList from  '@/components/PlacesList/PlacesList'
import ProfilePage from '@/pages/ProfilePage';

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
            component: PlacesList,
            name: 'PlacesList'
        }
    ]
})
