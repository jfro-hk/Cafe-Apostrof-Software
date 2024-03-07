<template>
  <AuthenticatedLayout>
    <div class="mb-5">
      <div class="heading-5 font-weight-bold fc-primary">Events</div>
    </div>
    <anlytic-card
      icon='<svg fill="#0E0F3D" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 45.964 45.964" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"/><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M7.071,30.834V11.062H4.042C1.803,11.062,0,12.893,0,15.13v26.732c0,2.24,1.803,4.051,4.042,4.051h26.733 c2.238,0,4.076-1.811,4.076-4.051v-2.92H15.179C10.733,38.943,7.071,35.281,7.071,30.834z"/> <path d="M41.913,0.05H15.179c-2.238,0-4.066,1.813-4.066,4.051v26.733c0,2.241,1.829,4.067,4.066,4.067h26.734 c2.237,0,4.051-1.826,4.051-4.067V4.102C45.964,1.862,44.15,0.05,41.913,0.05z M41.363,28.589 c-0.223,0.412-0.652,0.656-1.12,0.656H17.336c-0.403,0-0.782-0.18-1.022-0.502c-0.24-0.324-0.313-0.736-0.197-1.123l3.277-10.839 c0.216-0.713,0.818-1.24,1.554-1.361c0.736-0.12,1.476,0.19,1.908,0.797l4.582,6.437c0.617,0.867,1.812,1.082,2.689,0.484 l4.219-2.865c0.434-0.295,0.967-0.402,1.48-0.299c0.515,0.102,0.966,0.408,1.253,0.848l4.229,6.472 C41.564,27.687,41.585,28.179,41.363,28.589z"/> </g> </g> </g></svg>'
      :number="totalGallery" title="Uploadet i alt"/>
    <v-row justify="center">
      <v-dialog
        v-model="dialog"
        persistent
        width="auto"
        class="gallery-dialog"
      >
        <v-card class="gallery-card pa-7 ma-3" elevation="0" rounded>
          <drop-zone :max="1" @acceptFiles="acceptFilesHandler" :drag="!previews.length > 0" @previews="handlePreviews" :accepted-types="acceptTypes">
            <div class="pa-16 img-drop" v-if="!previews.length > 0">
              <div class="d-flex justify-center align-center">
                <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 0 24 24" width="32px" fill="#000000">
                  <path d="M0 0h24v24H0V0z" fill="none"/>
                  <path d="M15.5 10h-7c-.83 0-1.54.54-1.79 1.3l-1.86 5.14-.15.41h12.3l-3.65-10zM12 5.5l1.5 4.5h-3z"/>
                </svg>
              </div>
            </div>
            <div class="d-flex justify-center">
              <v-img v-if="previews[0]" :src="previews[0].preview" rounded>
                <div class="remove" @click="removePreview">
                  <v-btn size="xsmall" rounded style="background-color: unset;" variant="text" elevation="0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3657 4.63422C15.6781 4.94664 15.6781 5.45317 15.3657 5.76559L5.76571 15.3656C5.45329 15.678 4.94676 15.678 4.63434 15.3656C4.32192 15.0532 4.32192 14.5466 4.63434 14.2342L14.2343 4.63422C14.5468 4.3218 15.0533 4.3218 15.3657 4.63422Z" fill="white"/>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M4.63434 4.63422C4.94676 4.3218 5.45329 4.3218 5.76571 4.63422L15.3657 14.2342C15.6781 14.5466 15.6781 15.0532 15.3657 15.3656C15.0533 15.678 14.5468 15.678 14.2343 15.3656L4.63434 5.76559C4.32192 5.45317 4.32192 4.94664 4.63434 4.63422Z" fill="white"/>
                    </svg>
                  </v-btn>
                </div>
                <h5 class="heading-5 text-capitalize">{{ gallery.title }}</h5>
                <div class="time-icon z-index-1 right-unset">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <g clip-path="url(#clip0_112_3614)">
                      <path d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM12.5 7H11V13L16.2 16.2L17 14.9L12.5 12.2V7Z" fill="white"/>
                    </g>
                    <defs>
                      <clipPath id="clip0_112_3614">
                        <rect width="24" height="24" fill="white"/>
                      </clipPath>
                    </defs>
                  </svg>
                  At {{ moment(new Date()).format('YYYY MMM DD') }}
                </div>
              </v-img>
            </div>
          </drop-zone>
          <div v-if="errors.file" class="mt-1 mb-1" style="color: red">{{ errors.file }}</div>
          <div class="d-flex flex-column">
            <v-text-field max="400" v-model="gallery.title" class="input mt-3" variant="text" required hide-details placeholder="Title"></v-text-field>
            <div v-if="errors.title" class="mt-5" style="color: red">{{ errors.title }}</div>
            <div class="mt-3">
              <ckeditor :editor="editor" v-model="gallery.description" :config="editorConfig"></ckeditor>
              <div v-if="errors.description" class="mt-1" style="color: red">{{ errors.description }}</div>
            </div>
          </div>
          <div class="d-flex mt-5 ga-2 align-end justify-end">
            <v-btn variant="outlined" color="#0E0F3D" @click="dialog = false" rounded>Cancel</v-btn>
            <v-btn color="#0E0F3D" v-if="!editMode" @click="add" rounded>Save</v-btn>
            <v-btn color="#0E0F3D" v-if="editMode" @click="edit" rounded>Save</v-btn>
          </div>
        </v-card>
      </v-dialog>
    </v-row>
    <div class="d-flex justify-end mb-3 mt-8">
      <v-btn @click="openAdd" size="small" elevation="0" style="width: 30px; height: 50px;border-radius: 49px" rounded color="#0E0F3D">
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </div>
    <v-row>
      <v-col v-for="(g,index) in galleryData" :key="index" cols="12" lg="4" md="4">
        <GalleryCard @delete="handleGalleryDelete" @edit-data="openEdit" :gallery="g" :key="index"/>
      </v-col>
      <Alert v-if="!galleryData.length > 0" text="No data found"/>
    </v-row>
  </AuthenticatedLayout>
