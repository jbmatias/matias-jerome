<template>
  <v-container class="main" v-if="isDataLoaded">
    <div class="open-sign" v-if="isOpen && !isOnBreak">Store is Open</div>
    <div class="close-sign" v-else-if="isOpen && isOnBreak">Store is On Break</div>
    <div class="close-sign" v-else>
      Store is Close <br />
      <p>next opening date:</p>
      <p>{{ nextOpeningDate }}</p>
    </div>
    <div class="open-days">
      <v-date-picker
        width="40%"
        v-model="date"
        @update:month="onMonthChange"
        @update:year="onYearChange"
        :allowed-dates="dates"
      >
        <template v-slot:title></template>
        <template v-slot:header>
          <v-row align="center">
            <v-col>
              <span class="text-h4">Open Dates</span>
            </v-col>
          </v-row>
        </template>
      </v-date-picker>
    </div>
  </v-container>
</template>

<script>
import { defineComponent, watchEffect } from "vue";
import { reactive, ref, onMounted } from "vue";
import moment from "moment";
export default defineComponent({
  name: "StoreStatusWidget",
  props: {
    storeHours: {
      type: Object,
      required: true,
    },
    isDataLoaded: {
      type: Boolean,
      default: false,
    },
  },

  setup(props) {
    const isDataLoaded = ref(false);
    const date = ref(new Date());
    const dates = ref([]);
    const isOpen = ref(false);
    const isOnBreak = ref(false);
    const nextOpeningDate = ref("");
    const currentDayNum = moment().day();
    const storeHours = props.storeHours;

    const checkStoreOpeningHours = () => {
      let data = storeHours;
      Object.entries(data).forEach((day) => {
        if (day[1].day_num == currentDayNum && day[1].enabled == 1) {
          const startTime = moment(day[1].open, "hh:mm");
          const endTime = moment(day[1].close, "hh:mm");

          const currentTime = moment();
          isOpen.value = currentTime.isBetween(startTime, endTime);
        }
      });
    };

    const checkNextOpeningDate = () => {
      let data = storeHours;
      for (const [day, info] of Object.entries(data)) {
        if (info.day_num > currentDayNum && info.enabled == 1) {
          const weekNumber = moment().week();
          const currentDate = moment();
          const dateOfThatDay = currentDate
            .week(weekNumber)
            .startOf("week")
            .add(info.day_num, "days");
          nextOpeningDate.value = dateOfThatDay.format("MMMM DD, YYYY");
          break;
        }
      }
    };

    const checkStoreOnBreakHours = () => {
      let data = storeHours;
      Object.entries(data).forEach((day) => {
        if (day[1].day_num == currentDayNum) {
          const startTime = moment(day[1].break_time_start, "hh:mm");
          const endTime = moment(day[1].break_time_end, "hh:mm");

          const currentTime = moment();
          isOnBreak.value = currentTime.isBetween(startTime, endTime);
        }
      });
    };

    const onMonthChange = (monthNumber) => {
      let data = storeHours;
      let daysOfWeek = [];

      Object.entries(data).forEach((day) => {
        if (day[1].enabled)
          daysOfWeek.push({
            value: day[1].day_num,
            every_other_week: day[1].every_other_week,
          });
      });

      const startOfMonth = moment().month(monthNumber).startOf("month");
      const endOfMonth = moment().month(monthNumber).endOf("month");

      let containDates = [];
      let currentDay = startOfMonth.clone();
      while (currentDay <= endOfMonth) {
        const dayOfWeek = currentDay.day();
        const isEveryOtherWeak =
          (currentDay.clone().week() - currentDay.clone().startOf("month").week() + 1) % 2 != 0
            ? true
            : false;
        daysOfWeek.map((day) => {
          if (day.value == dayOfWeek && day.every_other_week && isEveryOtherWeak)
            containDates.push(currentDay.format("YYYY-MM-DD"));
          else if (day.value == dayOfWeek && !day.every_other_week)
            containDates.push(currentDay.format("YYYY-MM-DD"));
        });

        // Move to the next day
        currentDay.add(1, "day");
      }
      dates.value = containDates;
    };

    const onYearChange = (year) => {
      console.log(year)
    }

    const allowedDates = (date) => {
      return dates.includes(date);
    };

    watchEffect(() => {
      checkStoreOpeningHours();
      checkStoreOnBreakHours();
      if (props.isDataLoaded) isDataLoaded.value = true;
    });

    onMounted(() => {
      setInterval(() => {
        checkStoreOpeningHours();
        checkStoreOnBreakHours();
        checkNextOpeningDate();
      }, 1000);
    });

    return {
      isOpen,
      nextOpeningDate,
      isOnBreak,
      date,
      onMonthChange,
      dates,
      allowedDates,
      isDataLoaded,
    };
  },
});
</script>

<style scoped>
.main {
  display: block;
  justify-content: center;
  align-items: center;
  direction: column;
  width: 100%;
  margin: 0;
  font-family: Arial, sans-serif;
}

.open-sign {
  font-size: 6em;
  color: #ffffff;
  background-color: #4caf50;
  padding: 120px 40px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  text-align: center;
  min-width: 80%;
}

.close-sign {
  font-size: 6em;
  color: #ffffff;
  background-color: #af4c4c;
  padding: 120px 40px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  text-align: center;
  min-width: 80%;
}

.open-days {
  display: flex;
  justify-content: center;
  align-items: center;
  direction: column;
  padding: 50px;
}

.v-picker-title {
  display: none !important;
}
</style>
