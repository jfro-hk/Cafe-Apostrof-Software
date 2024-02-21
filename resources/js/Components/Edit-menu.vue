<template>
  <v-row justify="center">
    <v-card>
      <v-card-title>
        <span class="text-h5">Edit Menu</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col
              cols="12"
              sm="6"
              md="6"
            >
              <v-text-field
                class="input"
                variant="text"
                placeholder="Title"
                v-model="editData.title"
                :rules="[value => !!value || 'The title field is required']"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="12"
              sm="6"
              md="6"
            >
              <v-combobox
                class="input"
                variant="text"
                :items="categories"
                item-title="name"
                item-value="id"
                :rules="[value => !!value || 'Select a category']"
                v-model="editData.category_id"
                placeholder="Category"
              ></v-combobox>
            </v-col>

            <v-col cols="12">
              <v-textarea
                variant="plain"
                v-model="editData.description"
                class="input-textarea"
                placeholder="Description"
              ></v-textarea>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          variant="outlined"
          color="#0E0F3D"
          @click="$emit('close', false)"
          rounded
        >
          Close
        </v-btn>
        <v-btn
          color="#0E0F3D"
          @click="update"
          rounded
          variant="flat"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-row>
</template>

<script>
import { router } from "@inertiajs/vue3";
export default {
  props: { data: Object, categories: Array, toggle: Boolean },
  data() {
    return {
      editData: {
        title: this.data.title,
        description: this.data.description,
        category_id: this.data.category_id
      },
      status: true
    };
  },
  methods: {
    update() {
      router.post(`update-menu/${this.data.id}`, {
        title: this.editData.title,
        category: this.editData.category_id,
        description: this.editData.description
      }, {
        onSuccess: () => {
          this.status = false;
          this.$emit('status', this.status);
        }
      });
    }
  }
};
</script>
