<template>
    <v-navigation-drawer color="blue-grey-darken-3" :width="300">
        <v-list-item prepend-avatar="/images/seait.png">
            <v-list-item-title class="text-grey-lighten-3">
                <span class="text-teal-darken-1 font-weight-bold fontSmall">SEA</span>
                <span class="fontSmall text-yellow-accent-2">IT</span>
                <span class="fontSmall">-ABS V1.0</span>
            </v-list-item-title>
            <v-list-item-subtitle class="text-grey-lighten-5 fontSmallSubtitle">
                Advance Borrowing System V1.0
            </v-list-item-subtitle>
        </v-list-item>
        <!-- <v-list-item>
            <v-list-item-title class="text-grey-lighten-3">
                <span class="text-teal-darken-1 font-weight-bold fontSmall">SAMPLE</span>
                <span class="fontSmall text-yellow-accent-2">SAMPLE</span>
                <span class="fontSmall">-SAMPLE </span>
            </v-list-item-title>
            <v-list-item-subtitle class="text-grey-lighten-5 fontSmallSubtitle">
                SAMPLE SYSTEM
            </v-list-item-subtitle>
        </v-list-item> -->
        <v-divider></v-divider>
        <v-list>
            <div v-for="(data, index) in item" :key="index">
                <v-list-group v-if="data.items" class="compact font-weight-bold" :value="data.title">
                    <template v-slot:activator="{ props }">
                        <v-list-item v-bind="props" :title="data.title">
                            <template #prepend>
                                <v-icon color="text-grey">{{ data.icon }}</v-icon>
                            </template>
                        </v-list-item>
                    </template>
                    <v-list-item v-for="sub in data.items" :key="sub.title" :title="sub.title" :value="sub.title"
                        :to="sub.path" link>
                    </v-list-item>
                </v-list-group>
                <v-list-item v-else class="compact font-weight-bold" link :key="data.title" :to="data.path">
                    <template #prepend>
                        <v-icon color="text-grey">{{ data.icon }}</v-icon>
                    </template>
                    <v-list-item-title>{{ data.title }}</v-list-item-title>
                </v-list-item>
            </div>
        </v-list>
    </v-navigation-drawer>
</template>

<script setup>
import { item } from '@/constants/sidebar'



</script>

<style scoped>
.fontSmall {
    font-size: 14px;
}

.fontSmallSubtitle {
    font-size: 12px;
}

/* :deep(.v-list-group__items){
    height: unset !important;
} */
</style>