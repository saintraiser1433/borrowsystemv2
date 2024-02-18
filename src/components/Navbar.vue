<template>
    <Sidebar v-model="drawer" />
    <nav>
        <v-app-bar app flat density="compact" @click="drawer = !drawer">
            <template v-slot:prepend>
                <v-app-bar-nav-icon></v-app-bar-nav-icon>
            </template>

            <v-menu transition="scale-transition">
                <template v-slot:activator="{ props }">
                    <div class="text-center">
                        <v-btn color="dark" v-bind="props">
                            <template v-slot:prepend>
                                <v-avatar image="/images/man.png" size="small"></v-avatar>
                            </template>
                            Administrator
                            <template v-slot:append>
                                <v-icon color="dark font-weight-bold" size="large">mdi-chevron-down</v-icon>
                            </template>
                        </v-btn>
                    </div>
                </template>

                <v-list>

                    <v-list-item class="compact font-weight-bold" @click="logoutBtn">
                        <template #prepend>
                            <v-icon color="text-grey">mdi-arrow-right</v-icon>
                        </template>
                        <v-list-item-title class="ml-5">Logout</v-list-item-title>
                    </v-list-item>

                </v-list>
            </v-menu>
        </v-app-bar>
    </nav>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router'
import { createNamespacedHelpers } from 'vuex-composition-helpers';
import Sidebar from './Sidebar.vue';

const router = useRouter();
const drawer = ref(true);
const { useMutations } = createNamespacedHelpers('auth'); // specific module name
const { logout } = useMutations(['logout'])
const logoutBtn = () => {
    logout();
    router.push('../')
}

</script>

<style scoped></style>