</template>

<script>
import DropZone from "@/Components/dropZone.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GalleryCard from "@/Components/Gallery-card.vue";
import AnlyticCard from "@/Components/anlytic-card.vue";
import Alert from "@/Components/alert.vue";
import axios from "axios";
import getGallery from '@/Configs/getGallery.js'
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import moment from "moment/moment.js";
import {useToast} from "vue-toastification";

export default {
  components: {Alert, AnlyticCard, GalleryCard, DropZone, AuthenticatedLayout},
  props: {errors: Object, totalGallery: Number},
  data() {
    return {
      dialog: false,
      editMode: false,
      selected: [],
      previews: [],
      toast:useToast(),
      status: false,
      editor: ClassicEditor,
      galleryData: [],
      editorConfig: {
        toolbar: ['bold', 'italic', '|', 'link']
      },
      gallery: {
        title: '',
        description: '',
        file: [],
      },
      acceptTypes: [
        "image/jpeg", "image/png", "image/bmp", "image/webp", "image/tiff", "image/vnd.dwg", "image/x-xbitmap",
        "image/x-jg", "image/x-xpixmap", "image/x-ms-bmp", "image/x-tga", "image/x-pcx", "image/x-pict",
        "image/x-cmu-raster", "image/x-portable-graymap", "image/x-portable-anymap", "image/x-portable-bitmap",
        "image/x-xwindowdump", "image/heic", "image/heic-sequence", "image/heif", "image/heif-sequence"
      ]
    };
  },
  methods: {
    acceptFilesHandler(files) {
      this.gallery.file = files;
    },
    handlePreviews(previews) {
      this.previews = previews;
    },
    removePreview() {
      this.previews = [];
    },
    handleGalleryDelete(id) {
      axios.post(`/delete-gallery/${id}`)
        .then(response => {
          console.log(response);
          this.toast.success('Gallery deleted successfully!')
          this.fetchData();
        })
        .catch(error => {
          console.error('Error deleting gallery:', error);
        });
    },
    openAdd() {
      this.editMode = false;
      this.dialog = !this.dialog;
      this.gallery.title = '';
      this.gallery.description = '';
      this.previews = '';
    },
    openEdit(data) {
      this.editMode = true;
      this.dialog = !this.dialog;
      this.gallery.title = data.title;
      this.gallery.description = data.description;
      this.previews = [{preview: data.media}];
      this.selected = data;
    },
    edit() {
      const formData = new FormData();
      formData.append('title', this.gallery.title);
      formData.append('description', this.gallery.description);
      if (this.gallery.file && this.gallery.file.length > 0) {
        formData.append('file', this.gallery.file[0]);
      }
      const url = `/update-gallery/${this.selected.action}`;
      axios.post(url, formData, {
        headers: {'Content-Type': 'multipart/form-data'}
      }).then(response => {
        this.toast.success('Gallery edited successfully!')
        this.fetchData();
        console.log(response);
        this.dialog = false;
        this.$emit('status', this.status);
      }).catch(error => {
        console.error('Error:', error);
      });
    },
    add() {
      const formData = new FormData();
      formData.append('title', this.gallery.title);
      formData.append('description', this.gallery.description);
      formData.append('file', this.gallery.file[0]);
      const url = `/add-gallery`;
      axios.post(url, formData, {
        headers: {'Content-Type': 'multipart/form-data'}
      }).then(response => {
        this.toast.success('Added deleted successfully!')
        this.fetchData();
        console.log(response);
        this.dialog = false;
        this.$emit('status', this.status);
      }).catch(error => {
        console.error('Error:', error);
      });
    },
    fetchData() {
      axios.get('/get-gallery-json').then(response => {
        this.galleryData = response.data;
      })
    }
  },
  computed: {
    getGallery() {
      return getGallery;
    },
    moment() {
      return moment;
    }
  },
  watch: {
    dialog(newValue) {
      if (!newValue) {
        this.editMode = false;
        this.selected = [];
      }
    }
  },
  mounted() {
    this.fetchData();
  }
}
</script>
