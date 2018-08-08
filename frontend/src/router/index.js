import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import PlacesList from  '@/components/PlacesList/PlacesList'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            redirect:'/placesList',
            name: 'HelloWorld',
            component: HelloWorld
        },
        {
            path: '/placesList',
            component: PlacesList
        }
    ]
})
