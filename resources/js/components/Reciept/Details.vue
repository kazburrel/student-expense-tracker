<template>
    <div>
        <div class="container mx-auto px-4 py-2">
            <div class="mt-4 border-gray-200">
                <div class="sm:col-span-4">
                    <div class="mt-2">
                        <input id="store" name="store" type="text" placeholder="Store" :value="receivedData.store"
                            disabled
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 font-bold">
                    </div>
                </div>

                <div class="sm:col-span-4 mt-4">
                    <div class="mt-2">
                        <input id="amount" name="amount" type="text" placeholder="&#163; amount"
                            :value="receivedData.amount" disabled
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 font-bold">
                    </div>
                </div>

                <div class="sm:col-span-3 mt-3">
                    <div class="mt-2">
                        <select v-model="selectedCategory" name="category" autocomplete="category"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset sm:max-w-xs sm:text-sm sm:leading-6 font-bold">
                            <option value="">Category...</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-span-full mt-4">
                    <div class="mt-2">
                        <textarea id="about" name="about" rows="10" placeholder="Description"
                            :value="receivedData.description" disabled
                            class="block w-full rounded-md border-0 py-1.5 bg-gray-300 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 font-bold"></textarea>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-4">
                <div class="flex justify-between">
                    <button type="button"
                        class="flex items-center px-4 py-2 rounded-md bg-red-600 text-white font-bold">
                        <svg class="mr-2 h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.7 6.5L17.5 8.7V16c0 1.1-.9 2-2 2H7.5V8.7l-2.2-2.2L6.5 6.5z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path d="M16.5 4.5V4c-.8 0-1.5-.7-1.5-1.5H4.5C4.5-.3 3.8-.8 3 1.5V4.5h13z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                    </button>
                    <button type="button" @click="scanClick"
                        :class="{ 'bg-gray-300 cursor-not-allowed': buttonClicked }" :disabled="buttonClicked"
                        class="flex items-center ml-4 px-4 py-2 rounded-md bg-fuchsia-600 text-white font-bold">
                        <svg class="mr-2 h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.5 18C7.467 18 5 15.533 5 12.5C5 9.467 7.467 7 10.5 7C13.533 7 16 9.467 16 12.5C16 15.533 13.533 18 10.5 18Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M19 19L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <circle cx="10.5" cy="10.5" r="6.75" stroke="currentColor" stroke-width="2" />
                        </svg>
                        <span class="font-bold">Scan</span>
                    </button>
                </div>
                <div>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded-md font-bold">Create</button>
                </div>
            </div>
        </div>
    </div>
</template>



<script setup>
import { onMounted, ref, reactive } from 'vue';
import EventBus from '../../event-bus';
const buttonClicked = ref(false);

const receivedData = reactive({
    store: '',
    amount: '',
    description: '',
    category: ''
});

// const scanClick = () => {
//     EventBus.emit('scan');
//     buttonClicked.value = true;
// };

const categories = ref([]);
const selectedCategory = ref('');
const fetchCategories = async () => {
    try {
        const response = await axios.get('/categories');
        categories.value = response.data;
        if (receivedData.category) {
            const matchedCategory = categories.value.find(category => category.slug === receivedData.category);
            if (matchedCategory) {
                selectedCategory.value = matchedCategory.id;
            } else {
                selectedCategory.value = '';
            }
        }
    } catch (error) {
        console.error('Error fetching categories:', error);
    }
};
EventBus.on('activateScan', () => {
    buttonClicked.value = false;
});
onMounted(() => {
    fetchCategories();
    EventBus.on('dataReceived', data => {
        console.log('Received data:', data);
        Object.assign(receivedData, data);

        if (data.category) {
            const matchedCategory = categories.value.find(category => category.slug === data.category);
            if (matchedCategory) {
                selectedCategory.value = matchedCategory.id;
            } else {
                selectedCategory.value = '';
            }
        } else {
            selectedCategory.value = '';
        }

        buttonClicked.value = false;
    });
});
</script>

<style>
.bold-pound::before {
    content: "\00A3";
    font-weight: bold;
}

button[disabled] {
    opacity: 0.9;
}
</style>