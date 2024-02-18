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
<template>
  <AuthenticatedLayout>
    <Fullcalendar  />
  </AuthenticatedLayout>
</template>
