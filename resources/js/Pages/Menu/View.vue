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
        <v-card>
          <v-card-title>
            <span class="text-h5">Add Dish</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col
                  cols="12"
                  sm="6"
                  md="6"
                >
                  <v-text-field
                    class="input"
                    variant="text"
                    placeholder="Title"
                    v-model="dish.title"
                    :rules="titleRules"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12"
                       sm="6"
                       md="6"
                >
                  <v-text-field
                    required
                    class="input"
                    v-model="dish.price"
                    type="number"
                    variant="text"
                    :rules="priceRules"
                    placeholder="Price"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-textarea variant="plain"
                              v-model="dish.description"
                              class="input-textarea" placeholder="Description"></v-textarea>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              variant="outlined"
              color="#0E0F3D"
              @click="dialog = false"
              rounded
            >
              Close
            </v-btn>
            <v-btn
              color="#0E0F3D"
              @click="addDishes"
              rounded
              variant="flat"
            > Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
    <v-row>
      <v-col cols="12" sm="4" :md="5" :lg="5">
        <AnlyticCard/>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        {{ dishes }}
        <div class="d-flex justify-end mb-3">
          <v-btn size="small" @click="dialog = !dialog" style="width: 30px; height: 50px;border-radius: 49px" rounded
                 color="#0E0F3D">
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </div>
        {{selected}}
        <DishesTable @selected="(data)=>{selected = data}" @delete="handleDelete" type="editable" :data="dishes"/>
      </v-col>
    </v-row>
  </AuthenticatedLayout>
</template>
<script>
import DishesTable from "@/Components/dishes-table.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AnlyticCard from "@/Components/anlytic-card.vue";
import {router} from "@inertiajs/vue3";

export default {
  props: {menu: Array, dishes: Array},
  components: {AnlyticCard, DishesTable, AuthenticatedLayout},
  data: () => ({
    dialog: false,
    titleRules: [
      v => !!v || 'Title is required',
      v => (v && v.length <= 255) || 'Title must be less than 255 characters',
    ],
    selected:[],
    priceRules: [
      v => !!v || 'Price is required',
      v => !isNaN(parseFloat(v)) && isFinite(v) || 'Price must be a number',
    ],
    dish: {
      title: null,
      price: null,
      description: '',
    }
  }),
  methods: {
    addDishes() {
      if (this.isValid) {
        router.post(`/menu/add-dish/${this.menu.id}`, {
          title: this.dish.title,
          price: this.dish.price,
          description: this.dish.description,
        }, {
          onSuccess: () => {
            this.dialog = false
          }
        })
      }
    },
    handleDelete(id){
      router.delete(`/menu/delete-dish/${id}`)
    }
  },
  computed: {
    isValid() {
      const isTitleValid = this.dish.title && this.titleRules.every(rule => rule(this.dish.title));
      const isPriceValid = this.dish.price && this.priceRules.every(rule => rule(this.dish.price));
      return isTitleValid && isPriceValid;
    }
  }


}
</script>
