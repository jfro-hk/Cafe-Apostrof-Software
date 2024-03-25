<template>
  <!--  <Head title="Dashboard" />-->
  <AuthenticatedLayout>
    <div class="mb-5">
      <div class="heading-5 font-weight-bold fc-primary">Dashboard</div>
    </div>
    <v-dialog v-model="addRes"
              persistent
              :no-click-animation="true"
              width="1024"
    >

      <v-card class="overflow-y-auto">
        <!--        <v-card-title>-->
        <!--          <span class="text-h5">{{ editMode ? 'Edit Reservation' : 'Add Reservation' }}</span>-->
        <!--        </v-card-title>-->
        <v-card-text>
          <v-container>
            <v-row class="pl-2 pr-2">
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-label class="font-reg">Full name:</v-label>
                <v-text-field
                  class="input"
                  variant="text"
                  placeholder="Full name"
                  :rules="[(v) => !!v || 'Fulde navn er påkrævet']"
                  hide-details="auto"
                  v-model="reservation.fullname"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-label class="font-reg">Antal:</v-label>
                <v-text-field
                  class="input"
                  v-model="reservation.antal"
                  type="number"
                  :rules="[(v) => !!v || 'Antal er påkrævet']"
                  hide-details="auto"
                  variant="text"
                  placeholder="Antal"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <!--                form-control-->
                <v-label class="font-reg">Dato</v-label>
                <div class="flatpicker-s">
                  <v-text-field class="input" hide-details="auto" :rules="[(v) => !!v || 'Dato er påkrævet']" variant="text" readonly>
                    <v-overlay>
                      <template v-slot:activator>
                        <flat-pickr
                          v-model="reservation.date"
                          :config="config"
                          class="w-100"
                          style="width: 500px !important;"
                        />
                      </template>
                    </v-overlay>
                  </v-text-field>
                </div>
              </v-col>
              <v-col cols="12"
                     sm="6"
                     md="6"
              >
                <v-label class="font-reg">Tid</v-label>

                <v-text-field
                  hide-details="auto"
                  required
                  class="input"
                  :rules="[(v) => !!v || 'Tid er påkrævet']"
                  v-model="reservation.time"
                  type="Time"
                  variant="text"
                  placeholder="Time"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6">
                <v-label class="font-reg">Email</v-label>

                <v-text-field
                  required
                  hide-details="auto"
                  class="input"
                  v-model="reservation.email"
                  type="email"
                  variant="text"
                  placeholder="Email"
                ></v-text-field>
              </v-col>
              <v-col cols="12"
                     sm="6"
                     md="6"
              >
                <v-label class="font-reg">Nummer</v-label>
                <v-text-field
                  required
                  class="input"
                  v-model="reservation.number"
                  type="number"
                  variant="text"
                  placeholder="Nummer"
                ></v-text-field>
              </v-col>

              <v-col cols="12">
                <v-label class="font-reg">Beskrivelse:</v-label>

                <v-textarea  hide-details="auto" variant="plain"
                            v-model="reservation.description"
                            class="input-textarea" placeholder="Beskrivelse"></v-textarea>

              </v-col>

            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            variant="outlined"
            color="#0E0F3D"
            @click="addRes = !addRes"
            rounded
          >
            Close
          </v-btn>
          <v-btn
            color="#0E0F3D"
            @click="editMode?updateReservations() : addResReservations()"
            rounded
            :loading="loading"
            variant="flat"
          > Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-row>
      <v-col cols="12" sm="4" :md="3" :lg="4">
        <AnlyticCard :number="totalTodayReservations"
                     icon='<svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 4H17V3C17 2.73478 16.8946 2.48043 16.7071 2.29289C16.5196 2.10536 16.2652 2 16 2C15.7348 2 15.4804 2.10536 15.2929 2.29289C15.1054 2.48043 15 2.73478 15 3V4H9V3C9 2.73478 8.89464 2.48043 8.70711 2.29289C8.51957 2.10536 8.26522 2 8 2C7.73478 2 7.48043 2.10536 7.29289 2.29289C7.10536 2.48043 7 2.73478 7 3V4H6C5.20435 4 4.44129 4.31607 3.87868 4.87868C3.31607 5.44129 3 6.20435 3 7V19C3 19.7957 3.31607 20.5587 3.87868 21.1213C4.44129 21.6839 5.20435 22 6 22H18C18.7956 22 19.5587 21.6839 20.1213 21.1213C20.6839 20.5587 21 19.7957 21 19V7C21 6.20435 20.6839 5.44129 20.1213 4.87868C19.5587 4.31607 18.7956 4 18 4ZM8 17C7.80222 17 7.60888 16.9414 7.44443 16.8315C7.27998 16.7216 7.15181 16.5654 7.07612 16.3827C7.00043 16.2 6.98063 15.9989 7.01921 15.8049C7.0578 15.6109 7.15304 15.4327 7.29289 15.2929C7.43275 15.153 7.61093 15.0578 7.80491 15.0192C7.99889 14.9806 8.19996 15.0004 8.38268 15.0761C8.56541 15.1518 8.72159 15.28 8.83147 15.4444C8.94135 15.6089 9 15.8022 9 16C9 16.2652 8.89464 16.5196 8.70711 16.7071C8.51957 16.8946 8.26522 17 8 17ZM16 17H12C11.7348 17 11.4804 16.8946 11.2929 16.7071C11.1054 16.5196 11 16.2652 11 16C11 15.7348 11.1054 15.4804 11.2929 15.2929C11.4804 15.1054 11.7348 15 12 15H16C16.2652 15 16.5196 15.1054 16.7071 15.2929C16.8946 15.4804 17 15.7348 17 16C17 16.2652 16.8946 16.5196 16.7071 16.7071C16.5196 16.8946 16.2652 17 16 17ZM19 11H5V7C5 6.73478 5.10536 6.48043 5.29289 6.29289C5.48043 6.10536 5.73478 6 6 6H7V7C7 7.26522 7.10536 7.51957 7.29289 7.70711C7.48043 7.89464 7.73478 8 8 8C8.26522 8 8.51957 7.89464 8.70711 7.70711C8.89464 7.51957 9 7.26522 9 7V6H15V7C15 7.26522 15.1054 7.51957 15.2929 7.70711C15.4804 7.89464 15.7348 8 16 8C16.2652 8 16.5196 7.89464 16.7071 7.70711C16.8946 7.51957 17 7.26522 17 7V6H18C18.2652 6 18.5196 6.10536 18.7071 6.29289C18.8946 6.48043 19 6.73478 19 7V11Z" fill="#0E0F3D"/></svg>'
                     title="Dagens reservationer"/>
      </v-col>
      <v-col cols="12" sm="4" :md="3" :lg="4">
        <AnlyticCard :number="totalGallery"
                     icon='<svg fill="#0E0F3D" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 45.964 45.964" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"/><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M7.071,30.834V11.062H4.042C1.803,11.062,0,12.893,0,15.13v26.732c0,2.24,1.803,4.051,4.042,4.051h26.733 c2.238,0,4.076-1.811,4.076-4.051v-2.92H15.179C10.733,38.943,7.071,35.281,7.071,30.834z"/> <path d="M41.913,0.05H15.179c-2.238,0-4.066,1.813-4.066,4.051v26.733c0,2.241,1.829,4.067,4.066,4.067h26.734 c2.237,0,4.051-1.826,4.051-4.067V4.102C45.964,1.862,44.15,0.05,41.913,0.05z M41.363,28.589 c-0.223,0.412-0.652,0.656-1.12,0.656H17.336c-0.403,0-0.782-0.18-1.022-0.502c-0.24-0.324-0.313-0.736-0.197-1.123l3.277-10.839 c0.216-0.713,0.818-1.24,1.554-1.361c0.736-0.12,1.476,0.19,1.908,0.797l4.582,6.437c0.617,0.867,1.812,1.082,2.689,0.484 l4.219-2.865c0.434-0.295,0.967-0.402,1.48-0.299c0.515,0.102,0.966,0.408,1.253,0.848l4.229,6.472 C41.564,27.687,41.585,28.179,41.363,28.589z"/> </g> </g> </g></svg>'
                     title="Samlet events"/>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        <div class="d-flex justify-end align-center">
          <v-btn size="small" elevation="0" style="width: 30px; height: 50px;border-radius: 49px" rounded
                 color="#0E0F3D"
                 @click="addRes = !addRes">
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </div>
      </v-col>
      <v-col cols="12" md="8" lg="8">
        <CheckTable type="editable" @editData="editReservation" @delete="deleteReservation" :data="reservations"
                    title="Reservationer"/>
      </v-col>
      <v-col cols="12" md="4" lg="4">
        <CheckTable type="editable" @delete="eventDelete" :data="events"/>
      </v-col>
      <!--      <div class="task-table"></div>-->
    </v-row>
  </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import AnlyticCard from '@/Components/anlytic-card.vue'
