<template>
  <AuthenticatedLayout>
    <div class="mb-5">
      <div class="heading-5 font-weight-bold fc-primary">Gallery</div>
    </div>
    <anlytic-card title="Total Uploaded"/>
    <v-row justify="center">
      <v-dialog
        v-model="dialog"
        persistent
        width="auto"
        class="gallery-dialog"
      >
<!--        <v-card elevation="0">-->
<!--          <v-card-text class="d-flex justify-center">-->
          <add-edit-gallery :errors="errors" :selected-gallery="selected" :edit-mode="editMode"
                            @status="(status)=>{!status?dialog = false: dialog = true}"
                            @close="dialog = false; editMode = false" />
<!--          </v-card-text>-->
<!--        </v-card>-->
      </v-dialog>
    </v-row>
    <div class="d-flex justify-end mb-3 mt-8">
      <v-btn @click="dialog = !dialog" size="small" elevation="0" style="width: 30px; height: 50px;border-radius: 49px" rounded color="#0E0F3D">
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </div>
    <v-row>
      <v-col v-for="(g,index) in gallery" :key="index" cols="12" lg="4" md="4">
        <GalleryCard @edit-data="(data)=>{this.selected = data}" @edit="editMode = !editMode; dialog = !dialog" :gallery="g" :key="index"/>
      </v-col>
      <Alert v-if="!gallery.length > 0" text="No data founded"/>
    </v-row>
  </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GalleryCard from "@/Components/Gallery-card.vue";
import AnlyticCard from "@/Components/anlytic-card.vue";
import AddEditGallery from "@/Components/addEditGallery.vue";
import Alert from "@/Components/alert.vue";
export default {
  components:{Alert, AddEditGallery, AnlyticCard, GalleryCard, AuthenticatedLayout},
  props:{gallery: Object,errors:Object},
  data: () => ({
    dialog:false,
    editMode:false,
    selected:[]
  }),
  watch:{
    dialog(newValue) {
      if (newValue !== false) {
        console.log('checking this');
      }
      if (!newValue) {
        this.editMode = false;
        this.selectedDish = [];
      }
    }
  }
}
</script>
