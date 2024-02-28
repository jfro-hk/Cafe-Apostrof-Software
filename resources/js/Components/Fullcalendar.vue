<template>
  <div>
    <v-card class="bg-white w-100" elevation="0">
      <!--    <v-row no-gutters class="wp">-->
      <!--      <v-col :cols="isSideDateVisible ? 3 : 1" class="col-right-s" :style="isSideDateVisible ? 'margin-left: 0.3.9rem;' : 'margin-left: 10.2px;'">-->
      <!--        <v-sheet class="pa-2 ma-2 wsheet">-->
      <!--          &lt;!&ndash; <v-btn size="small" class="close-btn"> &ndash;&gt;-->
      <!--          <a class="close-btn box-sh" @click="toggleSideDate">-->
      <!--            <v-icon class="arrows-icon">-->
      <!--              <svg xmlns="http://www.w3.org/2000/svg" v-if="!isSideDateVisible" width="20" height="20" viewBox="0 0 20 20" fill="none">-->
      <!--                <mask id="mask0_228_10874" style="mask-type: alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">-->
      <!--                  <rect x="20" y="20" width="20" height="20" transform="rotate(-180 20 20)" fill="#D9D9D9" />-->
      <!--                </mask>-->
      <!--                <g mask="url(#mask0_228_10874)">-->
      <!--                  <path d="M8 5L13 10L8 15L6.9375 13.9375L10.875 10L6.9375 6.0625L8 5Z" fill="#403E48" />-->
      <!--                </g>-->
      <!--              </svg>-->
      <!--              <svg xmlns="http://www.w3.org/2000/svg" v-else width="20" height="20" viewBox="0 0 20 20" fill="none">-->
      <!--                <mask id="mask0_228_10870" style="mask-type: alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">-->
      <!--                  <rect width="20" height="20" fill="#D9D9D9" />-->
      <!--                </mask>-->
      <!--                <g mask="url(#mask0_228_10870)">-->
      <!--                  <path d="M12 15L7 10L12 5L13.0625 6.0625L9.125 10L13.0625 13.9375L12 15Z" fill="#403E48" />-->
      <!--                </g>-->
      <!--              </svg>-->
      <!--            </v-icon>-->
      <!--          </a>-->
      <!--          &lt;!&ndash; </v-btn> &ndash;&gt;-->
      <!--        </v-sheet>-->
      <!--      </v-col>-->
      <v-card-text>
      <v-row>
        <v-col cols="12">
          <v-sheet class=" wsheet">
            <div class="calendar-header">
              <div class="navigation">
                <v-btn rounded color="#0E0F3D" @click="navigate('today')">I dag</v-btn>

                <div class="header-btns">
                  <v-btn rounded color="#0E0F3D" @click="navigate('prev')">
                    <v-icon class="arrows-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <mask id="mask0_228_10870" style="mask-type: alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                              width="20" height="20">
                          <rect width="20" height="20" fill="#fff"/>
                        </mask>
                        <g mask="url(#mask0_228_10870)">
                          <path d="M12 15L7 10L12 5L13.0625 6.0625L9.125 10L13.0625 13.9375L12 15Z" fill="#fff"/>
                        </g>
                      </svg>
                    </v-icon>
                  </v-btn>
                  <v-btn rounded color="#0E0F3D" @click="navigate('next')">
                    <v-icon class="arrows-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <mask id="mask0_228_10874" style="mask-type: alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                              width="20" height="20">
                          <rect x="20" y="20" width="20" height="20" transform="rotate(-180 20 20)" fill="#fff"/>
                        </mask>
                        <g mask="url(#mask0_228_10874)">
                          <path d="M8 5L13 10L8 15L6.9375 13.9375L10.875 10L6.9375 6.0625L8 5Z" fill="#fff"/>
                        </g>
                      </svg>
                    </v-icon>
                  </v-btn>
                </div>
                <div class="title">
                  {{ currentDate }}
                  Week {{ calculateWeekNumber(selectedDate.toISOString()) }}
                </div>
              </div>
              <div class="mode-picker">
