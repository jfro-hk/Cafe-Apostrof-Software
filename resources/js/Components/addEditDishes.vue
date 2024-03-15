<template>
  <v-card>
        <v-card-title>
          <span class="text-h5">{{editMode? 'Edit Dish' :'Add Dish'}}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col
                cols="12"
              >
              <span class="font-weight-bold">Select category:</span>
              <v-combobox class="input" variant="text" :items="categories"
                          item-title="name"
                          item-value="id"
                          :rules="[value => !!value || 'Select a category']"
                          v-model="dish.category" placeholder="Category"></v-combobox>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-label class="font-reg">Title:</v-label>
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
                <v-label class="font-reg">Price $:</v-label>

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
                <v-label class="font-reg">Extra note & Times:</v-label>

                <v-text-field variant="text"
                              v-model="dish.extra_note"
                              class="input" placeholder="Extra note"></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-label class="font-reg">Description:</v-label>

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
            @click="addEditDishes"
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
  props:{selectedMenu:Object,editMode:Boolean,selectedDish:Object,categories:Array},
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
        price: this.editMode ? this.selectedDish.price : null,
        extra_note: this.editMode ? this.selectedDish.extra_note : null,
        category: this.editMode ? this.selectedDish.category : null
      },
      status: false
    };
  },
  watch:{
    status(){

    }
  },
  methods:{
    addEditDishes() {
      if (this.isValid) {
        router.post(`/menu/${this.editMode ? 'update':'add'}-dish/${this.editMode ? this.selectedDish.action : this.selectedMenu.id}`, {
          title: this.dish.title,
          price: this.dish.price,
          description: this.dish.description,
          extra_note: this.dish.extra_note,
          category: this.dish.category.id,
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
