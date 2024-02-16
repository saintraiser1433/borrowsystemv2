<template>
    <v-card flat>
        <v-row justify="space-between" align="center">
            <v-col cols="auto">
                <TitleBar />
            </v-col>
        </v-row>
        <Suspense>
            <template #default>
                <CourseTable :items="items" :headers="headers">
                    <template v-slot:[`item.docs_file`]="{ item }">
                        <a :href="`http://localhost/borrowing-api/uploads/${item.docs_file}`">Download</a>
                    </template>
                    <template v-slot:[`item.actions`]="{ item }">
                        <v-btn flat color="green-darken-1" @click="approve(item.borrower_id)">Approved</v-btn> |
                        <v-btn flat color="red-accent-3" @click="reject(item.borrower_id)">Reject</v-btn>
                    </template>
                </CourseTable>
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
import Swal from 'sweetalert2'

//init
const headers = ref(headerApproval)
const items = ref([]);
const CourseTable = defineAsyncComponent({
    loader: () => import('@/components/Table.vue')
})

const { useToaster } = Toaster();


//methods
const fetchForApproval = async () => {
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


const approve = (borrowerId) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to approved this data?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Approved"
    }).then(async (result) => {
        if (result.isConfirmed) {
            const response = await useAxios({
                method: 'PUT',
                api: '/borrower?action=PUT',
                params: {
                    borrowerId: borrowerId
                }
            });
            if (response.ok) {
                useToaster(response.data.message, 'success');
                fetchForApproval();
            } else {
                useToaster(response.error, 'error');
            }
        }
    });
}




const reject = (borrowerId) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to reject this data?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Reject"
    }).then(async (result) => {
        if (result.isConfirmed) {
            const response = await useAxios({
                method: 'DELETE',
                api: '/borrower?action=DELETE',
                params: {
                    borrowerId: borrowerId
                }
            });
            if (response.ok) {
                useToaster(response.data.message, 'success');
                fetchForApproval();
            } else {
                useToaster(response.error, 'error');
            }
        }
    });
}

//end
//lifecycle hook
onMounted(() => {
    fetchForApproval();
})

//end
</script>
 