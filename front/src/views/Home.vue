<template>
  <main>
    <StoreStatusWidget :storeHours="storeHours" :isDataLoaded="isDataLoaded" v-if="storeHours" />
  </main>
</template>

<script>
import { defineComponent } from 'vue'
import StoreStatusWidget from '../components/StoreStatusWidget.vue'
import { reactive, ref, onMounted } from "vue";
import StoreService from "@/services/Store.service";

export default defineComponent({
  name: 'Home',
  components: {
    StoreStatusWidget
  },
  setup() {

    const storeHours = reactive({});
    const storeService = new StoreService();
    const isDataLoaded = ref(false)

    // Method to fetch store hours
    const getStoreHours = async () => {      
      try {
        const response = await storeService.getStoreHours();                            
        response.data.forEach((day) => {    
          storeHours[day.value] = {
            open: day.store_hours.open,
            close: day.store_hours.close,
            enabled: day.enabled,
            day_num: day.day_num,
            break_time_start: day.store_hours.break_time_start,
            break_time_end: day.store_hours.break_time_end,
            every_other_week: day.store_hours.every_other_week  ? true : false,
          };
          console.log(storeHours)   
        });
      } catch (error) {
        console.error("Error fetching store hours: ", error);
      } finally {
        isDataLoaded.value = true
      }
    };
    
    onMounted(() => {
      getStoreHours();
      setInterval(() => {
        getStoreHours();
      }, 1000)
    });

    return {
      storeHours,
      isDataLoaded
    };
  }

})
</script>