import CheckTable from '@/Components/dishes-table.vue'
import {router} from "@inertiajs/vue3";
import moment from "moment";
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
  name: 'DashboardPage',
  props: {
    reservations: Object,
    events: Object,
    totalTodayReservations: Number,
    totalGallery: Number,
  },
  data: () => ({
    config: {
      wrap: true, // set wrap to true only when using 'input-group'
      altFormat: 'M j, Y',
      altInput: true,
      dateFormat: 'Y-m-d',
    },
    loading:false,
    addRes: false,
    editMode: false,
    reservation: {
      id: null,
      fullname: null,
      email: null,
      number: null,
      date: null,
      antal: null,
      time: null,
      description: null,
    }
  }),
  components: {CheckTable, AuthenticatedLayout, AnlyticCard, flatPickr},
  methods: {
    eventDelete(id) {
      router.delete(`/delete-event/${id}`, {
        preserveScroll: true
      })
    },
    editReservation(data) {
      this.editMode = true
      this.addRes = !this.addRes
      this.reservation.fullname = data["fulde navn"]
      this.reservation.date = data["dato"]
      this.reservation.time = data["tid"]
      this.reservation.description = data["description"]
      this.reservation.antal = data["antal"]
      this.reservation.id = data["action"]
      // console.log(data)

    },
    addReservations() {
      this.loading = true
      router.get(`/reservation-add`, {
        fullname: this.reservation.fullname,
        date: this.reservation.date,
        time: this.reservation.time,
        antal: this.reservation.antal,
        description: this.reservation.description
      }, {
        preserveScroll:true,
        onSuccess: () => {
          this.loading = false
          this.reservation.fullname = null
          this.reservation.date = null
          this.reservation.time = null
          this.reservation.antal = null
          this.reservation.description = null
          this.editMode = false
          this.addRes = !this.addRes
        }
      })
    },
    addResReservations() {
      this.loading = true
      router.get(`/reservation-add-res/${Object.values(this.reservation)}`, {
        fullname: this.reservation.fullname,
        date: this.reservation.date,
        time: this.reservation.time,
        antal: this.reservation.antal,
        description: this.reservation.description
      }, {
        preserveScroll:true,
        onSuccess: () => {
          this.loading = false
          this.reservation.fullname = null
          this.reservation.date = null
          this.reservation.time = null
          this.reservation.antal = null
          this.reservation.description = null
          this.editMode = false
          this.addRes = !this.addRes
        }
      })
    },
    updateReservations() {
      this.loading = true
      router.post(`/reservation-update/${this.reservation.id}`, {
        fullname: this.reservation.fullname,
        date: this.reservation.date,
        time: this.reservation.time,
        antal: this.reservation.antal,
        description: this.reservation.description
      }, {
        preserveScroll:true,
        onSuccess: () => {
          this.loading = false
          this.reservation.fullname = null
          this.reservation.date = null
          this.reservation.time = null
          this.reservation.antal = null
          this.reservation.description = null
          this.editMode = false
          this.addRes = !this.addRes
        }
      })
    },
    deleteReservation(id) {
      router.delete(`/reservation-delete/${id}`,{
        preserveScroll:true,
      })
    }
  },
  computed: {
    moment() {
      return moment
    },
    allowedDates() {
      return (date) => {
        // Check if the date is not a Monday
        const isMonday = date.getDay() === 1;

        // Check if the date is not in the past
        const currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0); // Set the time to midnight
        const isPast = date.getTime() < currentDate.getTime();

        // Return true only if it's not a Monday and not in the past
        return !isMonday && !isPast;
      };
    }
  }
}
</script>
