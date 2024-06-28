<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PieChart from '@/Components/PieChart.vue';

const props = defineProps({
  programStudiData: Array,
  jumlahMahasiswa: Number,
  jumlahMataKuliah: Number,
  rataRataNilai: Number,
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-2">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <h3 class="text-lg font-semibold mb-4">Selamat datang di Sistem Informasi Mahasiswa!</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
              <div class="bg-blue-100 p-4 rounded-lg">
                <h4 class="font-semibold">Jumlah Mahasiswa</h4>
                <p class="text-2xl">{{ jumlahMahasiswa }}</p>
              </div>
              <div class="bg-green-100 p-4 rounded-lg">
                <h4 class="font-semibold">Jumlah Mata Kuliah</h4>
                <p class="text-2xl">{{ jumlahMataKuliah }}</p>
              </div>
              <div class="bg-yellow-100 p-4 rounded-lg">
                <h4 class="font-semibold">Rata-rata Nilai</h4>
                <p class="text-2xl">{{ rataRataNilai }}</p>
              </div>
            </div>
            <div class="mb-8 flex flex-col justify-center items-center">
                <div class="max-w-xs">
                    <h4 class="font-semibold mb-4">Distribusi Mahasiswa per Program Studi</h4>
                    <PieChart :data="programStudiData" />
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>