<template>
  <v-card
    class="gallery-card pa-5"
    max-width="344"
    elevation="0"
    rounded
  >
<!--    <TableOption @edit="$emit('edit');handleSelection(item)" @delete="handleDelete(item.action)" :id="item.action"/>-->
<TableOption  @delete="handleDelete(gallery.action)" @edit="$emit('edit');handleSelection(gallery)"/>
    <v-img :src="gallery.media" rounded><h5 class="heading-5 text-capitalize">{{ gallery.title }}</h5>
      <div class="time-icon z-index-1">
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
        At {{ moment(gallery.created_at).format('YYYY MMM DD') }}
      </div>
    </v-img>
    <div class="d-flex flex-column ma-3">
      <div class="d-flex justify-space-between">
        <span class="heading-5">{{ gallery.title }}</span>
        <v-btn icon elevation="0" @click="this.$emit('edit');handleSelection(gallery)">
          <svg width="24" height="24" viewBox="0 0 24 24" id="_24x24_On_Light_Edit" data-name="24x24/On Light/Edit" xmlns="http://www.w3.org/2000/svg">
          <rect id="view-box" width="24" height="24" fill="none"/>
          <path id="Shape" d="M.75,17.5A.751.751,0,0,1,0,16.75V12.569a.755.755,0,0,1,.22-.53L11.461.8a2.72,2.72,0,0,1,3.848,0L16.7,2.191a2.72,2.72,0,0,1,0,3.848L5.462,17.28a.747.747,0,0,1-.531.22ZM1.5,12.879V16h3.12l7.91-7.91L9.41,4.97ZM13.591,7.03l2.051-2.051a1.223,1.223,0,0,0,0-1.727L14.249,1.858a1.222,1.222,0,0,0-1.727,0L10.47,3.91Z" transform="translate(3.25 3.25)" fill="#141124"/>
        </svg>
        </v-btn>
      </div>
      <p v-html="gallery.description"></p>
    </div>
  </v-card>
</template>
<script>
import moment from "moment";
import TableOption from "@/Components/table-option.vue";
import {router} from "@inertiajs/vue3";

export  default {
  props:{gallery:Object},
  components: {TableOption},
  methods:{
    handleDelete(){
      router.delete(`/delete-gallery/${this.gallery.action}`)
    },
    handleSelection(select) {
      this.editData = select
      this.$emit('editData',select)
    },
  },
  computed: {
    moment() {
      return moment
    }
  },
}
</script>
