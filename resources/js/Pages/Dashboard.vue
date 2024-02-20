<template>
  <!--  <Head title="Dashboard" />-->
  <AuthenticatedLayout>
    <div class="mb-5">
      <div class="heading-5 font-weight-bold fc-primary">Main Dashboard</div>
    </div>
    <!--    <v-card>-->
    <!--      <v-card-text>-->
    <!--        <div class="text-h6 text-medium-emphasis">Welcome back, {{ $page.props.auth.user.name }}!</div>-->
    <!--      </v-card-text>-->
    <!--    </v-card>-->
    <v-row>
      <v-col cols="12" sm="4" :md="3" :lg="4">
        <AnlyticCard title="Today's Reservations"/>
      </v-col>
      <v-col cols="12" sm="4" :md="3" :lg="4">
        <AnlyticCard />
      </v-col>
      <v-col cols="12" sm="4" :md="3" :lg="4">
        <AnlyticCard />
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="8" lg="8">
        <CheckTable title="reservations" />
      </v-col>
      <v-col cols="12" md="4" lg="4">
        <CheckTable />
      </v-col>
      <!--      <div class="task-table"></div>-->
    </v-row>
  </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
// import Head from '@inertiajs/vue3'
import AnlyticCard from '@/Components/anlytic-card.vue'
import CheckTable from '@/Components/dishes-table.vue'

export default {
  name: 'DashboardPage',
  components: { CheckTable, AuthenticatedLayout, AnlyticCard },
}
</script>
