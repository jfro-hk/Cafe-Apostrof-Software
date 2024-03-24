<template>
  <AuthenticatedLayout>
    <div class="mb-5">
      <!--      <Breadcrumbs :items="breadcrumbs" class="pa-0 mt-1" />-->
      <div class="heading-5 font-weight-bold fc-primary">Menu {{ menu.title }}</div>
    </div>
    <!--    // addimage-->
    <v-row justify="center">
      <v-dialog
        v-model="addImg"
        persistent
        width="auto"
        class="gallery-dialog"
      >
        <v-card class="gallery-card pa-7 ma-3" elevation="0" rounded>
          <drop-zone :max="1" @acceptFiles="acceptFilesHandler" :drag="!previews.length > 0" @previews="handlePreviews"
                     :accepted-types="acceptTypes">
            <div class="pa-16 img-drop" v-if="!previews.length > 0">
              <div class="d-flex justify-center align-center">
                <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 0 24 24" width="32px" fill="#000000">
                  <path d="M0 0h24v24H0V0z" fill="none"/>
                  <path d="M15.5 10h-7c-.83 0-1.54.54-1.79 1.3l-1.86 5.14-.15.41h12.3l-3.65-10zM12 5.5l1.5 4.5h-3z"/>
                </svg>
              </div>
            </div>
            <div class="d-flex justify-center">
              <v-img v-if="previews[0]" :src="previews[0].preview" rounded>
                <div class="remove" @click="removePreview">
                  <v-btn size="xsmall" rounded style="background-color: unset;" variant="text" elevation="0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.3657 4.63422C15.6781 4.94664 15.6781 5.45317 15.3657 5.76559L5.76571 15.3656C5.45329 15.678 4.94676 15.678 4.63434 15.3656C4.32192 15.0532 4.32192 14.5466 4.63434 14.2342L14.2343 4.63422C14.5468 4.3218 15.0533 4.3218 15.3657 4.63422Z"
                            fill="white"/>
                      <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M4.63434 4.63422C4.94676 4.3218 5.45329 4.3218 5.76571 4.63422L15.3657 14.2342C15.6781 14.5466 15.6781 15.0532 15.3657 15.3656C15.0533 15.678 14.5468 15.678 14.2343 15.3656L4.63434 5.76559C4.32192 5.45317 4.32192 4.94664 4.63434 4.63422Z"
                            fill="white"/>
                    </svg>
                  </v-btn>
                </div>
                <div class="time-icon z-index-1 right-unset">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <g clip-path="url(#clip0_112_3614)">
                      <path
                        d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM12.5 7H11V13L16.2 16.2L17 14.9L12.5 12.2V7Z"
                        fill="white"/>
                    </g>
                    <defs>
                      <clipPath id="clip0_112_3614">
                        <rect width="24" height="24" fill="white"/>
                      </clipPath>
                    </defs>
                  </svg>
                  At {{ moment(new Date()).format('YYYY MMM DD') }}
                </div>
              </v-img>
            </div>
          </drop-zone>
          <div v-if="errors.file" class="mt-1 mb-1" style="color: red">{{ errors.file }}</div>

          <div class="d-flex mt-5 ga-2 align-end justify-end">
            <v-btn variant="outlined" color="#0E0F3D" @click="addImg = false" rounded>Cancel</v-btn>
            <v-btn color="#0E0F3D" v-if="!editImageMode" :loading="loading" @click="addImage" rounded>Save</v-btn>
            <!--            <v-btn color="#0E0F3D" v-if="editMode" :loading="loading" @click="edit" rounded>Save</v-btn>-->
          </div>
        </v-card>
      </v-dialog>
    </v-row>
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
                <v-btn @click="addCate = !addCate" size="large" color="#2B3674">Kategori</v-btn>
                <v-btn @click="addDish = !addDish" size="large" color="#2B3674">Retter</v-btn>
                <v-btn @click="openAddImageDialog" size="large" color="#2B3674">Billede {{menu.img != null? 'Update' : ''}}</v-btn>
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
            <v-row>
              <v-col cols="12">
            <v-text-field class="input" v-model="category.title" variant="text"
                          placeholder="Category Title"></v-text-field>
            <div class="app-table">
              <v-table>
                <thead>
                <tr>
                  <th class="text-left">
                    Name
                  </th>
                  <th class="text-right">
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
                  <td class="text-right">
                    <v-btn color="#2B3674" @click="deleteCategory(item.id)" rounded elevation="0">Delete</v-btn>
                  </td>
                </tr>
                </tbody>
              </v-table>
            </div>
              </v-col>
            </v-row>
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
        <AnlyticCard title="Totale retter" :number="totalDishes"
                     icon='<svg fill="#000000" width="20" height="20" viewBox="0 0 24 24" id="menu-food-left-2" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color"><g id="SVGRepo_bgCarrier" stroke-width="0"/><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/><g id="SVGRepo_iconCarrier"><path id="secondary" d="M8,18H18a1,1,0,0,1,.22,2l-8.8,2a1.9,1.9,0,0,1-1.62-.38A2.13,2.13,0,0,1,7,19.88V19A1,1,0,0,1,8,18Zm1.1,2h0Z" style="fill: #6595ca;"/><path id="primary" d="M7,20H18a1,1,0,0,0,1-1V3a1,1,0,0,0-1-1H7A2,2,0,0,0,5,4V18A2,2,0,0,0,7,20Z" style="fill: #000000;"/><path id="secondary-2" data-name="secondary" d="M8,11a1,1,0,0,1,1-1h6a1,1,0,0,1,0,2H9A1,1,0,0,1,8,11ZM8,7A1,1,0,0,1,9,6h6a1,1,0,0,1,0,2H9A1,1,0,0,1,8,7Z" style="fill: #6595ca;"/></g></svg>'/>
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
        <div class="d-flex justify-space-between align-center">
          <h1 class="fc-primary">Retter</h1>
          <div class="d-flex align-center ga-2 mb-2">
            <v-btn  @click="mode = !mode" :variant="mode ?'flat' : 'outlined'" color="#2B3674" elevation="0" rounded>Skift-tilstand</v-btn>
