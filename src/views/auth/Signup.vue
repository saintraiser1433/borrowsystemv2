<template>
    <v-card class="mx-auto pa-12 pb-8 w-75 my-auto mx-auto" elevation="8" rounded="lg">
        <v-form @submit.prevent="onSignup">
            <v-row>
                <v-col cols="12" sm="12" md="4">
                    <div class="d-flex flex-column justify-center mb-6">
                        <div class="text-h5 font-weight-bold text-center text-dark">UPLOAD ID</div>
                        <v-divider class="mb-2"></v-divider>
                        <div class="text-center text-pink-accent-4">
                            {{ errors.docsFile }}

                        </div>
                        <v-img :width="300" :aspect-ratio="1" cover class="img-border mx-auto mb-2"
                            :src="filePreview ? filePreview : 'images/no-image.jpg'"></v-img>
                        <v-file-input class="d-none" ref="uploader" accept="image/png, image/jpeg, image/bmp"
                            @change="uploadFile">
                        </v-file-input>
                        <div class="text-center">
                            <v-btn prepend-icon="mdi-check-circle" flat class="bg-primary" @click="clickFile">
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
                        <v-col cols="12" sm="12" md="4">
                            <div class="text-subtitle-1 text-medium-emphasis">Borrower ID:</div>
                            <v-text-field density="compact" variant="outlined" v-model="borrowerId" v-bind="borrowerIdAttrs"
                                :error-messages="errors.borrowerId">
                            </v-text-field>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <div class="text-subtitle-1 text-medium-emphasis">First Name:</div>
                            <v-text-field density="compact" variant="outlined" v-model="firstName" v-bind="firstNameAttrs"
                                :error-messages="errors.firstName">
                            </v-text-field>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <div class="text-subtitle-1 text-medium-emphasis">Last Name:</div>
                            <v-text-field density="compact" variant="outlined" v-model="lastName" v-bind="lastNameAttrs"
                                :error-messages="errors.lastName">
                            </v-text-field>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <div class="text-subtitle-1 text-medium-emphasis">Middle Name:</div>
                            <v-text-field density="compact" variant="outlined" v-model="middleName" v-bind="middleNameAttrs"
                                :error-messages="errors.middleName">
                            </v-text-field>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <div class="text-subtitle-1 text-medium-emphasis">Course:</div>
                            <v-select :items="courseItem" density="compact" variant="outlined" item-title="description"
                                item-value="courseId" v-model="courseId" v-bind="courseIdAttrs"
                                :error-messages="errors.courseId">
                            </v-select>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <div class="text-subtitle-1 text-medium-emphasis">Department:</div>
                            <v-select :items="departmentItem" density="compact" variant="outlined" item-title="description"
                                item-value="departmentId" v-model="departmentId" v-bind="departmentIdAttrs"
                                :error-messages="errors.departmentId">
                            </v-select>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <div class="text-subtitle-1 text-medium-emphasis">Year Level:</div>
                            <v-select :items="itemYear" density="compact" variant="outlined" v-model="yearLevel"
                                v-bind="yearLevelAttrs" :error-messages="errors.yearLevel">
                            </v-select>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <div class="text-subtitle-1 text-medium-emphasis">Phone Number:</div>
                            <v-text-field density="compact" variant="outlined" v-model="phoneNumber"
                                v-bind="phoneNumberAttrs" :error-messages="errors.phoneNumber">
                            </v-text-field>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <div class="text-subtitle-1 text-medium-emphasis">Registered As:</div>
                            <v-select :items="itemType" density="compact" variant="outlined" item-title="description"
                                item-value="id" v-model="type" v-bind="typeAttrs" :error-messages="errors.type">
                            </v-select>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <div class="text-subtitle-1 text-medium-emphasis">Username:</div>
                            <v-text-field density="compact" variant="outlined" v-model="username" v-bind="usernameAttrs"
                                :error-messages="errors.username">
                            </v-text-field>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <div class="text-subtitle-1 text-medium-emphasis">Password:</div>
                            <v-text-field density="compact" variant="outlined" v-model="password" v-bind="passwordAttrs"
                                :error-messages="errors.password">
                            </v-text-field>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <div class="text-subtitle-1 text-medium-emphasis">Confirm Password:</div>
                            <v-text-field density="compact" variant="outlined" v-model="confirmPassword"
                                v-bind="confirmPasswordAttrs" :error-messages="errors.confirmPassword">
                            </v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>

            <v-btn block type="submit" class="mb-8" color="blue" size="large" variant="tonal">
                Sign Up
            </v-btn>
            <v-card-text class="text-center">
                <a class="text-blue text-decoration-none cursor-pointer" @click="backToLogin" rel="noopener noreferrer">
                    back to login page <v-icon icon="mdi-chevron-right"></v-icon>
                </a>
            </v-card-text>
        </v-form>
    </v-card>
