<script setup lang="ts">
// component
import Breadrumb from '@/Components/Breadrumb.vue';
import Button from '@/Components/Button.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from "@/Components/Card.vue";
import { TableLayout, THead, TBody, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';

// modal
import useModalStore from '@/stores/useModalStore';
import CreateModalWindow from '@/Pages/Proyek/Modals/Create.m.vue';
import EditModalWindow from '@/Pages/Proyek/Modals/Edit.m.vue';
import DeleteModalWindow from '@/Pages/Proyek/Modals/Delete.m.vue';

// utils
import { toRupiah } from '@/utilities/number';
import { ll } from "@/utilities/date";

// vue
import { computed, onUpdated } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

interface Proyek {
    id_proyek: string,
    nama_proyek: string,
    tahun_anggaran: string,
    pengguna_jasa: string,
    waktu_mulai: Date,
    waktu_selesai: Date,
    nilai_kontrak: number,
    status_proyek: 100 | 400,
    pic: string,
};

const props = defineProps<{
    daftarProyek: Array<Proyek>,
    errors: Object,
    flash: {
        success: string | boolean,
        error: string | boolean,
    },
}>();

const modal = useModalStore();

const computed__daftarProyek = computed(() => {
    return props.daftarProyek.map(proyek => {
        const computed__waktu_mulai = ll(proyek.waktu_mulai);
        const computed__waktu_selesai = ll(proyek.waktu_selesai);
        const computed__status_proyek = (proyek.status_proyek === 100) ? 'Closed' : 'On Progress';
        const computed__nilai_kontrak = toRupiah(proyek.nilai_kontrak);        

        return { ...proyek,
            waktu_mulai: computed__waktu_mulai,
            waktu_selesai: computed__waktu_selesai,
            status_proyek: computed__status_proyek,
            nilai_kontrak: computed__nilai_kontrak,
        };
    });
});

function openCreateModal() {
    modal.open({ component: CreateModalWindow,
        props: {
            errors: props.errors,
        }
    });
}

function openEditModal(proyek: Object) {
    modal.open({ component: EditModalWindow,
        props: {
            proyek: proyek,
            errors: props.errors,
        }
    });
}

function openDeleteModal(id_proyek: string) {
    modal.open({ component: DeleteModalWindow,
        props: {
            id_proyek: id_proyek,
        }
    });
}

onUpdated(() => {
    if (Object.keys(props.errors).length) {
        modal.$patch((res) => {
            if (res.state.props) res.state.props.errors = props.errors;
        });
    } else modal.$reset();

    if (props.flash.success) {
        setTimeout(() => {
            props.flash.success = false;
        }, 5000);
    }
});
</script>

<template>
    <Head title="Daftar Proyek" />

    <Teleport to="body">
        <div v-if="flash.success" class="fixed bottom-5 right-5 bg-success text-white px-4 py-2 rounded-lg shadow-soft-lg">
            <FasIcon icon="fa-solid fa-check-circle" class="mr-2" /> {{ flash.success }}
        </div>
    </Teleport>
    
    <AuthenticatedLayout>
        <template v-slot:breadcrumb>
            <Breadrumb v-slot:breadcrumb v-bind="{ second: 'Proyek', current: 'Daftar Proyek' }" />
        </template>

        <ContentLayout>

            <CardLayout>
                <CardHeader>
                    <div class="flex justify-between items-center">
                        <Button @click="openCreateModal" type="button"><FasIcon icon="fa-solid fa-plus" class="mr-1" /> Proyek Baru</Button>
                        <Button type="button" color="transparent"><FasIcon icon="fa-solid fa-search" class="mr-1" /> Cari</Button>
                    </div>
                </CardHeader>

                <CardBody :isContentTable="true">
                    <TableLayout>
                        <THead>
                            <TRow>
                                <THeadCell value="Nama Proyek" />
                                <THeadCell value="Tahun Anggaran" />
                                <THeadCell value="Pengguna Jasa" />
                                <THeadCell textAlign="center" value="Waktu Mulai" />
                                <THeadCell textAlign="center" value="Waktu Selesai" />
                                <THeadCell textAlign="right" value="Nilai Kontrak" />
                                <THeadCell value="Status" />
                                <THeadCell value="Aksi" />
                            </TRow>
                        </THead>
                        <TBody>
                            <TRow
                                v-if="computed__daftarProyek.length"
                                v-for="(proyek, index) in computed__daftarProyek" :key="proyek.id_proyek"
                                v-bind="{ last: index === computed__daftarProyek.length - 1 }">

                                <TBodyCell>
                                    <Link href="#">
                                        <ButtonLink color="secondary" class="text-left">
                                            <p class="line-clamp-2 hover:line-clamp-none">{{ proyek.nama_proyek }}</p>
                                        </ButtonLink>
                                    </Link>
                                </TBodyCell>
                                <TBodyCell whitespace="nowrap">{{ proyek.tahun_anggaran }}</TBodyCell>
                                <TBodyCell>{{ proyek.pengguna_jasa }}</TBodyCell>
                                <TBodyCell whitespace="nowrap" textAlign="center">{{ proyek.waktu_mulai }}</TBodyCell>
                                <TBodyCell whitespace="nowrap" textAlign="center">{{ proyek.waktu_selesai }}</TBodyCell>
                                <TBodyCell whitespace="nowrap" textAlign="right">{{ proyek.nilai_kontrak }}</TBodyCell>
                                <TBodyCell whitespace="nowrap">
                                    <ButtonLink v-bind="{
                                        color: (proyek.status_proyek === 'Closed') ? 'danger' : 'success',
                                    }">{{ proyek.status_proyek }}</ButtonLink>
                                </TBodyCell>
                                <TBodyCell whitespace="nowrap">
                                    <div class="flex space-x-4">
                                        <ButtonLink @click="openEditModal(proyek)" color="secondary">Edit</ButtonLink>
                                        <ButtonLink @click="openDeleteModal(proyek.id_proyek)" color="danger">Delete</ButtonLink>
                                    </div>
                                </TBodyCell>
                            </TRow>

                            <TRow v-else last>
                                <TBodyCell colspan="7" textAlign="center">Proyek tidak ditemukan</TBodyCell>
                            </TRow>
                        </TBody>
                    </TableLayout>
                </CardBody>
            </CardLayout>

        </ContentLayout>

    </AuthenticatedLayout>
</template>