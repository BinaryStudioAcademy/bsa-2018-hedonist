import Vue from 'vue';
import Router from 'vue-router';
import HelloWorld from '@/components/HelloWorld';
import ProfilePage from '@/pages/ProfilePage';
import ReviewPage from '@/pages/ReviewPage';

Vue.use(Router);

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
      path: '/reviews',
      name: 'ReviewPage',
      component: ReviewPage
    }
  ]
});