import { ref } from 'vue'

export const headerInventory = ref([
    { title: 'Image', align: 'center', key: 'img_path' },
    // { title: 'path', align: 'center', key: 'img_path'},
    { title: 'Asset Tag', align: 'start', key: 'asset_tag', sortable: true },
    { title: 'Item Name', align: 'start', key: 'item_name', sortable: true },
    { title: 'Category', align: 'start', key: 'categoryName', sortable: true },
    { title: 'Description', align: 'start', key: 'description', sortable: true },
    { title: 'Model', align: 'start', key: 'item_model', sortable: true },
    { title: 'Condition', align: 'start', key: 'item_condition', sortable: true },
    { title: 'Status', align: 'start', key: 'status', sortable: true },
    { title: 'Actions', align: 'start', key: 'actions' }
]);

export const headerCategory = ref([
    { title: 'Category', align: 'center', key: 'description', sortable: true },
    { title: 'Status', align: 'center', key: 'status', sortable: true },
    { title: 'Actions', align: 'start', key: 'actions' }
]);

export const headerDepartment = ref([
    { title: 'Department', align: 'center', key: 'description', sortable: true },
    { title: 'Status', align: 'center', key: 'status', sortable: true },
    { title: 'Actions', align: 'start', key: 'actions' }
]);


export const headerApproval = ref([
    { title: 'Full Name', align: 'start', key: 'full_name' },
    { title: 'Type', align: 'start', key: 'type', sortable: true },
    { title: 'Department', align: 'start', key: 'department_name', sortable: true },
    { title: 'Phone Number', align: 'start', key: 'phone_number', sortable: true },
    { title: 'File', align: 'start', key: 'docs_file'},
    { title: 'Actions', align: 'start', key: 'actions' }
]);




