<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import { ModalWindow } from '@/Components/Modal.vue';
import Toast from '@/Components/Toast.vue';

const fullYear: number = new Date().getFullYear();
</script>

<template>
    <aside class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between overflow-y-auto rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-transform duration-200 xl:left-0 xl:translate-x-0 xl:bg-transparent">
        <div class="h-19.5">
            <a class="block px-4 py-4 m-0 text-sm whitespace-nowrap text-slate-700" href="#">
                <img src="/storage/logo.png" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand border border-primary" alt="main_logo" />
                <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand"></span>
            </a>
        </div>

        <hr class="h-px mt-4 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

        <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
            <ul class="flex flex-col pl-0 mb-0">
                <li class="mt-0.5 w-full">
                    <NavLink
                        name="Dashboard"
                        icon="fa-solid fa-gauge"
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                    />
                </li>

                <template v-if="$page.props.role === 'admin'">
                    <li class="w-full mt-8 mb-2">
                        <h6 class="pl-6 ml-2 font-bold leading-tight uppercase text-xs opacity-60">Master</h6>
                    </li>
    
                    <li class="mt-0.5 w-full">
                        <NavLink
                            name="Users"
                            icon="fa-solid fa-users"
                            :href="route('users')"
                            :active="route().current('users')"
                        />
                    </li>

                    <li class="mt-0.5 w-full">
                        <NavLink
                            name="Satuan"
                            icon="fa-solid fa-ruler-horizontal"
                            :href="route('satuan')"
                            :active="route().current('satuan')"
                        />
                    </li>

                    <li class="mt-0.5 w-full">
                        <NavLink
                            name="Rekening"
                            icon="fa-solid fa-credit-card"
                            :href="route('rekening')"
                            :active="route().current('rekening')"
                        />
                    </li>
                </template>

                <!-- <li class="mt-0.5 w-full">
                    <NavLink
                        name="Roles & Permissions"
                        icon="fa-solid fa-universal-access"
                        :href="route('proyek')"
                    />
                </li> -->

                <li class="w-full mt-8 mb-2">
                    <h6 class="pl-6 ml-2 font-bold leading-tight uppercase text-xs opacity-60">Main</h6>
                </li>

                <li class="mt-0.5 w-full">
                    <NavLink
                        name="Proyek"
                        icon="fa-solid fa-diagram-project"
                        :href="route('proyek')"
                        :active="route().current('proyek')"
                    />
                </li>

                <li class="mt-0.5 w-full">
                    <NavLink
                        name="RAB"
                        icon="fa-solid fa-window-restore"
                        :href="route('rab')"
                        :active="route().current('rab') || route().current('detail_rab')"
                    />
                </li>

                <li class="mt-0.5 w-full">
                    <NavLink
                        name="RAPP"
                        icon="fa-solid fa-window-restore"
                        :href="route('rap')"
                        :active="route().current('rap') || route().current('detail_rap')"
                    />
                </li>

                <li class="mt-0.5 w-full">
                    <NavLink
                        name="Keuangan"
                        icon="fa-solid fa-money-bill"
                        :href="route('keuangan')"
                        :active="route().current('keuangan') || route().current('pengajuan_dana.detail') || route().current('pencairan_dana.detail')"
                    />
                </li>

                <li class="w-full mt-8 mb-2">
                    <h6 class="pl-6 ml-2 font-bold leading-tight uppercase text-xs opacity-60">Reports</h6>
                </li>

                <li class="mt-0.5 w-full">
                    <NavLink
                        name="Pengajuan Dana"
                        icon="fa-solid fa-file-lines"
                        :href="route('laporan.pengajuan_dana')"
                        :active="route().current('laporan.pengajuan_dana')"
                    />
                </li>

                <li class="mt-0.5 w-full">
                    <NavLink
                        name="Penagihan/Invoice"
                        icon="fa-solid fa-file-lines"
                        :href="route('laporan.pencairan_dana')"
                        :active="route().current('laporan.pencairan_dana')"
                    />
                </li>

                <!-- <li class="mt-0.5 w-full">
                    <NavLink
                        name="Evaluasi Proyek"
                        icon="fa-solid fa-file-lines"
                        :href="route('proyek')"
                    />
                </li> -->
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
                    <li class="flex items-center gap-4">
                        <Link
                            :href="route('profile.edit')"
                            :class="{
                                'bg-white drop-shadow-lg': route().current('profile.edit')
                            }"
                            class="transition flex items-center gap-4 p-2 pr-4 rounded-2xl hover:bg-white hover:drop-shadow-lg">
                            <img
                                :src="`https://ui-avatars.com/api/?name=${$page.props.auth.user.name}`"
                                alt="User Avatar"
                                class="w-10 rounded-full"
                            />
                            <div>
                                <span class="link text-sm no-underline">
                                    {{ $page.props.auth.user.name }}
                                </span>
                                <p class="capitalize text-xs">{{ $page.props.role }}</p>
                            </div>
                        </Link>
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