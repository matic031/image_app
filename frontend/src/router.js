// src/router.js
import { createRouter, createWebHistory } from 'vue-router';
import RegistrationForm from './components/RegistrationForm.vue'; // Adjust the path accordingly

const routes = [
  {
    path: '/register',
    name: 'Register',
    component: RegistrationForm
  },
  // Add other routes here...
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
