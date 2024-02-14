<template>
    <div>
        <h1>Signup</h1>

        <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
            <div class="text-subtitle-1 text-medium-emphasis">Account</div>

            <v-text-field density="compact" placeholder="Email address" prepend-inner-icon="mdi-email-outline"
                variant="outlined" v-model="email" v-bind="emailAttrs" :error-messages="errors.email"></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                Password
            </div>

            <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
                density="compact" placeholder="Enter your password" prepend-inner-icon="mdi-lock-outline" variant="outlined"
                @click:append-inner="visible = !visible" v-model="password" v-bind="passwordAttrs"
                :error-messages="errors.password"></v-text-field>

            <!-- <v-card class="mb-12" color="surface-variant" variant="tonal">
                <v-card-text class="text-medium-emphasis text-caption">
                    Warning: After 3 consecutive failed login attempts, you account will be temporarily locked for three
                    hours. If you must login now, you can also click "Forgot login password?" below to reset the login
                    password.
                </v-card-text>
            </v-card> -->

            <v-btn block class="mb-8" color="blue" size="large" variant="tonal">
                Log In
            </v-btn>

            <v-card-text class="text-center">
                <a class="text-blue text-decoration-none cursor-pointer" @click="onSignup" href="#"
                    rel="noopener noreferrer" target="_blank">
                    Sign up now <v-icon icon="mdi-chevron-right"></v-icon>
                </a>
            </v-card-text>
        </v-card>
    </div>
</template>

<script setup>
import { useForm } from 'vee-validate';
import * as yup from 'yup'
import { ref } from 'vue'

const visible = ref(false);
const yupSchema = yup.object().shape({
    email: yup.string().email().required(),
    password: yup.string().min(6).required(),
});

const { handleSubmit, defineField, errors } = useForm({
    validationSchema: yupSchema
});

const [email, emailAttrs] = defineField('email');
const [password, passwordAttrs] = defineField('password');


const onSignup = handleSubmit((values) => {
    
});
</script>

<style scoped></style>