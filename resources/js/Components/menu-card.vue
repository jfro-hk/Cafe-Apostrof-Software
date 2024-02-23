<template>
    <div>
  <v-hover v-slot="{ isHovering, props }">
<!--  <div class="menu-card pa-5" v-bind="props">-->
    <v-card
      class="menu-card pa-5"
      max-width="344"
      v-bind="props"
      elevation="1"
      rounded
    >
    <!--          <v-img src="https://i.postimg.cc/2y8FMGPB/ca-food-1.png"></v-img>-->
    <v-img src="https://i.postimg.cc/kX2r6P5z/fakurian-design-bexwsd-M5-BCw-unsplash-2-1.png" rounded>
      <svg fill="#000000" width="100" height="100" viewBox="0 0 24 24" id="menu-food-left-2" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color">

        <g id="SVGRepo_bgCarrier" stroke-width="0"/>

        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

        <g id="SVGRepo_iconCarrier">

          <path id="secondary" d="M8,18H18a1,1,0,0,1,.22,2l-8.8,2a1.9,1.9,0,0,1-1.62-.38A2.13,2.13,0,0,1,7,19.88V19A1,1,0,0,1,8,18Zm1.1,2h0Z" style="fill: #6595ca;"/>

          <path id="primary" d="M7,20H18a1,1,0,0,0,1-1V3a1,1,0,0,0-1-1H7A2,2,0,0,0,5,4V18A2,2,0,0,0,7,20Z" style="fill: #000000;"/>

          <path id="secondary-2" data-name="secondary" d="M8,11a1,1,0,0,1,1-1h6a1,1,0,0,1,0,2H9A1,1,0,0,1,8,11ZM8,7A1,1,0,0,1,9,6h6a1,1,0,0,1,0,2H9A1,1,0,0,1,8,7Z" style="fill: #6595ca;"/>

        </g>

      </svg>
      <h5 class="heading-5 text-capitalize">{{ menu.title }}</h5></v-img>
    <div class="d-flex flex-column pa-5">
      <span class="fc-primary text-capitalize">{{ menu.title }}</span>
      <span class="fc-secondary">{{ menu.description }}</span>
    </div>
    <div class="d-flex justify-space-between align-center pa-5">
      <span class="font-weight-bold fc-primary">{{ moment(menu.created_at).format('YYYY MMM DD') }}</span>
