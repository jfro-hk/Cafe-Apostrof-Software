<template>
  <div>
    <!--    {{calendarApp.events.$app }}-->
<!--    {{eventData}}-->
    <ScheduleXCalendar :calendar-app="calendarApp"/>
  </div>
</template>

<script>
import {ScheduleXCalendar} from '@schedule-x/vue'
import {createEventModalPlugin} from "@schedule-x/event-modal";
import {
  createCalendar,
  viewDay,
  viewWeek,
  viewMonthGrid,
  viewMonthAgenda,
} from '@schedule-x/calendar'
import '@schedule-x/theme-default/dist/index.css'

export default {
  props: {
    eventsData: Object
  },

  components: {
    ScheduleXCalendar,
  },

  data() {

    const eventsArray = Object.values(this.eventsData).map(event => ({
      id: event.id,
      title: event.title,
      people: [event.title],
      description: event.description,
      start: event.start_date,
      end: event.end_date ? event.end_date : event.start_date
    }));

    return {
      eventData: [],
      calendarApp: createCalendar({
        selectedDate: [new Date()],
        onEventClick: this.test,
        plugins: [createEventModalPlugin()],
        views: [viewDay, viewWeek, viewMonthGrid, viewMonthAgenda],
        defaultView: viewWeek.name,
        events: [...eventsArray], // Assign the events array here
        config: {
          /**
           * Set the language. List of supported languages: https://schedule-x.dev/docs/calendar/supported-languages
           * For support of further languages, please open a PR, adding your translations under the folder:
           * packages/translations/src/locales/xx-XX
           *
           * Defaults to 'en-US'
           * */
          locale: 'zh-CN',

          /**
           * Set which day is to be considered the starting day of the week. 0 = Sunday, 1 = Monday, (...other days) 6 = Saturday
           * Defaults to 1 (Monday)
           * */
          firstDayOfWeek: 0,

          /**
           * The preferred view to display when the calendar is first rendered.
           * all views that you import have a "name" property, which helps you identify them.
           * Defaults to the first view in the "views" array
           * */
          defaultView: viewMonthGrid.name,

          /**
           * The default date to display when the calendar is first rendered. Only accepts YYYY-MM-DD format.
           * Defaults to the current date
           * */
          // selectedDate: '2023-12-24',

          /**
           * Render the calendar in dark mode.
           * Defaults to false
           * */
          isDark: true,

          /**
           * Decides which hours should be displayed in the week and day grids. Defaults to midnight - midnight (a full day)
           * Can also be set to a "hybrid" day, such as { start: '06:00', end: '03:00' }, meaning each day starts at 6am but
           * extends into the next day until 3am.
           * */
          dayBoundaries: {
            start: '06:00',
            end: '18:00',
          },

          /**
           * Callbacks for events that occur in the calendar
           * */
          callbacks: {
            /**
             * Is called when:
             * 1. Selecting a date in the date picker
             * 2. Selecting a new view
             * */
            onRangeUpdate(range) {
              console.log('new calendar range start date', range.start)
              console.log('new calendar range end date', range.end)
            },

            /**
             * Is called when an event is updated through drag and drop
             * */
            onEventUpdate(updatedEvent) {
              console.log('onEventUpdate', updatedEvent)
            },

            /**
             * Is called when an event is clicked
             * */
            onEventClick(calendarEvent) {
              console.log('onEventClick', calendarEvent)
            },

            /**
             * Is called when clicking a date in the month grid
             * */
            onClickDate(date) {
              console.log('onClickDate', date) // e.g. 2024-01-01
            },

            /**
             * Is called when clicking somewhere in the time grid of a week or day view
             * */
            onClickDateTime(dateTime) {
              console.log('onClickDateTime', dateTime) // e.g. 2024-01-01 12:37
            }
          },
        },
      }),
    };
  },
  methods: {
    test(info) {
      console.log(info)
    }
  },
  watch:{
    eventsData(){
      this.eventData = this.eventsData
      this.calendarApp.events.add({
        id: 3,
        title: 'New event',
        start: '2023-12-04',
        end: '2023-12-06',
      })
      // const calendarEl = document.getElementById('calendar') as HTMLElement
      // this.calendarApp.render(calendarEl)
    }
  },
  mounted() {
    this.eventData = this.eventsData
    this.calendarApp.events.add({
      id: 3,
      title: 'New event',
      start: '2023-12-04',
      end: '2023-12-06',
    })
  },

}
</script>

<style lang="css">
#calendar {
  width: 100%;
  height: 800px;
  max-height: 90vh;
}

.sx__month-agenda-day, .sx__month-grid-day:not(:last-child) {

  height: 136px;
}
</style>
