<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    mataKuliah: Object,
});

const form = useForm({
    kode: props.mataKuliah.kode,
    nama: props.mataKuliah.nama,
    sks: props.mataKuliah.sks,
});

const submit = () => {
    form.put(route('mata-kuliah.update', props.mataKuliah.id));
};

const errors = computed(() => usePage().props.errors);
</script>

<template>
    <Head title="Edit Mata Kuliah" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Mata Kuliah</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="Object.keys(errors).length > 0" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops! </strong>
                    <span class="block sm:inline">Ada beberapa kesalahan:</span>
                    <ul class="mt-2 list-disc list-inside">
                        <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
                    </ul>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div>
                                <label for="kode" class="block font-medium text-sm text-gray-700">Kode Mata Kuliah</label>
                                <input id="kode" v-model="props.mataKuliah.kode" type="text" class="mt-1 block w-full" required autofocus>
                                <div v-if="form.errors.kode" class="text-red-500 mt-2 text-sm">{{ form.errors.kode }}</div>
                            </div>
                            <div>
                                <label for="nama" class="block font-medium text-sm text-gray-700">Nama Mata Kuliah</label>
                                <input id="nama" v-model="form.nama" type="text" class="mt-1 block w-full" required autofocus>
                                <div v-if="form.errors.nama" class="text-red-500 mt-2 text-sm">{{ form.errors.nama }}</div>
                            </div>
                            <div>
                                <label for="sks" class="block font-medium text-sm text-gray-700">SKS</label>
                                <input id="sks" v-model="form.sks" type="number" class="mt-1 block w-full" required autofocus>
                                <div v-if="form.errors.sks" class="text-red-500 mt-2 text-sm">{{ form.errors.sks }}</div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md" :disabled="form.processing">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>