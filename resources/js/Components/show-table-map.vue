<template>
  <v-dialog>
    <template v-slot:activator="{ props }">
      <v-btn v-bind="props" class="font-weight-bold" rounded variant="flat">
        view
      </v-btn>
    </template>

      <v-row justify="center">
        <v-card width="300" height="300" max-width="500">
          <div class="d-flex justify-center align-center" style="min-height: 30vh;">
        <TableMap :type="table.bord.includes('c')?'c':'s'"
                  :antal="table.antal"
                  :size="table.bord.includes('2')?'s':''" :total="table.bord.includes('2')?2:4"/>
          </div>

        </v-card>
      </v-row>
  </v-dialog>
</template>
<script>
import TableMap from "@/Components/table.vue";

export default {
  components: {TableMap},
  props: {table: String}
}
</script>
