<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import SearchableSelect from '@/Components/SearchableSelect.vue';

const props = defineProps({
    mahasiswa: Array,
    mataKuliah: Array
});

const form = useForm({
    mahasiswa_id: '',
    mata_kuliah_id: '',
    nilai: '',
});

const submit = () => {
    form.post(route('nilai.store'));
};

const errors = computed(() => usePage().props.errors);

const mahasiswaOptions = computed(() => 
  props.mahasiswa.map(m => ({ value: m.id, label: `${m.nim} - ${m.nama}` }))
);

const mataKuliahOptions = computed(() => 
  props.mataKuliah.map(mk => ({ value: mk.id, label: `${mk.kode} - ${mk.nama}` }))
);
</script>

<template>
    <Head title="Tambah Nilai" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Nilai</h2>
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
                                <SearchableSelect
                                    v-model="form.mahasiswa_id"
                                    :options="mahasiswaOptions"
                                    label="Mahasiswa"
                                    placeholder="Pilih mahasiswa"
                                />
                                <div v-if="form.errors.mahasiswa_id" class="text-red-500 mt-2 text-sm">{{ form.errors.mahasiswa_id }}</div>
                            </div>
                            <div>
                                <SearchableSelect
                                    v-model="form.mata_kuliah_id"
                                    :options="mataKuliahOptions"
                                    label="Mata Kuliah"
                                    placeholder="Pilih mata kuliah"
                                />
                                <div v-if="form.errors.mata_kuliah_id" class="text-red-500 mt-2 text-sm">{{ form.errors.mata_kuliah_id }}</div>
                            </div>
                            <div>
                                <label for="nilai" class="block font-medium text-sm text-gray-700">Nilai</label>
                                <input id="nilai" v-model="form.nilai" type="text" class="mt-1 block w-full" required autofocus>
                                <div v-if="form.errors.nilai" class="text-red-500 mt-2 text-sm">{{ form.errors.nilai }}</div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md" :disabled="form.processing">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>