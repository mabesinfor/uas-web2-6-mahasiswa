<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  options: {
    type: Array,
    required: true
  },
  modelValue: {
    type: [String, Number],
    default: ''
  },
  label: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: 'Pilih opsi'
  }
});

const emit = defineEmits(['update:modelValue']);

const search = ref('');
const isOpen = ref(false);

const filteredOptions = computed(() => {
  return props.options.filter(option => 
    option.label.toLowerCase().includes(search.value.toLowerCase())
  );
});

const selectOption = (value) => {
  emit('update:modelValue', value);
  isOpen.value = false;
  search.value = '';
};

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
  if (isOpen.value) {
    search.value = '';
  }
};
</script>

<template>
  <div class="relative">
    <label v-if="label" :for="label" class="block font-medium text-sm text-gray-700">{{ label }}</label>
    <div @click="toggleDropdown" class="mt-1 relative">
      <input
        :id="label"
        type="text"
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        :value="options.find(option => option.value === modelValue)?.label || ''"
        readonly
        :placeholder="placeholder"
      />
    </div>
    <div v-if="isOpen" class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg">
      <input
        v-model="search"
        type="text"
        class="w-full p-2 border-b"
        placeholder="Cari..."
        @click.stop
      />
      <ul class="max-h-60 overflow-auto">
        <li
          v-for="option in filteredOptions"
          :key="option.value"
          @click="selectOption(option.value)"
          class="p-2 hover:bg-gray-100 cursor-pointer"
        >
          {{ option.label }}
        </li>
      </ul>
    </div>
  </div>
</template>