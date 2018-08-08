import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import EditProfile from '@/components/profile/EditProfile';

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            name: 'HelloWorld',
            component: HelloWorld
        },
        {
            path: '/profile/edit',
            name: 'EditProfile',
            component: EditProfile
        }
    ]
})
