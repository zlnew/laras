<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import { ModalWindow } from '@/Components/Modal.vue';
import Toast from '@/Components/Toast.vue';

const fullYear: number = new Date().getFullYear();
const url = window.location.href;
</script>

<template>
    <aside class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between overflow-y-auto rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-transform duration-200 xl:left-0 xl:translate-x-0 xl:bg-transparent">
        <div class="h-19.5">
            <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="" target="_blank">
                <img src="" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8" alt="main_logo" />
                <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand"></span>
            </a>
        </div>

        <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

        <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
            <ul class="flex flex-col pl-0 mb-0">
                <li class="mt-0.5 w-full">
                    <NavLink
                        name="Dashboard"
                        icon="fa-solid fa-gauge"
                        :href="route('dashboard')" :active="route().current('dashboard')"
                    />
                </li>

                <li class="mt-0.5 w-full">
                    <NavLink
                        name="Proyek"
                        icon="fa-solid fa-diagram-project"
                        :href="route('proyek')" :active="route().current('proyek')"
                    />
                </li>
                <li class="mt-0.5 w-full">
                    <NavLink
                        name="RAB"
                        icon="fa-solid fa-diagram-project"
                        :href="route('rab.search')" :active="route().current('rab.search') || route().current('rab.detail')"
                    />
                </li>
            </ul>
        </div>
    </aside>

    <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
        <!-- Navbar -->
        <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="true">
            <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
                <!-- breadcrumb -->
                <nav>
                    <slot name="breadcrumb"></slot>
                </nav>

                <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
                    <li class="flex items-center">
                        <Link :href="route('logout')" method="post" as="button">
                            <EaseButton variant="danger-transparent" slotted>
                                <FasIcon icon="fa-solid fa-sign-out-alt" class="mr-2" /> Logout
                            </EaseButton>
                        </Link>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="w-full px-6 py-6 mx-auto">
            <slot></slot>

            <!-- footer -->
            <footer class="pt-4">
                <div class="w-full px-6 mx-auto">
                    <div class="flex flex-wrap items-center -mx-3 lg:justify-between">
                        <div class="w-full max-w-full px-3 mt-0 mb-6 shrink-0 lg:mb-0 lg:w-1/2 lg:flex-none">
                            <div class="text-sm leading-normal text-center text-slate-500 lg:text-left">
                                © {{ fullYear }} Creatoku All rigths reserved.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>

    <ModalWindow />
    <Toast />
</template>