<!--                <div class="search-wr box-sh">-->
<!--                  <a href="javascript:void(0)" class="search-btn" @click="setInputToFocus()">-->
<!--                    <v-icon>-->
<!--                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">-->
<!--                        <path fill-rule="evenodd" clip-rule="evenodd"-->
<!--                              d="M7.33398 2.66634C4.75666 2.66634 2.66732 4.75568 2.66732 7.33301C2.66732 9.91034 4.75666 11.9997 7.33398 11.9997C9.91131 11.9997 12.0007 9.91034 12.0007 7.33301C12.0007 4.75568 9.91131 2.66634 7.33398 2.66634ZM1.33398 7.33301C1.33398 4.0193 4.02028 1.33301 7.33398 1.33301C10.6477 1.33301 13.334 4.0193 13.334 7.33301C13.334 10.6467 10.6477 13.333 7.33398 13.333C4.02028 13.333 1.33398 10.6467 1.33398 7.33301Z"-->
<!--                              fill="#8C8B91"/>-->
<!--                        <path fill-rule="evenodd" clip-rule="evenodd"-->
<!--                              d="M10.6289 10.6289C10.8892 10.3685 11.3113 10.3685 11.5717 10.6289L14.4717 13.5289C14.732 13.7892 14.732 14.2113 14.4717 14.4717C14.2113 14.732 13.7892 14.732 13.5289 14.4717L10.6289 11.5717C10.3685 11.3113 10.3685 10.8892 10.6289 10.6289Z"-->
<!--                              fill="#8C8B91"/>-->
<!--                      </svg>-->
<!--                    </v-icon>-->
<!--                  </a>-->
                  <!--                  <input type="text" ref="search" class="input-search" placeholder="Type to Search..." />-->
<!--                </div>-->
                <v-select variant="outlined" class="bg-secondary-pr box-sh  rounded-pill" v-model="selectedView"
                          :items="['Måned', 'Uge', 'Dag','liste']" density="compact"/>
              </div>
            </div>
          </v-sheet>
        </v-col>
<!--      </v-row>-->
<!--      &lt;!&ndash;    </v-row>&ndash;&gt;-->
<!--      <v-row class="mb-6" >-->
        <!--      <v-row>-->
        <!--        <v-col :key="isSideDateVisible" class="d-p-w" cols="12" md="4" :lg="isSideDateVisible ? 3 : 1">-->
        <!--          <v-date-picker mode-icon="none" ref="datePicker" class="date-picker" max-width="1000px" hide-actions="false" color="#F24139" v-if="isSideDateVisible" elevation="0" v-model="selectedDate" />-->
        <!--        </v-col>-->
        <!--        <v-col :key="isSideDateVisible" class="fc-wr" cols="12" md="8" :lg="isSideDateVisible ? 9 : ''">-->
        <v-col  cols="12">
          <!--          <div class="filterChirp">-->
          <!--            <span class="filters">Filters:</span>-->
          <!--&lt;!&ndash;            <Filterchip title="Platform" :items="['test']" />&ndash;&gt;-->
          <!--&lt;!&ndash;            <Filterchip title="Status" :items="['test']" />&ndash;&gt;-->
          <!--          </div>-->
<!--          {{eventData}}-->
          <fullcalendar :key="isSideDateVisible"  :events="loadEvents" :dayHeaderContent="customDayHeaderContent"
                        :options="calendarOptions"
                        ref="fullCalendar"/>
        </v-col>
        <!--      </v-row>-->

      </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
// import Filterchip from "../../components/filterchip.vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import fullcalendar from "@fullcalendar/vue3";
import moment from 'moment'
import listPlugin from '@fullcalendar/list';

