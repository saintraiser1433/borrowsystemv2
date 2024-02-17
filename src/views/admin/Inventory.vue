<template>
    <v-card flat>
        <v-row justify="space-between" align="center">
            <v-col cols="auto">
                <TitleBar />
            </v-col>
            <v-col cols="auto">
                <Popup :title="ModalTitle" btnName="Add Assets" @toggleModal="openModal" v-model="isActive">
                    <template #body>
                        <v-form @submit.prevent="onSubmit">
                            <v-row>
                                <v-col cols="12" sm="12" md="4">
                                    <div class="d-flex flex-column justify-center mb-6">
                                        <div class="text-h5 font-weight-bold text-center text-dark">IMAGE PHOTO</div>
                                        <v-divider class="mb-2"></v-divider>
                                        <v-img :width="300" :aspect-ratio="1" cover class="img-border mx-auto mb-2"
                                            :src="filePreview"></v-img>
                                        <v-file-input class="d-none" ref="uploader"
                                            accept="image/png, image/jpeg, image/bmp" @change="uploadFile">
                                        </v-file-input>
                                        <div class="text-center">
                                            <v-btn prepend-icon="mdi-check-circle" flat class="bg-primary"
                                                @click="clickFile">
                                                <template v-slot:prepend>
                                                    <v-icon>mdi-account-circle</v-icon>
                                                </template>
                                                Upload Image
                                            </v-btn>
                                        </div>
                                    </div>

                                </v-col>
                                <v-col cols="12" sm="12" md="8">
                                    <v-row>
                                        <v-col cols="12" sm="12" md="6">
                                            <div class="text-subtitle-1 text-medium-emphasis">Item Tag #</div>
                                            <v-text-field density="compact" variant="outlined" v-model="assetTag"
                                                v-bind="assetTagAttrs" :error-messages="errors.assetTag">
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="6">
                                            <div class="text-subtitle-1 text-medium-emphasis">Item Name</div>
                                            <v-text-field density="compact" variant="outlined" v-model="itemName"
                                                v-bind="itemNameAttrs" :error-messages="errors.itemName">
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="6">
                                            <div class="text-subtitle-1 text-medium-emphasis">Category</div>
                                            <v-select :items="categoryItem" item-title="description" item-value="categoryId"
                                                density="compact" variant="outlined" v-bind="categoryIdAttrs"
                                                v-model="categoryId" :error-messages="errors.categoryId">
                                            </v-select>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="6">
                                            <div class="text-subtitle-1 text-medium-emphasis">Model</div>
                                            <v-text-field density="compact" variant="outlined" v-model="itemModel"
                                                v-bind="itemModelAttrs" :error-messages="errors.itemModel">
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="6">
                                            <div class="text-subtitle-1 text-medium-emphasis">Condition</div>
                                            <v-select :items="conditionItem" density="compact" variant="outlined"
                                                v-bind="itemConditionAttrs" v-model="itemCondition"
                                                :error-messages="errors.itemCondition">
                                            </v-select>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="6">
                                            <div class="text-subtitle-1 text-medium-emphasis">Status</div>
                                            <v-select :items="statusItem" density="compact" variant="outlined"
                                                item-title="description" item-value="id" v-model="statusActive"
                                                v-bind="statusActiveAttrs" :error-messages="errors.statusActive">
                                            </v-select>
                                        </v-col>
                                        <v-col cols="12" sm="12" md="12">
                                            <div class="text-subtitle-1 text-medium-emphasis">Description</div>
                                            <v-textarea density="compact" variant="outlined" v-model="description"
                                                v-bind="descriptionAttrs" :error-messages="errors.description"></v-textarea>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                            <v-divider></v-divider>
                            <v-card-actions class="justify-end">
                                <v-btn text @click="closeModal">Close</v-btn>
                                <v-btn type="submit" class="bg-primary">Submit</v-btn>
                            </v-card-actions>
                        </v-form>
                    </template>
                </Popup>
            </v-col>
        </v-row>
        <Suspense>
            <template #default>
                <InventoryTable :items="items" :headers="headers">
                    <template v-slot:[`item.status`]="{ item }">
                        <div v-if="item.status == 1">
                            <v-badge color="blue-darken-4" content="Active" inline></v-badge>
                        </div>
                        <div v-else>
                            <v-badge color="pink-accent-3" content="Inactive" inline></v-badge>
                        </div>
                    </template>
                    <template v-slot:[`item.img_path`]="{ item }">
                        <div v-if="item.img_path === null">
                            <v-img :width="36" :aspect-ratio="1" cover class="mx-auto" src="images/no-image.jpg"></v-img>
                        </div>
                        <div v-else>
                            <v-img :width="36" :aspect-ratio="1" cover class="mx-auto"
                                :src="`http://localhost:8383/borrowing-api/uploads/${item.img_path}`"></v-img>
                        </div>
                    </template>
                    <template v-slot:[`item.actions`]="{ item }">
                        <v-avatar class="me-1 bg-yellow-darken-4 cursor-pointer" size="small" @click="editItem(item)">
                            <v-icon>mdi-pencil</v-icon>
                        </v-avatar>
                        <v-avatar class="bg-red-darken-2 cursor-pointer" size="small" @click="deleteItem(item.asset_tag)">
                            <v-icon>mdi-delete</v-icon>
                        </v-avatar>
                    </template>
                </InventoryTable>
            </template>
            <template #fallback>
                <p>Loading</p>
            </template>
        </Suspense>
    </v-card>
