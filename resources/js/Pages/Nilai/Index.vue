<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3';
import { ref, defineProps, computed, watch, onMounted } from 'vue';

const props = defineProps({
    nilai: Array,
    pagination: {
        type: Object,
        required: true,
    },
    search: String,
    sort: Object,
});

const handleDelete = (id) => {
  if (window.confirm('Apakah Anda yakin ingin menghapus data ini?')) {
    router.delete(route('nilai.destroy', { nilai: id }));
  }
};

const selectedItems = ref([]);

const form = useForm({
    ids: [],
});

const handleBulkDelete = () => {
    if (window.confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')) {
        form.ids = selectedItems.value;
        form.delete(route('nilai.bulk-destroy'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                selectedItems.value = [];
            },
        });
    }
};

const toggleSelectAll = (event) => {
    if (event.target.checked) {
        selectedItems.value = props.nilai.map(nilai => nilai.id);
    } else {
        selectedItems.value = [];
    }
};

const isAllSelected = computed(() => {
    return selectedItems.value.length === props.nilai.length;
});

const selectedCount = computed(() => {
    return selectedItems.value.length;
});

const previousPage = () => {
    if (props.pagination.prev_page_url) {
        router.get(route('nilai.index', { search: search.value, page: props.pagination.current_page - 1 }));
    }
};

const nextPage = () => {
    if (props.pagination.next_page_url) {
        router.get(route('nilai.index', { search: search.value, page: props.pagination.current_page + 1 }));
    }
};

const goToPage = (page) => {
    router.get(route('nilai.index', { search: search.value, page: page }));
};

const paginationRange = () => {
    const current = props.pagination.current_page;
    const last = props.pagination.last_page;
    const delta = 2;
    const range = [];
    const rangeWithDots = [];

    for (let i = Math.max(2, current - delta); i <= Math.min(last - 1, current + delta); i++) {
        range.push(i);
    }

    if (current - delta > 2) rangeWithDots.push('...');
    rangeWithDots.push(...range);
    if (current + delta < last - 1) rangeWithDots.push('...');

    return rangeWithDots;
};

const search = ref(props.search || '');
let searchTimer = null;

const sort = ref(props.sort || { column: null, direction: 'asc' });

const performSearch = () => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        router.get(route('nilai.index', { 
            search: search.value, 
            page: 1,
            sort: sort.value.column,
            direction: sort.value.direction
        }), {
            preserveState: true,
            replace: true,
        });
    }, 300);
};

watch(search, performSearch);

const handleSort = (column) => {
    if (sort.value.column === column) {
        if (sort.value.direction === 'asc') {
            sort.value.direction = 'desc';
        } else if (sort.value.direction === 'desc') {
            sort.value.column = null;
            sort.value.direction = 'asc';
        } else {
            sort.value.direction = 'asc';
        }
    } else {
        sort.value.column = column;
        sort.value.direction = 'asc';
    }
    router.get(route('nilai.index', { 
        search: search.value, 
        page: props.pagination.current_page,
        sort: sort.value.column,
        direction: sort.value.direction
    }), {
        preserveState: true,
        replace: true,
    });
};

const getSortIcon = (column) => {
    if (sort.value.column === column) {
        return sort.value.direction === 'asc' ? '▲' : '▼';
    }
    return '⇅';
};

const page = usePage();
const message = ref('');

watch(() => page.props.flash.message, (newMessage) => {
    message.value = newMessage;
    if (newMessage) {
        setTimeout(() => {
            message.value = '';
        }, 5000);
    }
}, { immediate: true });
</script>

<template>
    <Head title="Nilai" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nilai</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="message" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ message }}</span>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between mb-2">
                            <div class="space-x-2">
                                <Link :href="route('nilai.create')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <span class="hidden sm:inline">Tambah Nilai</span>
                                    <span class="sm:hidden">+</span>
                                </Link>
                                
                            </div>
                            <div class="relative">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Cari nilai..."
                                    class="border rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <svg
                                    class="h-5 w-5 text-gray-400 absolute right-2 top-1/2 transform -translate-y-1/2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span v-if="selectedCount > 0" class="text-sm text-gray-600">
                                {{ selectedCount }} item terpilih
                            </span>
                            <button v-if="selectedCount > 0" @click="handleBulkDelete" class="px-4 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                                Hapus Data
                            </button>
                        </div>

                        <div v-if="props.nilai.length === 0" class="text-center py-4 text-gray-600">
                            Tidak ada data yang sesuai.
                        </div>

                        <table v-else class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left">
                                        <input class="rounded-[4px]" type="checkbox" @change="toggleSelectAll" :checked="isAllSelected">
                                    </th>
                                    <th @click="handleSort('mahasiswa_id')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Nama Mahasiswa
                                        <span v-html="getSortIcon('mahasiswa_id')"></span>
                                    </th>
                                    <th @click="handleSort('mata_kuliah_id')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Nama Mata Kuliah
                                        <span v-html="getSortIcon('mata_kuliah_id')"></span>
                                    </th>
                                    <th @click="handleSort('nilai')" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                        Nilai
                                        <span v-html="getSortIcon('nilai')"></span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="nilai in props.nilai" :key="nilai.id">
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        <input class="rounded-[4px]" type="checkbox" v-model="selectedItems" :value="nilai.id">
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ nilai.mahasiswa.nama }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ nilai.mata_kuliah.nama }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ nilai.nilai }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap flex gap-2">
                                        <Link :href="route('nilai.edit', { nilai: nilai.id })" class="text-yellow-600 hover:text-yellow-900">Edit</Link>
                                        <button @click="handleDelete(nilai.id)" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4 flex justify-between items-center">
                            <div>
                                Tampil {{ (props.pagination.current_page - 1) * props.pagination.per_page + 1 }}-{{ Math.min(props.pagination.current_page * props.pagination.per_page, props.pagination.total) }} dari {{ props.pagination.total }} data
                            </div>
                            <div class="flex space-x-2">
                                <button @click="previousPage" :disabled="!props.pagination.prev_page_url" class="px-4 py-2 bg-gray-800 text-white rounded-md" :class="{ 'opacity-50 cursor-not-allowed': !props.pagination.prev_page_url }">
                                    <span class="hidden sm:inline">Prev</span>
                                    <span class="sm:hidden"><</span>
                                </button>
                                <button @click="goToPage(1)" class="hidden sm:inline px-4 py-2 bg-gray-800 text-white rounded-md" :class="{ 'bg-blue-500': props.pagination.current_page === 1 }">
                                    1
                                </button>
                                <template v-for="page in paginationRange()" :key="page">
                                    <span v-if="page === '...'" class="hidden sm:inline px-4 py-2">...</span>
                                    <button v-else @click="goToPage(page)" class="hidden sm:inline px-4 py-2 bg-gray-800 text-white rounded-md" :class="{ 'bg-blue-500': props.pagination.current_page === page }">
                                        {{ page }}
                                    </button>
                                </template>
                                <button v-if="props.pagination.last_page > 1" @click="goToPage(props.pagination.last_page)" class="hidden sm:inline px-4 py-2 bg-gray-800 text-white rounded-md" :class="{ 'bg-blue-500': props.pagination.current_page === props.pagination.last_page }">
                                    {{ props.pagination.last_page }}
                                </button>
                                <button @click="nextPage" :disabled="!props.pagination.next_page_url" class="px-4 py-2 bg-gray-800 text-white rounded-md" :class="{ 'opacity-50 cursor-not-allowed': !props.pagination.next_page_url }">
                                    <span class="hidden sm:inline">Next</span>
                                    <span class="sm:hidden">></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>