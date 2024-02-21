<template>

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
            @click="this.$emit('close')"
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
</template>
<script>
import {router} from "@inertiajs/vue3";

export default {
  props:{selectedMenu:Object,editMode:Boolean,selectedDish:Object},
  data() {
    return {
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
        title: this.editMode ? this.selectedDish.title:'',
        description: this.editMode ? this.selectedDish.description: '',
        price: this.editMode ? this.selectedDish.price : null
      },
      status: false
    };
  },
  watch:{
    status(){

    }
  },
  methods:{
    addDishes() {
      if (this.isValid) {
        router.post(`/menu/${this.editMode ? 'update':'add'}-dish/${this.selectedDish.action}`, {
          title: this.dish.title,
          price: this.dish.price,
          description: this.dish.description,
          menu_id: this.selectedMenu.id,
        }, {
          onSuccess: () => {
            this.status = false
            this.$emit('status',this.status)
          }
        })
      }
    },
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
