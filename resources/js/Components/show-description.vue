<template>
  <v-dialog>
    <template v-slot:activator="{ props }">
      <v-btn v-bind="props" class="font-weight-bold" rounded variant="flat">
        view
      </v-btn>
    </template>
    <v-row justify="center">
      <v-card max-width="500">
        <div class="pa-10 text-center">
          {{description}}
        </div>
      </v-card>
    </v-row>
  </v-dialog>
</template>
<script>
export default {
  props:{description:String}
}
</script>