<!--            <v-btn  @click="mode = false" :variant="!mode ?'flat' : 'outlined'" elevation="0" color="#2B3674" rounded>Off</v-btn>-->
          </div>
        </div>
       <div class="d-flex mb-4">
         <v-btn v-if="mode" @click="changeMode('img')" :variant="menu.mode == 'img' ?'flat' : 'outlined'" color="#2B3674" elevation="0" rounded>Active</v-btn>
         <v-btn v-if="!mode" @click="changeMode('dishes')" :variant="menu.mode == 'dishes' ?'flat' : 'outlined'" color="#2B3674" elevation="0" rounded>Active</v-btn>
       </div>
        <v-card v-if="mode && menu.img != null">
          <v-img v-if="menu.img" :src="menu.img"></v-img>
        </v-card>

        <DishesTable :selectable="true" v-if="!mode" @edit="editMode = !editMode" @edit-data="(data)=>{selectedDish = data}"
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
import DropZone from "@/Components/dropZone.vue";
import moment from "moment";

export default {
  computed: {
    moment() {
      return moment
    }
  },
  props: {menu: Array, dishes: Array, categories: Array, totalDishes: Number, errors: Object},
  components: {DropZone, AddDishes, AnlyticCard, DishesTable, AuthenticatedLayout},
  data: () => ({
    selectedDish: [],
    selected: [],
    dialog: false,
    mode: false,
    addMode: false,
    editImageMode: false,
    editMode: false,
    addDish: false,
    addCate: false,
    loading: false,
    addImg: false,
    previews: [],
    acceptTypes: [
      "image/jpeg", "image/png", "image/bmp", "image/webp", "image/tiff", "image/vnd.dwg", "image/x-xbitmap",
      "image/x-jg", "image/x-xpixmap", "image/x-ms-bmp", "image/x-tga", "image/x-pcx", "image/x-pict",
      "image/x-cmu-raster", "image/x-portable-graymap", "image/x-portable-anymap", "image/x-portable-bitmap",
      "image/x-xwindowdump", "image/heic", "image/heic-sequence", "image/heif", "image/heif-sequence"
    ],
    file: [],
    category: {
      title: ''
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
    openAddImageDialog(){
      this.addImg = !this.addImg
      if (this.mode){
        this.previews = [{preview: this.menu.img != null ? this.menu.img : '' }];
      }
    },
    acceptFilesHandler(files) {
      this.file = files;
    },
    handlePreviews(previews) {
      this.previews = previews;
    },
    removePreview() {
      this.previews = [];
    },
    changeMode(mode) {
      // route('addCategory')
      router.post(`/menu/change-mode/${this.menu.id}/${mode}/`,{},{
        preserveScroll: true,
      })
    },
    addCategory() {
      // route('addCategory')
      router.post(`/add-category/${this.menu.id}`, {
          title: this.category.title,
          onSuccess: () => {
            this.ShowCate = false
            this.category.title = ''
          }
        },
        {
          preserveScroll: true,
        }
      )
    },
    addImage() {
      this.loading = true;
      // route('addCategory')
      router.post(`/menu/add-img/${this.menu.id}`, {
          file: this.file[0],
        },
        {
          preserveScroll: true,
          onSuccess: () => {
            this.addImg = false
            this.loading = false
            this.mode = true
            this.file = []
          }
        }
      )
    },
    deleteCategory(id) {
      router.delete(`/delete-category/${id}`, {
        preserveScroll: true,
      })
    },
    handleDelete(id) {
      router.delete(`/menu/delete-dish/${id}`,{
        preserveScroll: true,
      })
    }
  },
}
</script>
