<template>
  <v-menu v-model="menu" :close-on-content-click="false" location="bottom">
    <template v-slot:activator="{ props }">
      <v-btn icon elevation="0" v-bind="props" class="ml-auto d-flex">
        <svg class="align-self-center" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66602 8.00033C6.66602 7.26395 7.26297 6.66699 7.99935 6.66699C8.73573 6.66699 9.33268 7.26395 9.33268 8.00033C9.33268 8.73671 8.73573 9.33366 7.99935 9.33366C7.26297 9.33366 6.66602 8.73671 6.66602 8.00033Z" fill="#8C8B91" />
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66602 3.33333C6.66602 2.59695 7.26297 2 7.99935 2C8.73573 2 9.33268 2.59695 9.33268 3.33333C9.33268 4.06971 8.73573 4.66667 7.99935 4.66667C7.26297 4.66667 6.66602 4.06971 6.66602 3.33333Z" fill="#8C8B91" />
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66602 12.6663C6.66602 11.93 7.26297 11.333 7.99935 11.333C8.73573 11.333 9.33268 11.93 9.33268 12.6663C9.33268 13.4027 8.73573 13.9997 7.99935 13.9997C7.26297 13.9997 6.66602 13.4027 6.66602 12.6663Z" fill="#8C8B91" />
        </svg>
      </v-btn>
    </template>

    <v-card min-width="300" class="actions-chip-card">
      <v-list class="px-0 py-0">
        <v-list-item class="px-0 py-0">
          <v-btn @click="this.$emit('edit')" class="w-100">edit</v-btn>
          <v-btn @click="handleDelete(id)" class="w-100">Delete</v-btn>
        </v-list-item>
      </v-list>
    </v-card>
  </v-menu>
</template>
<script>
export default {
  props:{id:Number},
  data: () => ({
    menu:false,
    editMode:false
  }),
  methods:{
    handleDelete(){
      this.$emit('delete',this.id)
    }
  }
}
</script>
