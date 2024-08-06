<template>
    <div class="p-4 max-w-lg mx-auto">
      <h2 class="text-2xl font-bold mb-4">Login</h2>
      <form @submit.prevent="login">
        <div class="mb-4">
          <label class="block mb-1" for="email">Email:</label>
          <InputText v-model="email" id="email" type="email" placeholder="Email" class="w-full" />
        </div>
        <div class="mb-4">
          <label class="block mb-1" for="password">Password:</label>
          <InputText v-model="password" id="password" type="password" placeholder="Password" class="w-full" />
        </div>
        <Button label="Login" icon="pi pi-sign-in" class="w-full" type="submit" />
      </form>
      <div class="mt-4">
        <Button label="Register" icon="pi pi-user-plus" class="w-full" @click="goToRegister" />
      </div>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import axios from '../axios';
  import InputText from 'primevue/inputtext';
  import Button from 'primevue/button';
  import { useToast } from 'primevue/usetoast';
  
  export default {
    components: {
      InputText,
      Button,
    },
    setup() {
      const email = ref('');
      const password = ref('');
      const router = useRouter();


    const toast = useToast();

    const showToast = (severity, summary, detail) => {
      toast.add({ severity, summary, detail, life: 3000 });
    };

      const login = async () => {
        try {
          const response = await axios.post('/login', { email: email.value, password: password.value });
          localStorage.setItem('token', response.data.token);
          router.push('/');
          showToast('info', 'Info', 'Logged in successfully');
        } catch (error) {
          console.error('Error logging in:', error);
        }
      };
  
      const goToRegister = () => {
        router.push('/register');
      };
  
      return {
        email,
        password,
        login,
        goToRegister,
        toast, router, showToast
      };
    },
  };
  </script>
  