<template>
  <AuthenticatedLayout>
    <v-dialog
      v-model="editMenu"
      persistent
      width="1024"
    >
      <edit-menu @close="editMenu = !editMenu" :data="editData"
                 @status="(status)=>{!status?editMenu = false: editMenu = true}" :categories="categories"/>
    </v-dialog>
    <div class="mb-5">
      <!--      <Breadcrumbs :items="breadcrumbs" class="pa-0 mt-1" />-->
      <div class="heading-5 font-weight-bold fc-primary">Menu's</div>
      <v-row class="mt-2">
        <v-col>
          <AnlyticCard title="Total Menu's" icon='<svg fill="#000000" width="42" height="42" viewBox="0 0 24 24" id="menu-food-left-2" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color"><g id="SVGRepo_bgCarrier" stroke-width="0"/><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/><g id="SVGRepo_iconCarrier"><path id="secondary" d="M8,18H18a1,1,0,0,1,.22,2l-8.8,2a1.9,1.9,0,0,1-1.62-.38A2.13,2.13,0,0,1,7,19.88V19A1,1,0,0,1,8,18Zm1.1,2h0Z" style="fill: #6595ca;"/><path id="primary" d="M7,20H18a1,1,0,0,0,1-1V3a1,1,0,0,0-1-1H7A2,2,0,0,0,5,4V18A2,2,0,0,0,7,20Z" style="fill: #000000;"/><path id="secondary-2" data-name="secondary" d="M8,11a1,1,0,0,1,1-1h6a1,1,0,0,1,0,2H9A1,1,0,0,1,8,11ZM8,7A1,1,0,0,1,9,6h6a1,1,0,0,1,0,2H9A1,1,0,0,1,8,7Z" style="fill: #6595ca;"/></g>'/>
        </v-col>
      </v-row>
      <div class="d-flex justify-end mb-3  mt-3">
        <v-btn size="small" elevation="0" style="width: 30px; height: 50px;border-radius: 49px" rounded color="#0E0F3D"
               @click="addMenu = !addMenu">
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </div>
    </div>
    <v-navigation-drawer v-model="addMenu" class="add-menu-drawer" location="right" width="600">
      <div class="d-flex justify-end ma-5">
        <v-btn icon variant="text" rounded @click="addMenu = !addMenu">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
            <path d="M2 26L14 14M14 14L26 2M14 14L2 2M14 14L26 26" stroke="#A3AED0" stroke-width="4"
                  stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </v-btn>
      </div>
      <v-dialog v-model="ShowCate" width="500">
        <template v-slot:[`default`]>
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
                @click="ShowCate = false"
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
        </template>
      </v-dialog>
      <div class="mt-16">
        <v-stepper
          ref="stepper"
          editable
          hide-actions
          :items="['Menu & Category', 'Dishes']"
        >
          <template v-slot:[`item.1`]>
            <div class="d-flex justify-end mb-3 align-center">
              <span class="mr-5 font-weight-bold">Add Category: </span>
              <v-btn size="small" elevation="0" style="width: 30px; height: 50px;border-radius: 49px" rounded
                     color="#0E0F3D"
                     @click="ShowCate = !ShowCate">
                <v-icon>mdi-plus</v-icon>
              </v-btn>
            </div>
            <v-card elevation="0" flat>
              <h4 class="heading-5">Add menu</h4>
              <v-form validate-on="input lazy" v-model="valid">
                <v-row class="mt-4">
                  <v-col cols="6">
                    <span class="font-weight-bold">The menu title:</span>
                    <v-text-field hide-details="auto" class="input" v-model="menu.title"
                                  :rules="[value => !!value || 'The title field is required']" variant="text"
                                  placeholder="Title"></v-text-field>
                  </v-col>
                  <v-col cols="6">
                    <span class="font-weight-bold">Select category:</span>
                    <v-combobox class="input" variant="text" :items="categories"
                                item-title="name"
                                item-value="id"
                                :rules="[value => !!value || 'Select a category']"
                                v-model="menu.category" placeholder="Category"></v-combobox>
                  </v-col>
                  <v-col cols="12">
                    <div class="d-flex justify-center">
                      <!--                    <span class="position-absolute font-weight-bold">Add Dishes</span>-->
                      <v-btn @click="next" elevation="0" color="#0E0F3D" size="large" rounded>
                        Next
                      </v-btn>
                    </div>

                  </v-col>
                </v-row>
              </v-form>
            </v-card>
          </template>
          <template v-slot:[`item.2`]>
            <v-card elevation="0" title="Add Dish" flat>
              <v-row>
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
                  <v-label class="font-reg">Description:</v-label>

                  <v-textarea variant="plain"
                              v-model="dish.description"
                              class="input-textarea" placeholder="Description"></v-textarea>
                </v-col>

              </v-row>
             <div class="d-flex justify-end mt-5 ga-2">
               <v-btn @click="createMenu" elevation="0" color="#0E0F3D" variant="outlined" rounded>
                 Later
               </v-btn>
               <v-btn @click="createMenu" elevation="0" color="#0E0F3D" rounded>
                 Finish
               </v-btn>
             </div>
            </v-card>
          </template>
        </v-stepper>
      </div>
    </v-navigation-drawer>
    <div class="pa-5">
      <v-row>
        <v-col :cols="12" :lg="!menus.length > 1?12:4" :md="!menus.length > 1?12:4" v-for="(item,index) in menus"
               :key="index">
          <MenuCard @edit="edit" :menu="item"/>
        </v-col>
        <Alert v-if="!menus.length > 0" text="No data founded"/>
      </v-row>
    </div>
  </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MenuCard from "@/Components/menu-card.vue";
import AnlyticCard from "@/Components/anlytic-card.vue";
import {router} from "@inertiajs/vue3";
import Alert from "@/Components/alert.vue";
import EditMenu from "@/Components/Edit-menu.vue";

export default {
  components: {EditMenu, Alert, AnlyticCard, MenuCard, AuthenticatedLayout},
  props: {categories: Array, menus: Object, errors: Object},
  data: () => ({
    valid: false,
    addMenu: false,
    editMenu: false,
    ShowCate: false,
    editData: {},

    titleRules: [
      v => !!v || 'Title is required',
      v => (v && v.length <= 255) || 'Title must be less than 255 characters',
    ],
    priceRules: [
      v => !!v || 'Price is required',
      v => !isNaN(parseFloat(v)) && isFinite(v) || 'Price must be a number',
    ],
    category: {
      title: ''
    },
    menu: {
      title: '',
      category: null
    },
    dish: {
      title: '',
      description: '',
      price: null
    }
  }),
  methods: {
    deleteCategory(id){
      router.delete(`delete-category/${id}`, {
      })
    },
    addCategory() {
      // route('addCategory')
      router.post('add-category', {
          title: this.category.title,
          onSuccess: () => {
            this.ShowCate = false
            this.category.title = ''
          }
        }
      )
    },
    edit(data) {
      this.editMenu = !this.editMenu
      this.editData = data
    },
    next() {
      this.$refs.stepper.next()
    },
    createMenu() {
      // route('addCategory')
      // if (this.valid) {
      router.post('create-menu', {
          title: this.menu.title,
          category: this.menu.category,
          dish: this.dish
        },
        {
          onSuccess: () => {
            this.ShowCate = false
            this.menu.title = ''
            this.menu.category = ''
            this.addMenu = false
          }
        }
      )
      // }
    }
  },
  // computed: {
  //   titleRules() {
  //     const rules = [];
  //     if (this.errors.title) {
  //       rules.push(false);
  //     }
  //     return rules;
  //   }
  // }
}
</script>
