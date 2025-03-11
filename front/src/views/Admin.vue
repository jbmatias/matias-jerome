<template>
  <v-card class="mx-auto" max-width="1000">
    <v-card-title class="headline text-center">Configure Bakery Hours</v-card-title>

    <v-card-text>
      <v-form ref="form" v-model="isValid">
        <v-row>
          <!-- Days of the Week -->
          <v-col v-for="(day, index) in daysOfWeek" :key="index" cols="12" md="6">
            <v-checkbox
              v-model="selectedDays"
              :label="day.name"
              :value="day.value"
              color="primary"
            ></v-checkbox>
            <!-- Store Open and Close Time -->
            <v-col cols="12" md="12">
              <v-switch
                v-model="storeHours[day.value].every_other_week"
                :label="`Every other week`"
                color="primary"
              ></v-switch>
              <v-text-field
                label="Opening Time"
                v-model="storeHours[day.value].open"
                type="time"
                required
              ></v-text-field>

              <v-text-field
                label="Closing Time"
                v-model="storeHours[day.value].close"
                type="time"
                required
              ></v-text-field>

              <!-- Break Time -->
              <v-text-field
                label="Break Start Time"
                v-model="storeHours[day.value].break_time_start"
                type="time"
                required
              ></v-text-field>
              <v-text-field
                label="Break End Time"
                v-model="storeHours[day.value].break_time_end"
                type="time"
                required
              ></v-text-field>
            </v-col>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>

    <v-divider></v-divider>

    <v-card-actions>
      <v-btn color="primary" @click="saveHours" :disabled="!isValid"> Save Hours </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { defineComponent } from "vue";
import { reactive, ref, onMounted } from "vue";
import StoreService from "@/services/Store.service";

export default defineComponent({
  name: "Admin",
  setup() {
    const selectedDays = ref([]);
    const storeHours = reactive({});
    const isValid = ref(false);
    const daysOfWeek = reactive([]);
    const storeService = new StoreService();

    // Method to save hours
    const saveHours = () => {
      const data = {};
      Object.entries(storeHours).map((value) => {
        if (selectedDays.value.includes(value[0]))
          data[value[0]] = {
            open: value[1].open,
            close: value[1].close,
            enabled: true,
            break_time_start: value[1].break_time_start,
            break_time_end: value[1].break_time_end,
            every_other_week: value[1].every_other_week ? true : false,
          };
        else
          data[value[0]] = {
            open: value[1].open,
            close: value[1].close,
            enabled: false,
            break_time_start: value[1].break_time_start,
            break_time_end: value[1].break_time_end,
            every_other_week: value[1].every_other_week ? true : false,
          };
      });
      console.log(data);
      storeService.updateStoreHours({ storeHours: data });
    };

    const setDefaultSelectedDays = (days) => {
      selectedDays.value = days;
    };

    // Method to fetch store hours
    const getStoreHours = async () => {
      try {
        const response = await storeService.getStoreHours();

        const days = [];

        response.data.forEach((day) => {
          if (day.enabled) {
            days.push(day.value);
          }

          daysOfWeek.push({ name: day.name, value: day.value });

          storeHours[day.value] = {
            open: day.store_hours.open,
            close: day.store_hours.close,
            enabled: day.enabled,
            break_time_start: day.store_hours.break_time_start,
            break_time_end: day.store_hours.break_time_end,
            every_other_week: day.store_hours.every_other_week ? true : false,
          };

          setDefaultSelectedDays(days);
          console.log(storeHours);
        });
      } catch (error) {
        console.error("Error fetching store hours: ", error);
      }
    };

    onMounted(() => {
      getStoreHours();
    });

    return {
      selectedDays,
      storeHours,
      isValid,
      daysOfWeek,
      saveHours,
    };
  },
});
</script>

<style scoped>
.v-card {
  margin-top: 50px;
}

.v-btn {
  margin-top: 10px;
}
</style>
