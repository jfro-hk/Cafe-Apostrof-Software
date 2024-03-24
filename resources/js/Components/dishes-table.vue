<template>
  <div class="app-table">
    <h5 class="heading-5 text-capitalize">{{ title }}</h5>
    <v-data-table v-model="selected" :items="data" item-value="action" v-if="!selectable">
      <template v-slot:[`item.price`]="{ item }">
        {{ item.price }},-
      </template>
      <template v-slot:[`item.category`]="{ item }">
        {{ item.category.name }}
      </template>
      <template v-slot:[`item.description`]="{ item }" v-if="type == 'editable'">
        <show-description :description="item.description"/>
      </template>
      <template v-slot:[`item.dato`]="{ item }">
        {{ moment(item.dato).format('MMM DD')}}
      </template>
      <template v-slot:[`item.action`]="{ item }" v-if="type == 'editable'">
        <div style="position: relative;right: calc(100% - 50px);">
          <TableOption @edit="$emit('edit');handleSelection(item)" @delete="handleDelete(item.action)" :id="item.action"/>
        </div>
      </template>
    </v-data-table>
    <v-data-table v-model="selected" :items="data" item-value="action" v-if="selectable" show-select>
      <template v-slot:[`item.price`]="{ item }">
        {{ item.price }},-
      </template>
      <template v-slot:[`item.category`]="{ item }">
        {{ item.category.name }}
      </template>
      <template v-slot:[`item.description`]="{ item }" v-if="type == 'editable'">

        <show-description :description="item.description"/>
      </template>
      <template v-slot:[`item.dato`]="{ item }">
        {{ moment(item.dato).format('MMM DD')}}
      </template>
      <template v-slot:[`item.action`]="{ item }" v-if="type == 'editable'">
        <div style="position: relative;right: calc(100% - 50px);">
          <TableOption @edit="$emit('edit');handleSelection(item)" @delete="handleDelete(item.action)" :id="item.action"/>
        </div>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import TableOption from "@/Components/table-option.vue";
import moment from "moment";
import ShowDescription from "@/Components/show-description.vue";

export default {
  computed: {
    moment() {
      return moment
    }
  },
  components: {ShowDescription, TableOption},
  props: {title: String, data: Array, type: String,selectable:Boolean},
  data() {
    return {
      showDescription:false,
      selected: [],
      editData: [],
      editMode:false
    }
  },
  watch: {
    selected(val) {
      this.$emit('selected', val)
    }
  },
  methods: {
    handleSelection(select) {
      this.editData = select
      this.$emit('editData',this.editData)
    },
    handleDelete(id) {
      this.$emit('delete',id)
    }
  }
}
</script>