// import {router} from "@inertiajs/vue3";
// import {getCurrentInstance} from "vue";
import axios from "axios";
export default {
  components: {
    fullcalendar,
    // Filterchip
  },
  props:{
    events:Object
  },
  data() {
    return {
      testy: '',
      eventData:[],
      moment: moment,
      checkedDated: [],
      status: true,
      search: false,
      selectedDate: new Date,//moment(new Date).format('YYYY-MM-DD'),
      isSideDateVisible: true,
      selectedView: 'Måned',
      currentDate: '',
      calendarOptions: {
        plugins: [
          dayGridPlugin,
          timeGridPlugin,
          interactionPlugin,
          listPlugin
        ],
        headerToolbar: {
          left: '',
          center: '',
          right: ''
        },
        // events: this.eventData,
        events: () => {
          return new Promise((resolve, reject) => {
            axios.get('/get-events')
              .then(response => {
                resolve(response.data.events);
              })
              .catch(error => {
                console.error('Error fetching events:', error);
                reject(error);
              });
          });
        },
        // dayNames:['Sunyy', 'Mony', 'Tuey', 'Wedy', 'Thu', 'Fri', 'Sat'],
        dayHeaderContent: this.customDayHeaderContent,
        weekNumberCalculation: 'local',
        initialView: 'dayGridMonth',
        editable: true,
        // weekNumbers:true,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        dateClick: this.handleDateSelect
        // select: this.handleDateSelect,

      },
    }
  },
  watch: {
    events(){
      // this.eventData = this.events
      console.log(this.$refs.fullCalendar.getApi())
      this.updateCalendar()
      const calendarApi = this.$refs.fullCalendar.getApi();
      calendarApi.refetchEvents();
    },
    selectedView(newView) {
      const calendarApi = this.$refs.fullCalendar.getApi();
      calendarApi.changeView(newView === 'Måned' ? 'dayGridMonth'
        : newView === 'Uge' ? 'timeGridWeek'
          : newView === 'Dag' ? 'timeGridDay' : newView === 'liste' ?  'listWeek' : 'dayGridMonth');
      this.currentDayName();
    },

  },
  computed: {
    searchBtn() {
      return this.setInputToFocus()
    },
    goToSelectedDateC: function () {
      return moment(this.selectedDate).format('YYYY-MM-DD')
    },
  },
  mounted() {
    this.updateCalendar()
    this.currentDayName();
  },
  methods: {
    loadEvents() {
      return new Promise((resolve, reject) => {
        axios.get('/get-events')
          .then(response => {
            resolve(response.data.events);
          })
          .catch(error => {
            console.error('Error fetching events:', error);
            reject(error);
          });
      });
    },
    updateCalendar() {
      axios.get('/get-events')
        .then(response => {
          // const data = response.data;
          this.eventData = response.data.events
            // Map received data if necessary
          // const dataToRender = data.events.map(x => {
          //   // Modify data as needed
          //   return x;
          // });
          // console.log(data);

          // Refetch events on the calendar
          // let calendarApi = this.$refs.calendar.getApi(); // Get calendarApi object
          // calendarApi.refetchEvents(); // Update events on the calendar
        })
        .catch(error => {
          console.error('Error fetching events:', error);
        });
  },
    calculateWeekNumber(date) {
      const getWeek = function (d) {
        d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
        const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
        const weekNumber = Math.ceil(((d - yearStart) / 86400000 + 1) / 7);
        return weekNumber;
      };
      const weekNumber = getWeek(new Date(date));

      return weekNumber;
    },

    customDayHeaderContent(arg) {
      const customDayNames = ['Søndag', 'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag'];
      return customDayNames[arg.date.getUTCDay()];
    },
    handleDateSelect(info) {

      // // Datumobject maken
      var date = new Date(info.date);
      this.selectedDate = date
      this.$emit('selectedDate',date)
    },
    setInputToFocus() {
      this.status = !this.status;
      this.$refs.search.focus() //:  this.$refs.search.blur()
    },
    goToSelectedDate() {
      this.$refs.fullCalendar.getApi().gotoDate(this.goToSelectedDateC)
      this.currentDayName();
    },
    toggleSideDate() {
      // this.calendarOptions;
      this.isSideDateVisible = !this.isSideDateVisible;
    },
    currentDayName() {
      // console.log(this.$ref.datePicker.getApi())

      const test = this.$refs.fullCalendar.getApi();
      this.currentDate = test.currentData.viewTitle
      return this.currentDate
    },
    navigate(action) {
      const calendarApi = this.$refs.fullCalendar.getApi();
      switch (action) {
        case 'next':
          calendarApi.next();
          this.currentDayName()
          console.log(calendarApi)
          break;
        case 'prev':
          calendarApi.prev();
          this.currentDayName()
          break;
        case 'today':
          calendarApi.today();
          this.currentDayName()
          this.selectedDate = moment(new Date).format('YYYY-MM-DD')
          break;
      }
    }

  }
}
</script>
<style scoped>
@import "../../scss/fullcalendar.scss";
</style>
