<template>
  <AuthenticatedLayout>
    <div class="mb-5">
      <!--      <Breadcrumbs :items="breadcrumbs" class="pa-0 mt-1" />-->
      <div class="heading-5 font-weight-bold fc-primary">Menu {{ menu.title }}</div>
    </div>
    <v-row justify="center">

      <v-dialog
        v-model="dialog"
        persistent
        width="1024"
      >
        <add-dishes :selected-menu="menu" :selected-dish="selectedDish"
                    @status="(status)=>{!status?dialog = false: dialog = true}" :edit-mode="editMode"
                    @close="dialog = false; editMode = false"/>
      </v-dialog>

    </v-row>

    <v-row>
      <v-col cols="12" sm="4" :md="5" :lg="5">
        <AnlyticCard/>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <div class="d-flex justify-end mb-3">
          <v-btn size="small" @click="dialog = !dialog; !editMode"
                 style="width: 30px; height: 50px;border-radius: 49px" rounded
                 color="#0E0F3D">
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </div>
        <DishesTable @edit="editMode = !editMode" @edit-data="(data)=>{selectedDish = data}"
                     @selected="(data)=>{selected = data}" @delete="handleDelete" type="editable" :data="dishes"/>
      </v-col>
    </v-row>
  </AuthenticatedLayout>
</template>
<script>
import DishesTable from "@/Components/dishes-table.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AnlyticCard from "@/Components/anlytic-card.vue";
import {router} from "@inertiajs/vue3";
import AddDishes from "@/Components/addDishes.vue";

export default {
  props: {menu: Array, dishes: Array},
  components: {AddDishes, AnlyticCard, DishesTable, AuthenticatedLayout},
  data: () => ({
    selectedDish: [],
    selected: [],
    dialog: false,
    editMode: false
  }),
  watch: {
    editMode(val) {
      if (val) {
        this.dialog = !this.dialog
      }
    }
  },
  methods: {
    handleDelete(id) {
      router.delete(`/menu/delete-dish/${id}`)
    }
  },
}
</script>
