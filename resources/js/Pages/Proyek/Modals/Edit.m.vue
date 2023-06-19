<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { FormInput, FormLabel, FormError } from "@/Components/Form.vue";
import { toRupiah, fromRupiah } from "@/utilities/number";
import { computed } from "vue";
import { revertDate } from "@/utilities/date";
import useModalStore from "@/stores/useModalStore";

interface Proyek<T = string> {
    id_proyek: T,
    nama_proyek: T,
    tahun_anggaran: T,
    pengguna_jasa: T,
    waktu_mulai: T,
    waktu_selesai: T,
    nilai_kontrak: T,
    pic: T,
};

const props = defineProps<{
    proyek: Proyek,
}>();

const sanitized__proyek = computed(() => {
    const proyek = props.proyek;
    const computed__waktu_mulai = revertDate(proyek.waktu_mulai);
    const computed__waktu_selesai = revertDate(proyek.waktu_selesai);
    const computed__nilai_kontrak = fromRupiah(proyek.nilai_kontrak) || 0;

    return {
        ...proyek,
        waktu_mulai: computed__waktu_mulai,
        waktu_selesai: computed__waktu_selesai,
        nilai_kontrak: computed__nilai_kontrak,
    };
});

const modal = useModalStore();

const form = useForm({
    nama_proyek: sanitized__proyek.value.nama_proyek,
    tahun_anggaran: sanitized__proyek.value.tahun_anggaran,
    pengguna_jasa: sanitized__proyek.value.pengguna_jasa,
    waktu_mulai: sanitized__proyek.value.waktu_mulai,
    waktu_selesai: sanitized__proyek.value.waktu_selesai,
    nilai_kontrak: sanitized__proyek.value.nilai_kontrak,
    pic: sanitized__proyek.value.pic,
});

function update() {
    form.patch(route('proyek.update', props.proyek.id_proyek), {
        onSuccess:() => {
            modal.close();
        }
    });
}
</script>

<template>
    <ModalLayout size="5xl">
        <ModalHead title="Form Edit Proyek" />
    
        <ModalBody>
            <div class="w-full mb-4">
                <FormLabel for="nama_proyek" value="Nama Proyek" />
                <FormInput v-model="form.nama_proyek" v-bind="{
                    type: 'text', id: 'nama_proyek', size: 'lg', autocomplete: 'off', placeholder: 'Nama Proyek'
                }" />
    
                <FormError class="mt-2" :message="form.errors.nama_proyek" />
            </div>

            <div class="w-full mb-4 grid grid-cols-3 gap-4">
                <div class="col-span-2">
                    <FormLabel for="pengguna_jasa" value="Pengguna Jasa" />
                    <FormInput v-model="form.pengguna_jasa" v-bind="{
                        type: 'text', id: 'pengguna_jasa', size: 'lg', autocomplete: 'off', placeholder: 'Pengguna Jasa'
                    }" />
        
                    <FormError class="mt-2" :message="form.errors.pengguna_jasa" />
                </div>
                <div>
                    <FormLabel for="tahun_anggaran" value="Tahun Anggaran" />
                    <FormInput v-model="form.tahun_anggaran" v-bind="{
                        type: 'text', id: 'tahun_anggaran', size: 'lg', autocomplete: 'off', placeholder: 'Tahun Anggaran'
                    }" />
        
                    <FormError class="mt-2" :message="form.errors.tahun_anggaran" />
                </div>
            </div>

            <div class="w-full mb-4 grid grid-cols-2 gap-4">
                <div>
                    <FormLabel for="waktu_mulai" value="Tanggal Mulai" />
                    <FormInput v-model="form.waktu_mulai" v-bind="{
                        type: 'date', id: 'waktu_mulai', size: 'lg', autocomplete: 'off', placeholder: 'Tanggal Mulai'
                    }" />
        
                    <FormError class="mt-2" :message="form.errors.waktu_mulai" />
                </div>
                <div>
                    <FormLabel for="waktu_selesai" value="Tanggal Selesai" />
                    <FormInput v-model="form.waktu_selesai" v-bind="{
                        type: 'date', id: 'waktu_selesai', size: 'lg', autocomplete: 'off', placeholder: 'Tanggal Selesai'
                    }" />
        
                    <FormError class="mt-2" :message="form.errors.waktu_selesai" />
                </div>
            </div>

            <div class="w-full mb-4 grid grid-cols-2 gap-4">
                <div>
                    <FormLabel for="nilai_kontrak" value="Nilai Kontrak" />
                    <small class="ml-1" v-show="form.nilai_kontrak">: {{ toRupiah(form.nilai_kontrak) }}</small>
                    <FormInput v-model="form.nilai_kontrak" v-bind="{
                        type: 'number', id: 'nilai_kontrak', size: 'lg', autocomplete: 'off', placeholder: 'Nilai Kontrak'
                    }" />
        
                    <FormError class="mt-2" :message="form.errors.nilai_kontrak" />
                </div>
                <div>
                    <FormLabel for="pic" value="Penanggung Jawab" />
                    <FormInput v-model="form.pic" v-bind="{
                        type: 'text', id: 'pic', size: 'lg', autocomplete: 'off', placeholder: 'Penanggung Jawab'
                    }" />
        
                    <FormError class="mt-2" :message="form.errors.pic" />
                </div>
            </div>
        </ModalBody>
        
        <ModalFooter>
            <EaseButton @click="modal.close" v-bind="{type: 'button', text: 'Close', variant: 'transparent'}" />
            <EaseButton @click.prevent="update" v-bind="{
                type: 'submit',
                text: 'Update',
                loading: form.processing,
                onLoading: () => ({
                    text: 'Updating data...',
                })
            }" />
        </ModalFooter>
    </ModalLayout>
</template>