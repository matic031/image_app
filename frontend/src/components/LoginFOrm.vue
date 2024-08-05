<template>
    <div>
      <h2>Login</h2>
      <form @submit.prevent="login">
        <input v-model="email" type="email" placeholder="Email" required>
        <input v-model="password" type="password" placeholder="Password" required>
        <button type="submit">Login</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        email: '',
        password: ''
      };
    },
    methods: {
      login() {
        axios.post('/api/login', {
          email: this.email,
          password: this.password
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
  