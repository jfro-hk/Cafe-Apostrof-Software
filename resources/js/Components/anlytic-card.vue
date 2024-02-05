<template>
  <div class="analytic-card">
    <div class="d-flex gap-12 align-center w-100">
      <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
        <circle cx="28" cy="28" r="28" fill="#F4F7FE" />
      </svg>
      <div class="d-flex flex-column">
        <span class="fc-secondary font-weight-bold">{{ title }}</span>
        <span class="fc-primary font-weight-bold">123</span>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: { title: String, img: String },
}
</script>
