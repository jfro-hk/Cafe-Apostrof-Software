<template>
  <AuthenticatedLayout>
    <div class="mb-5">
      {{categories}}
      <!--      <Breadcrumbs :items="breadcrumbs" class="pa-0 mt-1" />-->
      <div class="heading-5 font-weight-bold fc-primary">Menu {{ menu.title }}</div>
    </div>
    <v-row justify="center">
      <v-dialog
        v-model="addMode"
        width="500"
      >
        <v-card>
          <!--    {{selectedDish}}-->
          <v-card-title>
            <span class="text-h5">Adding Menu or Category</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row justify="center" class="pa-12 ga-4">
                <v-btn @click="addCate = !addCate" size="large" color="#2B3674">Category</v-btn>
                <v-btn @click="addDish = !addDish" size="large" color="#2B3674">Dish</v-btn>
              </v-row>
            </v-container>
          </v-card-text>
        </v-card>
      </v-dialog>

<v-dialog v-model="addCate"
          persistent
          width="1024"
>
  <v-card title="Add Category">
    <v-card-text class="mt-5">
      <v-text-field class="input" v-model="category.title" variant="text"
                    placeholder="Category Title"></v-text-field>
      <div class="app-table">
        <v-table>
          <thead>
          <tr>
            <th class="text-left">
              Name
            </th>
            <th class="text-left">
              Action
            </th>
          </tr>
          </thead>
          <tbody>
          <tr
            v-for="item in categories"
            :key="item.name"
          >
            <td>{{ item.name }}</td>
            <td><v-btn color="#2B3674" @click="deleteCategory(item.id)" rounded elevation="0">Delete</v-btn></td>
          </tr>
          </tbody>
        </v-table>

      </div>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>

      <v-btn
        text="Close"
        color="#2B3674"
        variant="outlined"
        rounded
        @click="addCate = false"
      ></v-btn>
      <v-btn
        text="Save"
        color="#2B3674"
        rounded
        variant="flat"
        @click="addCategory"
      ></v-btn>
    </v-card-actions>
  </v-card>
</v-dialog>

<!--      // add dish-->
      <v-dialog
        v-model="addDish"
        persistent
        width="1024"
      >

        <add-dishes :categories="categories" :selected-menu="menu" :selected-dish="selectedDish"
                    @status="(status)=>{!status?addDish = false: addDish = true}" :edit-mode="editMode"
                    @close="addDish = false; editMode = false"/>
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
          <v-btn size="small" @click="addMode = !addMode;"
                 style="width: 30px; height: 50px;border-radius: 49px" rounded
                 color="#0E0F3D">
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </div>
        {{ dishes }}
        <h1>Category name</h1>
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
import AddDishes from "@/Components/addEditDishes.vue";

export default {
  props: {menu: Array, dishes: Array,categories:Array},
  components: {AddDishes, AnlyticCard, DishesTable, AuthenticatedLayout},
  data: () => ({
    selectedDish: [],
    selected: [],
    dialog: false,
    addMode: false,
    editMode: false,
    addDish:false,
    addCate:false,
    category:{
      title:''
    }
  }),
  watch: {
    editMode(val) {
      if (val) {
        this.addDish = !this.addDish
      }
    },
    dialog(newValue) {
      if (newValue !== false) {
        console.log('checking this');
      }
      if (!newValue) {
        this.editMode = false;
        this.selectedDish = [];
      }
    }
  },
  methods: {
    addCategory() {
      // route('addCategory')
      router.post(`/add-category/${this.menu.id}`, {
          title: this.category.title,
          onSuccess: () => {
            this.ShowCate = false
            this.category.title = ''
          }
        }
      )
    },
    deleteCategory(id){
      router.delete(`/delete-category/${id}`, {
      })
    },
    handleDelete(id) {
      router.delete(`/menu/delete-dish/${id}`)
    }
  },
}
</script>
