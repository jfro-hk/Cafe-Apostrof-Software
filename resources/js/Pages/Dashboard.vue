<template>
  <!--  <Head title="Dashboard" />-->
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
    <v-row>
      <v-col cols="12" sm="4" :md="3" :lg="4">
        <AnlyticCard />
      </v-col>
      <v-col cols="12" sm="4" :md="3" :lg="4">
        <AnlyticCard />
      </v-col>
      <v-col cols="12" sm="4" :md="3" :lg="4">
        <AnlyticCard />
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-data-table></v-data-table>
      </v-col>
      <v-col>
        <TasksTable />
      </v-col>
      <!--      <div class="task-table"></div>-->
    </v-row>
  </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
// import Head from '@inertiajs/vue3'
import AnlyticCard from '@/Components/anlytic-card.vue'
import TasksTable from '@/Components/tasks-table.vue'

export default {
  name: 'DashboardPage',
  components: { AuthenticatedLayout, Breadcrumbs, AnlyticCard, TasksTable },
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
