<template>
  <div>
    {{calendarApp}}
    <ScheduleXCalendar v-if="calendarApp" :calendar-app="calendarApp" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { ScheduleXCalendar } from '@schedule-x/vue';
import { createDragAndDropPlugin } from '@schedule-x/drag-and-drop';
import { createCalendar, viewDay, viewWeek, viewMonthGrid, viewMonthAgenda } from '@schedule-x/calendar';
import '@schedule-x/theme-default/dist/index.css';
import { createEventModalPlugin } from "@schedule-x/event-modal";
import axios from "axios";

const eventData = ref([]);
const calendarApp = ref(null);

const initializeCalendar = (events) => {
  calendarApp.value = createCalendar({
    selectedDate: [new Date()],
    onEventClick: test,
    views: [viewDay, viewWeek, viewMonthGrid, viewMonthAgenda],
    plugins: [createEventModalPlugin(), createDragAndDropPlugin()],
    defaultView: viewWeek.name,
    events,
    config: {
      locale: 'zh-CN',
      firstDayOfWeek: 0,
      defaultView: viewMonthGrid.name,
      isDark: true,
      dayBoundaries: {
        start: '06:00',
        end: '18:00',
      },
      callbacks: {
        onRangeUpdate(range) {
          console.log('new calendar range start date', range.start);
          console.log('new calendar range end date', range.end);
        },
        onEventUpdate(updatedEvent) {
          console.log('onEventUpdate', updatedEvent);
        },
        onEventClick: test,
        onClickDate: test,
        onClickDateTime(dateTime) {
          console.log('onClickDateTime', dateTime);
        }
      },
    },
  });
};

const updateCalendar = () => {
  axios.get('/get-events')
    .then(response => {
      const formattedEvents = response.data.events.map(event => ({
        id: event.id,
        title: event.title,
        description: event.description ? event.description : 'No data',
        people: [event.title],
        start: event.start_time ? `${event.start_date} ${event.start_time}` : event.start_date,
        end: event.end_date ? event.end_date : event.start_date
      }));

      eventData.value = formattedEvents;

      if (!calendarApp.value) {
        initializeCalendar(formattedEvents);
      } else {
        calendarApp.value.events = formattedEvents;
      }
    })
    .catch(error => {
      console.error('Error fetching events:', error);
    });
};

const test = (info) => {
  console.log(info);
};

onMounted(() => {
  updateCalendar();
});
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
