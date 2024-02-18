<script setup>
// import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
})

const form = useForm({
  email: '',
  password: '',
  remember: false,
})
const showPassword = ref(false)

const submit = () => {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  })
}
</script>
<script>
export default {
  name: 'LoginPage',
}
</script>

<template>
  <Head title="Log in" />
  <div class="login-wrapper">
    <div class="d-flex justify-space-between">
      <v-form class="login-form" @submit.prevent="submit">
        <v-row>
          <v-col>
            <v-label class="font-reg">Email:</v-label>
            <v-text-field
              v-model="form.email"
              type="email"
              rounded
              class="input-login"
              variant="text"
              density="compact"
              placeholder="Email address"
              prepend-inner-icon="mdi-email-outline"
              :error-messages="form.errors.email"
            />
            <v-label class="font-reg mt-6">Password:</v-label>
            <v-text-field
              v-model="form.password"
              rounded
              density="compact"
              class="input-login"
              variant="text"
              placeholder="Enter your password"
              prepend-inner-icon="mdi-lock-outline"
              :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
              :type="showPassword ? 'text' : 'password'"
              :error-messages="form.errors.password"
              @click:append-inner="showPassword = !showPassword"
            />
            <div class="d-flex justify-space-between align-center">
              <v-checkbox v-model="form.remember" class="mt-4" color="#0E0F3D" label="Keep me logged in"></v-checkbox>
              <Link variant="text" class="fc-gray text-decoration-none">Forget password?</Link>
            </div>
            <v-btn :loading="form.processing" type="submit" size="large">Sign In</v-btn>
          </v-col>
        </v-row>
      </v-form>
      <div class="bg-login"></div>
    </div>
    <!--    <v-col>-->
    <!--    <v-img src="https://i.postimg.cc/BZ2hJ5zf/ap-house.jpg"></v-img>-->
    <!--    </v-col>-->
  </div>
</template>
