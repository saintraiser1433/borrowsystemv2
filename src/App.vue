<template >
  <v-app class="bg-grey-lighten-3">
    <router-view />
  </v-app>
</template>
<script setup>
</script>
<style>
body {
  font-family: "Poppins", sans-serif;
}
</style>

<script setup>
 import { createNamespacedHelpers } from 'vuex-composition-helpers';
 import { onMounted } from 'vue'


 const { useActions } = createNamespacedHelpers('auth');
 const { init } = useActions(['init'])

 onMounted(()=> {
    init()
 })


</script>