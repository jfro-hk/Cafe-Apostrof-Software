<template>
  <v-card
    class="gallery-card pa-7 ma-3"
    elevation="0"
    rounded
  >
    <drop-zone :max="1" @acceptFiles="(f)=>{this.gallery.file = f}"
               :drag="this.previews.length > 0 ? false : true"
               @previews="(p)=>{this.previews = p}" :accepted-types="acceptTypes">
      <div class="pa-16 img-drop" v-if="!previews.length > 0">
        <div class="d-flex justify-center align-center">
          <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 0 24 24" width="32px" fill="#000000">
            <path d="M0 0h24v24H0V0z" fill="none"/>
            <path
              d="M21.02 5H19V2.98c0-.54-.44-.98-.98-.98h-.03c-.55 0-.99.44-.99.98V5h-2.01c-.54 0-.98.44-.99.98v.03c0 .55.44.99.99.99H17v2.01c0 .54.44.99.99.98h.03c.54 0 .98-.44.98-.98V7h2.02c.54 0 .98-.44.98-.98v-.04c0-.54-.44-.98-.98-.98zM16 9.01V8h-1.01c-.53 0-1.03-.21-1.41-.58-.37-.38-.58-.88-.58-1.44 0-.36.1-.69.27-.98H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8.28c-.3.17-.64.28-1.02.28-1.09-.01-1.98-.9-1.98-1.99zM15.96 19H6c-.41 0-.65-.47-.4-.8l1.98-2.63c.21-.28.62-.26.82.02L10 18l2.61-3.48c.2-.26.59-.27.79-.01l2.95 3.68c.26.33.03.81-.39.81z"/>
          </svg>
        </div>
      </div>
      <div class="d-flex justify-center">
      <v-img v-if="previews[0]" :src="previews[0].preview" rounded>
        <div class="remove" @click="handleDelete">
          <v-btn size="xsmall" rounded style="background-color: unset;" variant="text" elevation="0">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M15.3657 4.63422C15.6781 4.94664 15.6781 5.45317 15.3657 5.76559L5.76571 15.3656C5.45329 15.678 4.94676 15.678 4.63434 15.3656C4.32192 15.0532 4.32192 14.5466 4.63434 14.2342L14.2343 4.63422C14.5468 4.3218 15.0533 4.3218 15.3657 4.63422Z"
                    fill="white" />
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M4.63434 4.63422C4.94676 4.3218 5.45329 4.3218 5.76571 4.63422L15.3657 14.2342C15.6781 14.5466 15.6781 15.0532 15.3657 15.3656C15.0533 15.678 14.5468 15.678 14.2343 15.3656L4.63434 5.76559C4.32192 5.45317 4.32192 4.94664 4.63434 4.63422Z"
                    fill="white" />
            </svg>
          </v-btn>
        </div>
        <h5
        class="heading-5 text-capitalize">{{ gallery.title }}</h5>
        <div class="time-icon z-index-1 right-unset">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <g clip-path="url(#clip0_112_3614)">
              <path
                d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM12.5 7H11V13L16.2 16.2L17 14.9L12.5 12.2V7Z"
                fill="white"/>
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
    <div v-if="errors.file" class="mt-1 mb-1" style="color: red"> {{ errors.file }}</div>
    <div class="d-flex flex-column">
      <div class="d-flex flex-column">
        <!--        <v-label class="font-reg">Title:</v-label>-->

        <v-text-field max="400" v-model="gallery.title"
                      class="input mt-3"
                      variant="text"
                      required
                      hide-details
                      placeholder="Title"></v-text-field>
        <div v-if="errors.title" class="mt-5" style="color: red"> {{ errors.title }}</div>

        <!--        <v-label class="font-reg">Title:</v-label>-->
        <div class="mt-3">
          <ckeditor :editor="editor" v-model="gallery.description" :config="editorConfig"></ckeditor>
          <div v-if="errors.description" class="mt-1" style="color: red"> {{ errors.description }}</div>

        </div>
        <!--        <v-textarea max="1000" v-model="gallery.description"-->
        <!--                    class="input"-->
        <!--                    variant="text"-->
        <!--                    placeholder="Description"></v-textarea>-->
      </div>
    </div>
    <div class="d-flex mt-5 ga-2 align-end justify-end">
      <v-btn variant="outlined" color="#0E0F3D" @click="this.$emit('close')" rounded>Cancel</v-btn>
      <v-btn color="#0E0F3D" @click="addOrUpdate" rounded>Save</v-btn>
    </div>
  </v-card>
</template>
<script>
import moment from "moment";
import DropZone from "@/Components/dropZone.vue";
import {router} from "@inertiajs/vue3";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  components: {DropZone},
  props: {
    editMode:Boolean,
    errors: Object,
    selectedGallery:Object,
    maxWidth: {
      type: Number,
      default: 344
    }
  },
  methods: {
    handleDelete(){
      this.previews = []
    },
    addOrUpdate() {
      router.post(`/${this.editMode ? 'update' : 'add'}-gallery${this.editMode ? '/'+this.selectedGallery.action : '/'}`, {
        title: this.gallery.title,
        description: this.gallery.description,
        file: this.gallery.file[0]
      }, {
        onSuccess: () => {
          this.status = false
          this.$emit('status', this.status)
        }
      })
    }
  },
  data: () => ({
    titleRules: [
      v => !!v || 'Title is required',
      v => (v && v.length <= 255) || 'Title must be less than 255 characters',
    ],

    previews: [],
    status: false,
    editor: ClassicEditor,
    // editorData: '<p>Content of the editor.</p>',
    editorConfig: {
      toolbar: ['bold', 'italic', '|', 'link']

    },
    gallery: {
      title: '',
      description: '',
      file: [],
    },

    acceptTypes: [
      "image/jpeg",
      "image/png",
      // "image/gif",
      "image/bmp",
      "image/webp",
      "image/tiff",
      "image/vnd.dwg",
      "image/x-xbitmap",
      "image/x-jg",
      "image/x-xpixmap",
      "image/x-ms-bmp",
      "image/x-tga",
      "image/x-pcx",
      "image/x-pict",
      "image/x-cmu-raster",
      "image/x-portable-graymap",
      "image/x-portable-anymap",
      "image/x-portable-bitmap",
      "image/x-xwindowdump",
      "image/heic",
      "image/heic-sequence",
      "image/heif",
      "image/heif-sequence"
    ]
  }),
  computed: {
    moment() {
      return moment
    }
  },
  mounted() {
    this.gallery.title = this.editMode ? this.selectedGallery.title : ''
    this.gallery.description = this.editMode ? this.selectedGallery.description : '<p></p>'
    this.previews = this.editMode ? [{ preview: this.selectedGallery.media }] : []
  }
}
</script>

