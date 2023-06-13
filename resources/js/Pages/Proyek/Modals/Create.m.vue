<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import Button from "@/Components/Button.vue";
import useModalStore from "@/stores/useModalStore";
import { useForm } from "@inertiajs/vue3";
import { FormInput, FormLabel, FormError } from "@/Components/Form.vue";
import { toRupiah } from "@/utilities/number";

const modal = useModalStore();

const form = useForm({
    nama_proyek: null,
    tahun_anggaran: null,
    pengguna_jasa: null,
    waktu_mulai: null,
    waktu_selesai: null,
    nilai_kontrak: null,
    pic: null,
});

function submit() {
    form.post(route('proyek.store'), {
        onSuccess: () => {
            modal.close();
        }
    });
}
</script>

<template>
    <ModalLayout size="5xl">
        <ModalHead title="Form Tambah Proyek Baru" />
    
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
            <Button @click="modal.close" type="button" color="light">Close</Button>
            <Button @click.prevent="submit" v-bind="{
                type:'submit', color: 'primary', loading:form.processing
            }">Submit</Button>
        </ModalFooter>
    </ModalLayout>
</template>