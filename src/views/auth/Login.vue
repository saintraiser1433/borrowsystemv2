<template>
    <div class="my-auto">
        <div class="d-flex justify-content-center align-center mx-auto">
            <v-img class="mx-auto my-6" width="64px" height="64px" src="images/seait.png"></v-img>
        </div>
        <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
            {{ name }}
            {{ isAuthenticated }}
            {{ role }}
            <v-form @submit.prevent="onLogin">
                <div class="text-subtitle-1 text-medium-emphasis">Username</div>
                <v-text-field density="compact" placeholder="Username" v-model="username" v-bind="usernameAttrs"
                    prepend-inner-icon="mdi-account-key" variant="outlined"
                    :error-messages="errors.username"></v-text-field>
                <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                    Password
                </div>
                <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
                    density="compact" placeholder="Enter your password" prepend-inner-icon="mdi-lock-outline"
                    variant="outlined" @click:append-inner="visible = !visible" v-model="password" v-bind="passwordAttrs"
                    :error-messages="errors.password"></v-text-field>
                <v-btn type="submit" block class="mb-8" color="blue" size="large" variant="tonal">
                    Log In
                </v-btn>

                <v-card-text class="text-center">
                    <a class="text-blue text-decoration-none cursor-pointer" @click="routerSignup" rel="noopener noreferrer"
                        target="_blank">
                        Sign up now <v-icon icon="mdi-chevron-right"></v-icon>
                    </a>
                </v-card-text>
            </v-form>
        </v-card>
    </div>
</template>

<script setup>
import { Toaster } from '@/composable/useToast'
import { useRouter } from 'vue-router'
import { ref } from 'vue';
import { useForm } from 'vee-validate'
import * as yup from 'yup'
import { useAxios } from '@/composable/useAxios'
import { createNamespacedHelpers } from 'vuex-composition-helpers';
const router = useRouter()
const visible = ref(false)
const { useToaster } = Toaster();
const { useState, useActions } = createNamespacedHelpers('auth'); // specific module name

const yupSchema = yup.object().shape({
    username: yup.string().required('Username is not empty'),
    password: yup.string().required('password is not empty'),
});

const { handleSubmit, defineField, errors } = useForm({
    validationSchema: yupSchema
});

const [username, usernameAttrs] = defineField('username');
const [password, passwordAttrs] = defineField('password');
const { name, isAuthenticated, role } = useState(['name', 'isAuthenticated', 'role'])
const { saveUser } = useActions(['saveUser'])

const routerSignup = () => {
    router.push('/signup');
}

const onLogin = handleSubmit(async (values) => {
    const formData = new FormData();
    formData.append('data', JSON.stringify(values));
    const response = await useAxios({
        method: 'POST',
        api: '/login.php?action=POST',
        data: formData,
        header: {
            'Content-Type': 'multipart/form-data'
        },
    });
    if (response.ok) {
        if (response.data.status === 1) {
            saveUser(response.data.data)
            if (isAuthenticated.value && role.value === 'STUDENT') {
                router.push('/user/')
            }else{
                router.push('/admin/')
            }
        } else {
            useToaster(response.data.message, 'error');
        }

    } else {
        useToaster(response.data.error, 'error');
    }
});

// specific module name
</script>

<style scoped></style>