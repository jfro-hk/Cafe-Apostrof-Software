<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <div class="mb-5">
      <Breadcrumbs :items="breadcrumbs" class="pa-0 mt-1" />
      <div class="heading-5 font-weight-bold fc-primary">Main Dashboard</div>
    </div>
    <!--    <v-card>-->
    <!--      <v-card-text>-->
    <!--        <div class="text-h6 text-medium-emphasis">Welcome back, {{ $page.props.auth.user.name }}!</div>-->
    <!--      </v-card-text>-->
    <!--    </v-card>-->
    <div class="analytic-card">
      <div class="d-flex gap-12 align-center w-100">
        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
          <circle cx="28" cy="28" r="28" fill="#F4F7FE" />
        </svg>
        <div class="d-flex flex-column">
          <span class="fc-secondary font-weight-bold">Total orders</span>
          <span class="fc-primary font-weight-bold">123</span>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
export default {
  name: 'DashboardPage',
  data() {
    return {
      breadcrumbs: [
        {
          title: 'Dashboard',
          disabled: true,
        },
      ],
    }
  },
}
</script>