</template>

<script setup>
import { useForm } from 'vee-validate'
import * as yup from 'yup'
import { useRouter } from 'vue-router'
import { ref, onMounted } from 'vue'
import { v4 as uuidv4 } from 'uuid'
import { useAxios } from '@/composable/useAxios'
import { Toaster } from '@/composable/useToast'
import { itemYear, itemType } from '@/constants/selection'
const uploader = ref(null)
const filePreview = ref(null)
const courseItem = ref([])
const departmentItem = ref([])
const router = useRouter()
const fileData = ref(null)
const yupSchema = yup.object().shape({
    borrowerId: yup.string().required('Borrower ID is required'),
    firstName: yup.string().required('First Name is required'),
    middleName: yup.string().required('Middle Name is required'),
    lastName: yup.string().required('Last Name is required'),
    phoneNumber: yup.number().required('Phone Number is required'),
    yearLevel: yup.string().required('Year Level is required'),
    courseId: yup.number().required('Course is required'),
    departmentId: yup.number().required('Department is required'),
    type: yup.string().required('Resident Type is required'),
    docsFile: yup.string().required('Needed to upload ID for verification'),
    username: yup.string().required('Username is required'),
    password: yup.string().required('Password is required'),
    confirmPassword: yup.string().required().oneOf([yup.ref('password')], 'Passwords do not match'),
});

const { handleSubmit, defineField, setValues, errors } = useForm({
    validationSchema: yupSchema
});

const [borrowerId, borrowerIdAttrs] = defineField('borrowerId');
const [firstName, firstNameAttrs] = defineField('firstName');
const [middleName, middleNameAttrs] = defineField('middleName');
const [lastName, lastNameAttrs] = defineField('lastName');
const [phoneNumber, phoneNumberAttrs] = defineField('phoneNumber');
const [yearLevel, yearLevelAttrs] = defineField('yearLevel');
const [courseId, courseIdAttrs] = defineField('courseId');
const [departmentId, departmentIdAttrs] = defineField('departmentId');
const [type, typeAttrs] = defineField('type');
const [username, usernameAttrs] = defineField('username');
const [password, passwordAttrs] = defineField('password');
const [confirmPassword, confirmPasswordAttrs] = defineField('confirmPassword');
const { useToaster } = Toaster();
//methods
const clickFile = () => {
    uploader.value.click();
}

const backToLogin = () => {
    router.push('/');
}

const uploadFile = async (e) => {
    fileData.value = e.target.files[0]

    const readData = (f) =>
        new Promise((resolve) => {
            const reader = new FileReader();
            reader.onloadend = () => resolve(reader.result);
            reader.readAsDataURL(f);
            setValues({
                docsFile: uuidv4()
            })
        });

    filePreview.value = await readData(fileData.value);

}

const fetchCourseItem = async () => {
    const response = await useAxios({
        method: 'GET',
        api: '/course?action=GET'
    });
    courseItem.value = response.data
}

const fetchDepartmentItem = async () => {
    const response = await useAxios({
        method: 'GET',
        api: '/department?action=GET'
    });
    departmentItem.value = response.data
}

const onSignup = handleSubmit(async (values) => {
    const formData = new FormData();
    formData.append('data', JSON.stringify(values));
    formData.append('files', fileData.value);
    const response = await useAxios({
        method: 'POST',
        api: '/signup.php?action=POST',
        data: formData,
        header: {
            'Content-Type': 'multipart/form-data'
        },
    });
    if (response.ok) {
        // router.push('/');
        useToaster(response.data.message, 'success');
    } else {
        useToaster(response.error, 'error');
    }
});

//end

//lifecycle
onMounted(() => {
    fetchCourseItem()
    fetchDepartmentItem()
})


</script>

<style scoped></style>