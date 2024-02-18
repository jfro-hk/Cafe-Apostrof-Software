<template>
  <AuthenticatedLayout>
    <div class="mb-5">
      <!--      <Breadcrumbs :items="breadcrumbs" class="pa-0 mt-1" />-->
      <div class="heading-5 font-weight-bold fc-primary">Menu's</div>
      <v-row class="mt-2">
        <v-col>
          <AnlyticCard title="Total Menu's"/>
        </v-col>
      </v-row>
      <div class="d-flex justify-end mb-3">
        <v-btn size="small" elevation="0" style="width: 30px; height: 50px;border-radius: 49px" rounded color="#0E0F3D"
               @click="addMenu = !addMenu">
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </div>
    </div>
    <v-navigation-drawer v-model="addMenu" class="add-menu-drawer" location="right" width="600">
      <div class="d-flex justify-end ma-5">
        <v-btn size="small" variant="text" rounded @click="addMenu = !addMenu">
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
              <v-text-field class="input" v-model="category.title" variant="text" placeholder="Category Title"></v-text-field>
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
                  <v-text-field hide-details="auto" class="input" v-model="menu.title" :rules="[value => !!value || 'The title field is required']" variant="text" placeholder="Title"></v-text-field>
                </v-col>
                <v-col cols="6">
                  <span class="font-weight-bold">Select category:</span>
                  <v-combobox class="input" variant="text" multiple :items="categories.map(cate => cate.name)"
                              :rules="[value => !!value || 'Select a category']"
                              v-model="menu.category" placeholder="Category"></v-combobox>
                </v-col>
                <v-col cols="12">
                  <div class="d-flex justify-center">
<!--                    <span class="position-absolute font-weight-bold">Add Dishes</span>-->
                    <v-btn @click="createMenu" elevation="0" color="#0E0F3D" size="large" rounded>
                      Add dish
                    </v-btn>
                  </div>

                </v-col>
              </v-row>
              </v-form>
            </v-card>
          </template>

          <template v-slot:[`item.2`]>
            <v-card elevation="0" title="Add Dishes" flat>
              <v-row>
                <v-col cols="6">
                  <v-text-field class="input" variant="text"></v-text-field>
                </v-col>
                <v-col cols="6">
                  <v-text-field class="input" variant="text"></v-text-field>
                </v-col>
              </v-row>
              dishes table
            </v-card>
          </template>
        </v-stepper>
      </div>
    </v-navigation-drawer>
    <v-card elevation="0" class="pa-5">
    <v-row>
      <v-col v-for="(item,index) in menus" :key="index">
        <MenuCard :menu="item"/>

      </v-col>
      <div v-if="!menus.length > 0">
noo
      </div>
    </v-row>
    </v-card>
  </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MenuCard from "@/Components/menu-card.vue";
import AnlyticCard from "@/Components/anlytic-card.vue";
import {router} from "@inertiajs/vue3";

export default {
  components: {AnlyticCard, MenuCard, AuthenticatedLayout},
  props: {categories: Array,menus:Object,errors:Object},
  data: () => ({
    valid:false,
    addMenu: false,
    ShowCate: false,
    category: {
      title: ''
    },
    menu: {
      title: '',
      category: null
    }
  }),
  methods: {
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
    createMenu() {
      // route('addCategory')
      // if (this.valid) {
        router.post('create-menu', {
            title: this.menu.title,
            category: this.menu.category,

          },
          {
            onSuccess: () => {
              this.ShowCate = false
              this.menu.title = ''
              this.menu.category = ''
              this.$refs.stepper.next()
            }
          }
        )
      // }
    }
  },
  computed: {
    titleRules() {
      const rules = [];
      if (this.errors.title) {
        rules.push(false);
      }
      return rules;
    }
  }
}
</script>
