<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { FormCheckbox, FormInput, FormError, FormLabel } from "@/Components/Form.vue";

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Login" />
    
    <section>
      <div class="relative bg-white flex items-center p-0 overflow-hidden bg-center bg-cover min-h-75-screen">
        <div class="container z-10">
          <div class="flex flex-wrap mt-0 -mx-3">
            <div class="flex flex-col w-full max-w-full px-3 mx-auto md:flex-0 shrink-0 md:w-6/12 lg:w-5/12 xl:w-4/12">
              <div class="relative flex flex-col min-w-0 mt-32 break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-transparent border-b-0 rounded-t-2xl">
                  <h3 class="text-2xl relative z-10 font-bold text-transparent bg-secondary bg-clip-text">Selamat Datang</h3>
                  <p class="mb-0">Masukkan username dan password anda.</p>
                </div>
                <div class="flex-auto p-6">
                  <form @submit.prevent="submit">
                    <FormLabel for="username" value="Username" />
                    <div class="mb-4">
                      <FormInput v-model="form.email" v-bind="{
                        type: 'text', id: 'username', size: 'lg', autocomplete: 'off', placeholder: 'Username'
                      }" />

                      <FormError class="mt-2" :message="form.errors.email" />
                    </div>

                    <FormLabel for="password" value="Password" />
                    <div class="mb-4">
                      <FormInput v-model="form.password" v-bind="{
                        type: 'password', id: 'password', size: 'lg', autocomplete: 'off', placeholder: 'Password'
                      }" />

                      <FormError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mb-4">
                      <FormCheckbox id="remember_me" name="remember" v-model:checked="form.remember" />
                      <label class="mb-2 ml-3 font-normal cursor-pointer select-none text-sm text-primary" for="remember_me">Remember me</label>
                    </div>

                    <div class="text-center">
                      <EaseButton v-bind="{
                          type: 'submit',
                          variant: 'primary',
                          text: 'Log in',
                          class: 'w-full',
                          loading: form.processing,
                          onLoading: () => ({
                              text: 'Verifying user',
                          })
                        }"
                      />
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="w-full max-w-full px-3 lg:flex-0 shrink-0 md:w-6/12">
              <div class="absolute top-0 hidden w-3/5 h-full -mr-32 -right-40 md:block">
                <!-- <div class="absolute inset-x-0 top-0 z-0 h-full -ml-16 bg-cover overflow-hidden -skew-x-10 rounded-bl-xl" style="background-image: url('{{ Storage::url('img/bg/login.jpg') }} ')"></div>
                <img src="{{ Storage::url('img/logos/utama.png') }}" class="absolute w-1/2 bg-white p-2 bottom-20 mr-40 right-40" alt="Laras Sembada Logo">
                <div class="absolute bottom-6 mr-40 right-40">
                  <h4 class="text-[25.7px] text-white font-outline-1 drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]">
                      Membangun Masa Depan Bersama
                  </h4>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </GuestLayout>
</template>