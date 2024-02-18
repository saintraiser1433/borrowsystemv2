<template>
    <v-card flat>
        <v-row justify="space-between" align="center">
            <v-col cols="auto">
                <TitleBar />
            </v-col>
        </v-row>
        <Suspense>
            <template #default>
                <BorrowerTable :items="items" :headers="headers">
                    <template v-slot:[`item.docs_file`]="{ item }">
                        <a :href="`http://localhost/borrowing-api/uploads/${item.docs_file}`">Download</a>
                    </template>
                    <template v-slot:[`item.actions`]="{ item }">
                        <v-avatar class="me-1 bg-blue-accent-3 cursor-pointer" size="small" @click="editItem(item)">
                            <v-icon>mdi-eye-circle-outline</v-icon>
                        </v-avatar>
                        <v-avatar color="red-darken-1 cursor-pointer" size="small" @click="editItem(item)">
                            <v-icon>mdi-delete</v-icon>
                        </v-avatar>
                    </template>
                </BorrowerTable>
            </template>
            <template #fallback>
                <p>Loading</p>
            </template>
        </Suspense>
    </v-card>
</template>
    

<script setup>
import TitleBar from '@/components/TitleBar.vue'
import { headerApproval } from '@/constants/headers'
import { ref, defineAsyncComponent, onMounted } from 'vue'
import { useAxios } from '@/composable/useAxios'
import { Toaster } from '@/composable/useToast'
// import Swal from 'sweetalert2'

//init
const headers = ref(headerApproval)
const items = ref([]);
const BorrowerTable = defineAsyncComponent({
    loader: () => import('@/components/Table.vue')
})

const { useToaster } = Toaster();


//methods
const fetchForBorrow = async () => {
    const response = await useAxios({
        method: 'GET',
        api: '/borrower?action=APPROVED'
    });
    if (response.ok) {
        items.value = response.data

    } else {
        useToaster(response.error, 'error');
    }
}


//end
//lifecycle hook
onMounted(() => {
    fetchForBorrow();
})

//end
</script>
<style scoped></style>