</template>
    

<script setup>
//imports
import TitleBar from '@/components/TitleBar.vue'
import Popup from '@/components/Popup.vue'
import { condition, status } from '@/constants/selection'
import { headerInventory } from '@/constants/headers'
import { ref, defineAsyncComponent, onMounted, watch } from 'vue'
import { useForm } from 'vee-validate'
import { useFileUploader } from '@/composable/useFileUploader'
import { useModal } from '@/composable/useModal'
import { useAxios } from '@/composable/useAxios'
import { Toaster } from '@/composable/useToast'
import * as yup from 'yup'
import Swal from 'sweetalert2'
import { development } from '@/constants/server'
//init
const conditionItem = ref(condition)
const statusItem = ref(status)
const categoryItem = ref([]);
const headers = ref(headerInventory)
const uploader = ref(null);
const items = ref([]);


const InventoryTable = defineAsyncComponent({
    loader: () => import('@/components/Table.vue')
})
//composables
const { ModalTitle, isActive, openModal, closeModal, updateModal, isUpdate } = useModal('Assets')
const { filePreview, filePath, uploadFile, generateFileName } = useFileUploader(isActive)
const { useToaster } = Toaster();

//forms and validation
const yupSchema = yup.object().shape({
    assetTag: yup.number().required(),
    itemName: yup.string().required(),
    categoryId: yup.number().required(),
    itemModel: yup.string().required(),
    itemCondition: yup.string().required(),
    statusActive: yup.number().required(),
    description: yup.string().required(),
    img_path: yup.mixed().notRequired()
});

const { handleSubmit, setValues, errors, defineField, resetForm } = useForm({
    validationSchema: yupSchema
});

const [assetTag, assetTagAttrs] = defineField('assetTag');
const [itemName, itemNameAttrs] = defineField('itemName');
const [categoryId, categoryIdAttrs] = defineField('categoryId');
const [itemModel, itemModelAttrs] = defineField('itemModel');
const [itemCondition, itemConditionAttrs] = defineField('itemCondition');
const [statusActive, statusActiveAttrs] = defineField('statusActive');
const [description, descriptionAttrs] = defineField('description');

//end

//methods
const clickFile = () => {
    uploader.value.click();
}
const fetchInventory = async () => {
    const response = await useAxios({
        method: 'GET',
        api: '/inventory.php?action=GET'
    });
    if (response.ok) {
        items.value = response.data
    } else {
        useToaster(response.error, 'error');
    }
}

const getCategory = async () => {
    const response = await useAxios({
        method: 'GET',
        api: '/category.php?action=GET'
    });
    if (response.ok) {
        categoryItem.value = response.data
    } else {
        useToaster(response.error, 'error');
    }
}


const onSubmit = handleSubmit(async (values) => {
    if (isUpdate.value) {
        onUpdate(values);
    } else {
        onInsert(values);
    }
    closeModal();
});


const onUpdate = async (values) => {
    const formData = new FormData();
    formData.append('data', JSON.stringify(values));
    formData.append('files', filePath.value);
    const response = await useAxios({
        method: 'POST',
        api: '/inventory.php?action=PUT',
        data: formData,
        header: {
            'Content-Type': 'multipart/form-data'
        },
    });
    if (response.ok) {
        fetchInventory();
        useToaster(response.data.message, 'success');
    } else {
        useToaster(response.error, 'error');
    }
}

const onInsert = async (values) => {
    const formData = new FormData();
    formData.append('data', JSON.stringify(values));
    formData.append('files', filePath.value);
    const response = await useAxios({
        method: 'POST',
        api: '/inventory.php?action=POST',
        data: formData,
        header: {
            'Content-Type': 'multipart/form-data'
        },
    });
    if (response.ok) {
        fetchInventory();
        useToaster(response.data.message, 'success');
        closeModal();
    } else {
        useToaster(response.error, 'error');
    }
}


const deleteAsset = async (asset_tag) => {
    const response = await useAxios({
        method: 'DELETE',
        api: '/inventory.php?action=DELETE',
        params: {
            asset_tag: asset_tag
        }
    });
    if (response.ok) {
        fetchInventory();
        useToaster(response.data.message, 'success');
    } else {
        useToaster(response.error, 'error');
    }
}



const deleteItem = (asset_tag) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete this asset?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteAsset(asset_tag);
        }
    });
}

const editItem = (item) => {
    setValues({
        assetTag: item.asset_tag,
        itemName: item.item_name,
        categoryId: item.category_id,
        itemModel: item.item_model,
        itemCondition: item.item_condition,
        statusActive: item.status,
        description: item.description,
        img_path: item.img_path
    });
    if (item.img_path === null) {
        filePreview.value = 'images/no-image.jpg'
    } else {
        filePreview.value = `${development.baseUrl}/uploads/${item.img_path}`
    }
    updateModal();
}


watch([isActive, isUpdate, generateFileName], ([active, update, fileName]) => {
    if (active && !update) {
        resetForm({
            values: {
                asset_tag: '',
                item_name: '',
                category_id: '',
                item_model: '',
                item_condition: '',
                status: '',
                description: '',
                img_path: ''
            }
        });
    }
    if (fileName) {
        setValues({
            img_path: fileName
        })
    }
})

//end


//lifecycle hook
onMounted(() => {
    fetchInventory();
    getCategory();

})

//end

</script>

<style scoped>
.img-border {
    border: 3px solid #373737;
}
</style>