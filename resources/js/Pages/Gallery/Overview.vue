<template>
  <AuthenticatedLayout>
    <div class="mb-5">
      <div class="heading-5 font-weight-bold fc-primary">Gallery</div>
    </div>
    <anlytic-card title="Total Uploaded"/>
    <div class="d-flex justify-end mb-3">
      <v-btn size="small" elevation="0" style="width: 30px; height: 50px;border-radius: 49px" rounded color="#0E0F3D">
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </div>
    <v-row>
      <v-col>
        <GalleryCard />
      </v-col>
    </v-row>
  </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GalleryCard from "@/Components/Gallery-card.vue";
import AnlyticCard from "@/Components/anlytic-card.vue";
export default {
  components:{AnlyticCard, GalleryCard, AuthenticatedLayout},
  props:{}
}
</script>
