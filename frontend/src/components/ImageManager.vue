<template>
  <div>
    <Toast />
    <div class="flex justify-end p-8">
      <Button label="Logout" icon="pi pi-sign-out" @click="logout" class="p-button-danger mb-4" />
    </div>
    <div class="p-4 max-w-4xl">
      <div class="flex items-center space-x-4">
        <FileUpload
          name="file"
          accept="image/jpeg, image/png, image/svg+xml, image/bmp"
          :customUpload="true"
          :auto="false"
          :chooseOptions="{ label: 'Choose Image', icon: 'pi pi-fw pi-images' }"
          v-model:files="selectedFiles"
          @select="onFileSelect"
        />
        <InputText v-model="newTitle" placeholder="Enter image title" />
        <Button label="Add Image" icon="pi pi-plus" @click="uploadSelectedImage" class="mr-4" :disabled="!canUpload" />
      </div>

      <div v-for="image in images" :key="image.id" class="mt-6">
        <div class="p-8 w-full">
          <div class="flex items-center space-x-8">
            <img :src="`${image.path}`" :alt="image.title" class="w-48 h-48 rounded-full object-cover" />
            <InputText v-model="image.title" placeholder="Edit image title" class="flex-grow" />
            <Button label="Update Title" icon="pi pi-refresh" @click="updateImage(image)" class="p-button-warning w-40" />
            <Button label="Delete Image" icon="pi pi-trash" @click="deleteImage(image.id)" class="p-button-danger ml-2 w-40" />
            <Button label="Share" icon="pi pi-share-alt" @click="shareImage(image)" class="p-button-success ml-2 w-40" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from '../axios';
import FileUpload from 'primevue/fileupload';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Card from 'primevue/card';
import { useRouter } from 'vue-router';
import { useToast } from 'primevue/usetoast';

export default {
  components: {
    FileUpload,
    InputText,
    Button,
    Card,
  },
  data() {
    return {
      selectedFiles: [],
      newTitle: '',
      images: []
    };
  },
  computed: {
    canUpload() {
      return this.selectedFiles.length > 0 && this.newTitle;
    }
  },
  setup() {
    const toast = useToast();
    const router = useRouter();

    const showToast = (severity, summary, detail) => {
      toast.add({ severity, summary, detail, life: 3000 });
    };

    const copyToClipboard = async (text) => {
      try {
        await navigator.clipboard.writeText(text);
        showToast('success', 'Copied', 'URL copied to clipboard');
      } catch (error) {
        showToast('error', 'Error', 'Failed to copy URL');
      }
    };

    return { toast, router, showToast, copyToClipboard };
  },
  methods: {
    onFileSelect(event) {
      this.selectedFiles = event.files;
    },
    async uploadSelectedImage() {
      const formData = new FormData();
      formData.append('file', this.selectedFiles[0]);
      formData.append('title', this.newTitle);

      try {
        const response = await axios.post('/images', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        this.images.push(response.data);
        this.selectedFiles = [];
        this.newTitle = '';
        this.showToast('success', 'Success', 'Image uploaded successfully');
      } catch (error) {
        console.error('Error uploading image:', error);
        this.showToast('error', 'Error', 'Failed to upload image');
      }
    },
    async fetchImages() {
      try {
        const response = await axios.get('/images');
        this.images = response.data;
      } catch (error) {
        console.error('Error fetching images:', error);
        this.showToast('error', 'Error', 'Failed to fetch images');
      }
    },
    async updateImage(image) {
      try {
        const response = await axios.put(`/images/${image.id}`, { title: image.title });
        console.log('Image updated:', response.data);
        this.showToast('success', 'Success', 'Image updated successfully');
      } catch (error) {
        console.error('Error updating image:', error);
        this.showToast('error', 'Error', 'Failed to update image');
      }
    },
    async deleteImage(id) {
      try {
        await axios.delete(`/images/${id}`);
        this.images = this.images.filter(image => image.id !== id);
        this.showToast('success', 'Success', 'Image deleted successfully');
      } catch (error) {
        console.error('Error deleting image:', error);
        this.showToast('error', 'Error', 'Failed to delete image');
      }
    },
    async shareImage(image) {
      this.copyToClipboard(image.path);
    },
    async logout() {
      try {
        await axios.post('/logout');
        localStorage.removeItem('token');
        this.$router.push('/login');
        this.showToast('success', 'Success', 'Logged out successfully');
      } catch (error) {
        console.error('Error logging out:', error);
        this.showToast('error', 'Error', 'Failed to log out');
      }
    }
  },
  mounted() {
    this.fetchImages();
  }
};
</script>

