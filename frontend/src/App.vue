<template>
   <router-view></router-view>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import ImageManager from './components/ImageManager.vue';

export default defineComponent({
  components: {
    ImageManager,
  },
});
</script>
