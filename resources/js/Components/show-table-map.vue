<template>
  <v-dialog>
    <template v-slot:activator="{ props }">
      <v-btn size="small" v-bind="props" class="font-weight-bold" rounded variant="flat">
        view
      </v-btn>
    </template>
    <template v-slot:default="{ isActive }">
      <v-row justify="center">

        <v-card width="380" height="320" max-width="500">
          <div class="close-btn-table-view" style="position: absolute;right: 0">
            <v-btn icon elevation="0" size="small" @click="isActive.value = false">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M18.711 5.29289C19.1015 5.68342 19.1015 6.31658 18.711 6.70711L6.71101 18.7071C6.32049 19.0976 5.68732 19.0976 5.2968 18.7071C4.90628 18.3166 4.90628 17.6834 5.2968 17.2929L17.2968 5.29289C17.6873 4.90237 18.3205 4.90237 18.711 5.29289Z"
                      fill="#8C8B91"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M5.2968 5.29289C5.68732 4.90237 6.32049 4.90237 6.71101 5.29289L18.711 17.2929C19.1015 17.6834 19.1015 18.3166 18.711 18.7071C18.3205 19.0976 17.6873 19.0976 17.2968 18.7071L5.2968 6.70711C4.90628 6.31658 4.90628 5.68342 5.2968 5.29289Z"
                      fill="#8C8B91"/>
              </svg>
            </v-btn>
          </div>
          <div class="d-flex justify-center align-center w-100 pa-16">
        <TableMap :type="table.bord.includes('c')?'c':'s'"
                  :antal="table.antal"
                  :size="table.bord.includes('2')?'s':''"
                  :total="table.bord.includes('2')?2:4"/>
          </div>

        </v-card>
      </v-row>
    </template>
  </v-dialog>
</template>
<script>
import TableMap from "@/Components/table.vue";

export default {
  components: {TableMap},
  props: {table: String}
}
</script>
