<template>
  <v-app>
    <v-container>
      <!-- <store-status-widget /> -->
      <router-view />
    </v-container>
  </v-app>
</template>
<script>
import StoreStatusWidget from './components/StoreStatusWidget.vue';

export default {
  components: {
    StoreStatusWidget
  }
};
</script>
