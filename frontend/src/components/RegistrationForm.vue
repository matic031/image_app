<!-- src/components/RegisterForm.vue -->
<template>
    <div>
      <h2>Register</h2>
      <form @submit.prevent="register">
        <input v-model="name" placeholder="Name" required>
        <input v-model="email" type="email" placeholder="Email" required>
        <input v-model="password" type="password" placeholder="Password" required>
        <input v-model="password_confirmation" type="password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from '../axios';
  
  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      };
    },
    methods: {
      register() {
        axios.post('/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        }).then(response => {
          localStorage.setItem('token', response.data.token);
          this.$router.push('/');
        }).catch(error => {
          console.error(error);
        });
      }
    }
  };
  </script>
  