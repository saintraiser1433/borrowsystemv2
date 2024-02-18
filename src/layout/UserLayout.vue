<template>
    <Navbar />
    <div class="bg-grey-lighten-4 h-100">
        <v-main class="my-4 mx-4">
            <v-card class="mx-auto w-100 h-100" elevation="3" scrollable>
                <v-card-text>
                    <router-view></router-view>
                </v-card-text>
            </v-card>
        </v-main>
    </div>
</template>
  
<script setup>
import Navbar from '@/components/Navbar.vue';
import { clientSidebar } from '@/constants/sidebar'
import { onMounted } from 'vue';
import { createNamespacedHelpers } from 'vuex-composition-helpers';
const { useActions } = createNamespacedHelpers('sidebar'); // specific module name

const { setSidebar } = useActions(['setSidebar'])

onMounted(() => {
    setSidebar(clientSidebar);
})

</script>
  