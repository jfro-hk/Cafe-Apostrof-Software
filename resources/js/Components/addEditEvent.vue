<template>
  <v-card>
    <v-card-title>
      {{event.startDate}}
      <span class="text-h5">Add Event</span>
    </v-card-title>
    <v-card-text>
      <v-container>
        <v-row>
          <v-col
            cols="12"
          >
            <v-label class="font-reg">Title:</v-label>
            <v-text-field
              class="input"
              variant="text"
              placeholder="Title"
              v-model="event.title"
              :rules="titleRules"
              required
            ></v-text-field>
          </v-col>
          <v-col cols="12"
                 sm="6"
                 md="6"
          >
            <v-label class="font-reg">Price $:</v-label>
            <v-menu>
              <template v-slot:activator="{ props }">
                <v-text-field
                  readonly
                  class="input"
                  v-bind="props"
                  placeholder="Chose start date"
                  :model-value="formatDate(event.startDate)"
                  variant="text"
                  required
                  hide-details
                ></v-text-field>
              </template>
              <v-date-picker v-model="event.startDate" :max-width="$vuetify.display.width < 300 ? 250 : 380"></v-date-picker>
            </v-menu>
          </v-col>
          <v-col cols="12"
                 sm="6"
                 md="6"
          >
            <v-label class="font-reg">Price $:</v-label>
            <v-menu>
              <template v-slot:activator="{ props }">
                <v-text-field
                  readonly
                  v-bind="props"
                  placeholder="Chose end date"
                  :model-value="formatDate(event.endDate)"
                  variant="text"
                  class="input"
                  required
                  hide-details
                ></v-text-field>
              </template>
              <v-date-picker v-model="event.endDate" :max-width="$vuetify.display.width < 300 ? 250 : 380"></v-date-picker>
            </v-menu>
          </v-col>
          <v-col cols="12">
            <v-label class="font-reg">Description:</v-label>

            <v-textarea variant="plain"
                        v-model="event.description"
                        class="input-textarea" placeholder="Description"></v-textarea>
          </v-col>
        </v-row>
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn
        variant="outlined"
        color="#0E0F3D"
        @click="this.$emit('close')"
        rounded
      >
        Close
      </v-btn>
      <v-btn
        color="#0E0F3D"
        @click="addEditEvent"
        rounded
        variant="flat"
      > Save
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import {router} from "@inertiajs/vue3";
import moment from "moment";

export default {
  props:{editMode:Boolean,selectedEvent:Object,selectedDate:String},
  data() {
    return {
      titleRules: [
        v => !!v || 'Title is required',
        v => (v && v.length <= 255) || 'Title must be less than 255 characters',
      ],
      selected:[],
      priceRules: [
        v => !!v || 'Price is required',
        v => !isNaN(parseFloat(v)) && isFinite(v) || 'Price must be a number',
      ],
      event: {
        title: this.editMode ? this.selectedEvent.title:'',
        startDate: this.editMode ? this.selectedEvent.startDate: this.selectedDate,
        endDate: this.editMode ? this.selectedEvent.endDate:null,
        description: this.editMode ? this.selectedEvent.description: null,
      },
      status: false
    };
  },
  watch:{
    status(){

    }
  },
  methods:{
     formatDate(date) {
      return moment(date).format('DD/MM/YYYY');
    },
    addEditEvent() {
      if (this.isValid) {
        router.post(`/menu/${this.editMode ? 'update':'add'}-event/${this.editMode ? this.selectedEvent.id:''}`, {
          title: this.event.title,
          startDate: this.event.startDate,
          endDate: this.event.endDate,
          description: this.event.description,
          event_id: this.selectedEvent.id,
        }, {
          onSuccess: () => {
            this.status = false
            this.$emit('status',this.status)
          }
        })
      }
    },
  },
  computed: {
    isValid() {
      const isTitleValid = this.event.title && this.titleRules.every(rule => rule(this.event.title));
      const isPriceValid = this.event.price && this.priceRules.every(rule => rule(this.event.price));
      return isTitleValid && isPriceValid;
    }
  }
}
</script>
