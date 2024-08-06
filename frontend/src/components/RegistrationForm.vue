<template>
  <div class="p-4 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold mb-4">Register</h2>
    <form @submit.prevent="register">
      <div class="mb-4">
        <label class="block mb-1" for="name">Name:</label>
        <InputText v-model="name" id="name" type="text" placeholder="Name" class="w-full" />
      </div>
      <div class="mb-4">
        <label class="block mb-1" for="email">Email:</label>
        <InputText v-model="email" id="email" type="email" placeholder="Email" class="w-full" />
      </div>
      <div class="mb-4">
        <label class="block mb-1" for="password">Password:</label>
        <InputText v-model="password" id="password" type="password" placeholder="Password" class="w-full" />
      </div>
      <div class="mb-4">
        <label class="block mb-1" for="password_confirmation">Confirm Password:</label>
        <InputText v-model="password_confirmation" id="password_confirmation" type="password" placeholder="Confirm Password" class="w-full" />
      </div>
      <Button label="Register" icon="pi pi-user-plus" class="w-full" type="submit" />
    </form>
    <div class="mt-4">
      <Button label="Login" icon="pi pi-sign-in" class="w-full" @click="goToLogin" />
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import axios from '../axios';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { useRouter } from 'vue-router';

export default {
  components: {
    InputText,
    Button,
  },
  setup() {
    const name = ref('');
    const email = ref('');
    const password = ref('');
    const password_confirmation = ref('');
    const router = useRouter();

    const register = async () => {
      try {
        const response = await axios.post('/register', {
          name: name.value,
          email: email.value,
          password: password.value,
          password_confirmation: password_confirmation.value,
        });
        localStorage.setItem('token', response.data.token);
        router.push('/');
        this.showToast('info', 'Info', 'Registered in successfully');
      } catch (error) {
        console.error('Error registering:', error);
      }
    };

    const goToLogin = () => {
      router.push('/login');
    };

    return {
      name,
      email,
      password,
      password_confirmation,
      register,
      goToLogin,
    };
  },
};
</script>
