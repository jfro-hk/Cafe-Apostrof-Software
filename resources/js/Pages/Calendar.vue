<template>
  <AuthenticatedLayout>
    <div class="position-fixed" style="right: 0;
    bottom: 0;
    z-index: 1;
    margin: 20px;">
      <v-btn size="small" elevation="0" style="width: 30px; height: 50px;border-radius: 49px" rounded color="#0E0F3D"
             @click="addEvent = !addEvent">
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </div>
    <v-dialog v-model="addEvent"
              width="800">
      <v-card>
<!--        <v-card-title>-->
<!--          <span class="text-h5">{{ editMode ? 'Edit Event' : 'Add Event' }}</span>-->
<!--        </v-card-title>-->
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
                <v-label class="font-reg">Start date</v-label>
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
                  <v-date-picker v-model="event.startDate"
                                 :max-width="$vuetify.display.width < 300 ? 250 : 380"></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12"
                     sm="6"
                     md="6"
              >
                <v-label class="font-reg">End date</v-label>
                <v-menu>
                  <template v-slot:activator="{ props }">
                    <v-text-field
                      readonly
                      v-bind="props"
                      placeholder="Chose end date"
                      :model-value="event.endDate !== null ? formatDate(event.endDate):''"
                      variant="text"
                      class="input"
                      required
                      hide-details
                    ></v-text-field>
                  </template>
                  <v-date-picker :min="new Date('2024-03-15')" v-model="event.endDate"
                                 :max-width="$vuetify.display.width < 300 ? 250 : 380"></v-date-picker>
                </v-menu>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-label class="font-reg">Start Time:</v-label>
                <v-text-field
                  class="input"
                  variant="text"
                  type="time"
                  v-model="event.startTime"

                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-label class="font-reg">End Time:</v-label>
                <v-text-field
                  class="input"
                  variant="text"
                  type="time"
                  v-model="event.endTime"

                ></v-text-field>
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
            @click="addEvent = false"
            rounded
          >
            Close
          </v-btn>
          <v-btn
            v-if="editMode"
            variant="outlined"
            color="#0E0F3D"
            @click="deleteEvent"
            rounded
          >
            Delete
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
    </v-dialog>
    <div class="mb-5">
      <!--      <Breadcrumbs :items="breadcrumbs" class="pa-0 mt-1" />-->
      <div class="heading-5 font-weight-bold fc-primary">Kalender</div>
    </div>
    <schedule-x :eventsData="events" />

<!--    <Fullcalendar :events="events" @selected-event="(date)=>{selectedEvent = date}"-->
<!--                  @selected-date="(date)=>{selectedDate = date}"/>-->
<!--    <vue-calendar :events-data="events"/>-->
  </AuthenticatedLayout>
</template>
<script>
// import Fullcalendar from "@/Components/Fullcalendar.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import moment from "moment";
import {router} from "@inertiajs/vue3";
import ScheduleX from "@/Components/schedule-x.vue";
// import VueCalendar from "@/Components/vue-calendar.vue";

export default {
  props: {
    events: Object
  },
  computed: {
    moment() {
      return moment
    }
  },
  components: {
    ScheduleX,
    // VueCalendar,
    // Fullcalendar,

    AuthenticatedLayout
  },
  data: () => ({
    titleRules: [
      v => !!v || 'Title is required',
      v => (v && v.length <= 255) || 'Title must be less than 255 characters',
    ],
    addEvent: false,
    editMode: false,
    selectedEvent: [],
    localEvents: [],
    event: {
      title: '',
      startTime: null,
      endTime: null,
      startDate: null,
      endDate: null,
      description: null,
    },
    selectedDate: null
  }),
  watch: {
    events: {
      immediate: true,
      handler(newEvents) {
        this.localEvents = newEvents;
        if (this.editMode){
          this.addEvent = false
        }
      }
    },
    selectedDate(val) {
      if (val !== null) {
        this.addEvent = true
        this.editMode = false

        this.event.startDate = this.selectedDate
        this.event.title = null
        this.event.endDate = null
        this.event.startTime = null
        this.event.endTime = null
        this.event.description = null
      }
    },
    selectedEvent(val) {
      if (val !== null) {
        this.addEvent = true
        this.editMode = true
        this.event.title = this.selectedEvent.title
        this.event.startDate = this.selectedEvent.start
        this.event.endDate = this.selectedEvent.extendedProps.end != this.selectedEvent.extendedProps.start_date ?this.selectedEvent.extendedProps.end_date:null
        this.event.startTime = this.selectedEvent.extendedProps.start_time
        this.event.description = this.selectedEvent.extendedProps.description
        // this.event.endTime = this.selectedEvent.extendedProps.end_time !== null ?this.selectedEvent.extendedProps.end_time : null
        // this.event.startDate = this.selectedEvent.start
      }
    }
  },
  methods: {
    deleteEvent(){
      router.delete(`delete-event/${this.selectedEvent.id}`)
    },
    addEditEvent() {
      // if (this.isValid) {
      router.post(`${this.editMode ? 'update' : 'add'}-event${this.editMode ? '/' + this.selectedEvent.id : '/'}`, {
        title: this.event.title,
        startDate: this.event.startDate,
        endDate: this.event.endDate,
        description: this.event.description,
        event_id: this.selectedEvent.id,
      }, {
        method:"POST",
        onSuccess: () => {
          this.status = false
          this.addEvent = false
          this.event.title = ''
          this.$emit('status', this.status)
        }
      })
      // }
    },
    formatDate(date) {
      return moment(date).format('DD/MM/YYYY');
    },
  },

}
</script>
