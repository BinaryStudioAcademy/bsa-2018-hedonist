import Vue from 'vue';
import Router from 'vue-router';
import HelloWorld from '@/components/HelloWorld';
import ProfilePage from '@/pages/ProfilePage';
import ReviewList from '@/components/Review/ReviewList';

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
      name: 'Reviews',
      component: ReviewList
    }
  ]
});