<template>
  <AuthenticatedLayout>
    <div class="mb-5">
      <!--      <Breadcrumbs :items="breadcrumbs" class="pa-0 mt-1" />-->
      <div class="heading-5 font-weight-bold fc-primary">Calendar</div>
    </div>
    <Fullcalendar />
  </AuthenticatedLayout>
</template>
<script>
import Fullcalendar from "@/Components/Fullcalendar.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
export default {
  components: {
    Fullcalendar,
    AuthenticatedLayout
  },
  data() {
    return {
    }
  }
}
</script>