<!--      <Link class="v-btn" :href="`menu/view/${menu.slug}`" rounded elevation="0">View</Link>-->
    </div>
    <v-overlay
      :model-value="isHovering"
      contained
      scrim="#036358"
      class="align-center justify-center"
    >
      <div class="d-flex flex-column ga-2">
        <v-btn icon elevation="0" @click="this.$emit('edit',menu)">
          <svg width="24" height="24" viewBox="0 0 24 24" id="_24x24_On_Light_Edit" data-name="24x24/On Light/Edit" xmlns="http://www.w3.org/2000/svg">
            <rect id="view-box" width="24" height="24" fill="none"/>
            <path id="Shape" d="M.75,17.5A.751.751,0,0,1,0,16.75V12.569a.755.755,0,0,1,.22-.53L11.461.8a2.72,2.72,0,0,1,3.848,0L16.7,2.191a2.72,2.72,0,0,1,0,3.848L5.462,17.28a.747.747,0,0,1-.531.22ZM1.5,12.879V16h3.12l7.91-7.91L9.41,4.97ZM13.591,7.03l2.051-2.051a1.223,1.223,0,0,0,0-1.727L14.249,1.858a1.222,1.222,0,0,0-1.727,0L10.47,3.91Z" transform="translate(3.25 3.25)" fill="#141124"/>
          </svg>
        </v-btn>
      <v-btn icon elevation="0" @click="redirect">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 87 87" fill="none">
          <path d="M78.6227 41.3428C76.3219 37.3523 63.6674 17.3282 42.1693 17.9753C22.289 18.4786 10.785 35.9503 7.65735 41.3428C7.34182 41.8893 7.17571 42.5092 7.17571 43.1403C7.17571 43.7714 7.34182 44.3913 7.65735 44.9378C9.9222 48.8563 22.0374 68.3053 43.2119 68.3053H44.1107C63.991 67.802 75.531 50.3303 78.6227 44.9378C78.9382 44.3913 79.1043 43.7714 79.1043 43.1403C79.1043 42.5092 78.9382 41.8893 78.6227 41.3428ZM43.9309 61.1153C28.4365 61.4748 18.3345 48.2092 15.1709 43.1403C18.7659 37.3523 28.1489 25.5248 42.5289 25.1653C57.9514 24.7698 68.0893 38.0713 71.2889 43.1403C67.586 48.9282 58.3109 60.7558 43.9309 61.1153Z" fill="#231F20"/>
          <path d="M43.14 30.5576C40.6514 30.5576 38.2187 31.2956 36.1495 32.6782C34.0804 34.0607 32.4676 36.0259 31.5153 38.325C30.5629 40.6242 30.3138 43.1541 30.7993 45.5948C31.2848 48.0356 32.4831 50.2776 34.2428 52.0373C36.0025 53.797 38.2445 54.9954 40.6853 55.4808C43.126 55.9663 45.656 55.7172 47.9551 54.7648C50.2543 53.8125 52.2194 52.1998 53.602 50.1306C54.9846 48.0614 55.7225 45.6287 55.7225 43.1401C55.7225 39.803 54.3968 36.6026 52.0372 34.2429C49.6775 31.8833 46.4771 30.5576 43.14 30.5576ZM43.14 48.5326C42.0735 48.5326 41.0309 48.2164 40.1441 47.6238C39.2573 47.0313 38.5661 46.1891 38.158 45.2037C37.7498 44.2184 37.643 43.1341 37.8511 42.0881C38.0592 41.042 38.5728 40.0812 39.3269 39.327C40.0811 38.5729 41.0419 38.0593 42.088 37.8512C43.134 37.6432 44.2183 37.75 45.2036 38.1581C46.189 38.5662 47.0312 39.2574 47.6237 40.1442C48.2162 41.031 48.5325 42.0736 48.5325 43.1401C48.5325 44.5703 47.9644 45.9419 46.9531 46.9532C45.9418 47.9645 44.5702 48.5326 43.14 48.5326Z" fill="#231F20"/>
        </svg>
      </v-btn>
      <v-btn icon elevation="0" @click="deleteMenu">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 153 153" fill="none">
          <path d="M85.1722 76.2164L112.483 48.9689C113.679 47.7729 114.351 46.1508 114.351 44.4594C114.351 42.768 113.679 41.1459 112.483 39.9499C111.287 38.7539 109.665 38.082 107.974 38.082C106.282 38.082 104.66 38.7539 103.464 39.9499L76.2167 67.2609L48.9692 39.9499C47.7733 38.7539 46.1511 38.082 44.4598 38.082C42.7684 38.082 41.1463 38.7539 39.9503 39.9499C38.7543 41.1459 38.0824 42.768 38.0824 44.4594C38.0824 46.1508 38.7543 47.7729 39.9503 48.9689L67.2613 76.2164L39.9503 103.464C39.355 104.054 38.8825 104.757 38.56 105.531C38.2375 106.305 38.0715 107.135 38.0715 107.973C38.0715 108.812 38.2375 109.642 38.56 110.416C38.8825 111.19 39.355 111.892 39.9503 112.483C40.5407 113.078 41.2432 113.551 42.0172 113.873C42.7911 114.196 43.6213 114.362 44.4598 114.362C45.2982 114.362 46.1284 114.196 46.9024 113.873C47.6763 113.551 48.3788 113.078 48.9692 112.483L76.2167 85.1718L103.464 112.483C104.055 113.078 104.757 113.551 105.531 113.873C106.305 114.196 107.135 114.362 107.974 114.362C108.812 114.362 109.642 114.196 110.416 113.873C111.19 113.551 111.893 113.078 112.483 112.483C113.078 111.892 113.551 111.19 113.873 110.416C114.196 109.642 114.362 108.812 114.362 107.973C114.362 107.135 114.196 106.305 113.873 105.531C113.551 104.757 113.078 104.054 112.483 103.464L85.1722 76.2164Z" fill="#231F20"/>
        </svg>
      </v-btn>
      </div>
    </v-overlay>
<!--  </div>-->
    </v-card>
  </v-hover>
    </div>
</template>
<script>

import {router} from "@inertiajs/vue3";
import moment from "moment";

export default {
  computed: {
    moment() {
      return moment
    }
  },
  props:{menu:Object},
  data: () => ({
menuData:[]
  }),
  methods:{
    redirect(){
      router.visit(`/menu/view/${this.menu.slug}`)
    },
    deleteMenu(){
      router.delete(`/delete-menu/${this.menu.id}`)
    }
  },
  mounted() {
    this.menuData = this.menu
  }
}
</script>
