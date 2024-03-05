<template>
  <AuthenticatedLayout>
    <div class="mb-5">
      <div class="heading-5 font-weight-bold fc-primary">Events</div>
    </div>
    <anlytic-card icon='<svg fill="#0E0F3D" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 45.964 45.964" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"/><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M7.071,30.834V11.062H4.042C1.803,11.062,0,12.893,0,15.13v26.732c0,2.24,1.803,4.051,4.042,4.051h26.733 c2.238,0,4.076-1.811,4.076-4.051v-2.92H15.179C10.733,38.943,7.071,35.281,7.071,30.834z"/> <path d="M41.913,0.05H15.179c-2.238,0-4.066,1.813-4.066,4.051v26.733c0,2.241,1.829,4.067,4.066,4.067h26.734 c2.237,0,4.051-1.826,4.051-4.067V4.102C45.964,1.862,44.15,0.05,41.913,0.05z M41.363,28.589 c-0.223,0.412-0.652,0.656-1.12,0.656H17.336c-0.403,0-0.782-0.18-1.022-0.502c-0.24-0.324-0.313-0.736-0.197-1.123l3.277-10.839 c0.216-0.713,0.818-1.24,1.554-1.361c0.736-0.12,1.476,0.19,1.908,0.797l4.582,6.437c0.617,0.867,1.812,1.082,2.689,0.484 l4.219-2.865c0.434-0.295,0.967-0.402,1.48-0.299c0.515,0.102,0.966,0.408,1.253,0.848l4.229,6.472 C41.564,27.687,41.585,28.179,41.363,28.589z"/> </g> </g> </g></svg>'
                 :number="totalGallery" title="Uploadet i alt"/>
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
  props:{gallery: Object,errors:Object,totalGallery:Number},
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
