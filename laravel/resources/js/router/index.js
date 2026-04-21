import { createRouter, createWebHistory } from 'vue-router'

import HomePage from '../pages/HomePage.vue'
import RegisterPage from '../pages/RegisterPage.vue'
import LoginPage from '../pages/LoginPage.vue'
import ExplorePage from '../pages/ExplorePage.vue'
import NewServicePage from '../pages/NewServicePage.vue'
import UserProfilePage from '../pages/UserProfilePage.vue'
import ServiceDetailsPage from '../pages/ServiceDetailsPage.vue'
import LogoutPage from '../pages/LogoutPage.vue'


const routes = [
  {
    path: '/',
    name: 'home',
    component: HomePage,
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterPage,
  },
  {
    path: '/login',
    name: 'login',
    component: LoginPage,
  },


  {
    path: '/logout',
    name: 'logout',
    component: LogoutPage,
  },

  {
    path: '/explore',
    name: 'explore',
    component: ExplorePage,
  },

  {
    path: '/services/new',
    name: 'new-service',
    component: NewServicePage,
  },

  {
    path: '/users/:user_id',
    name: 'user-profile',
    component: UserProfilePage,
  },

  {
    path: '/services/:service_id',
    name: 'service-details',
    component: ServiceDetailsPage,
  },

]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router