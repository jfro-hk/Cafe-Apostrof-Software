<template>
  <div class="menu-card pa-5">
    <!--          <v-img src="https://i.postimg.cc/2y8FMGPB/ca-food-1.png"></v-img>-->
    <v-img src="https://i.postimg.cc/kX2r6P5z/fakurian-design-bexwsd-M5-BCw-unsplash-2-1.png" rounded><h5 class="heading-5 text-capitalize">{{ title }}</h5></v-img>
    <div class="d-flex flex-column pa-5">
      <span class="fc-primary text-capitalize">{{ title }}</span>
      <span class="fc-secondary">By Esthera Jackson</span>
    </div>
    <div class="d-flex justify-space-between align-center pa-5">
      <span class="font-weight-bold fc-primary">Current Bid: 0.91 ETH</span>
      <v-btn size="large" color="#0E0F3D" rounded elevation="0">View</v-btn>
    </div>
  </div>
</template>
<script>
export default {
  props:{title:String}
}
</script>
