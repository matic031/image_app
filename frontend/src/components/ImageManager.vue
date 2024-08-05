<template>
  <div class="p-4 max-w-3xl">
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
      <InputText v-model="newTitle" placeholder="Enter image title"/>
      <Button label="Add Image" icon="pi pi-plus" @click="uploadSelectedImage" class="mr-4" :disabled="!canUpload"/>
    </div>

    <div v-for="image in images" :key="image.id" class="mt-6">
      <span class="p-8 w-full">
        <div class="flex items-center space-x-8">
          <img :src="`${image.path}`" :alt="image.title" class="w-48 h-48 rounded-full object-cover"/>
          <InputText v-model="image.title" placeholder="Edit image title" class="flex-grow"/>
          <Button label="Update Title" icon="pi pi-refresh" @click="updateImage(image)" class="p-button-warning w-40" />
          <Button label="Delete Image" icon="pi pi-trash" @click="deleteImage(image.id)" class="p-button-danger ml-2 w-40" />
        </div>
      </span>
    </div>

  </div>
</template>

<script>
import axios from '../axios';

export default {
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
  methods: {
    onFileSelect(event) {
      this.selectedFiles = event.files;
    },
    uploadSelectedImage() {
      const formData = new FormData();
      formData.append('file', this.selectedFiles[0]);
      formData.append('title', this.newTitle);

      axios.post('/images', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(response => {
        this.images.push(response.data);
        this.selectedFiles = [];
        this.newTitle = '';
      })
      .catch(error => {
        console.error('Error uploading image:', error);
      });
    },
    getStorageImageUrl(path) {
      return `http://localhost:8000/storage/${path}`;
    },
    fetchImages() {
      axios.get('/images')
        .then(response => {
          this.images = response.data;
        })
        .catch(error => {
          console.error('Error fetching images:', error);
        });
    },
    updateImage(image) {
      axios.put(`/images/${image.id}`, { title: image.title })
        .then(response => {
          console.log('Image updated:', response.data);
        })
        .catch(error => {
          console.error('Error updating image:', error);
        });
    },
    deleteImage(id) {
      axios.delete(`/images/${id}`)
        .then(response => {
          this.images = this.images.filter(image => image.id !== id);
        })
        .catch(error => {
          console.error('Error deleting image:', error);
        });
    }
  },
  mounted() {
    this.fetchImages();
  }
};
</script>
