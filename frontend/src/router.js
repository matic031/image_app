// src/router.js

import { createRouter, createWebHistory } from 'vue-router';
import RegistrationForm from './components/RegistrationForm.vue';
import LoginForm from './components/LoginForm.vue';
import ImageManager from './components/ImageManager.vue';

const routes = [
  { path: '/register', component: RegistrationForm },
  { path: '/login', component: LoginForm },
  { 
    path: '/', 
    component: ImageManager,
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token');
      if (token) {
        next();
      } else {
        next('/login');
      }
    }
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
