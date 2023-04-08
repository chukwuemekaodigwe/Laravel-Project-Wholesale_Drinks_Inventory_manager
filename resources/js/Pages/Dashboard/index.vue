
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, ref, defineComponent } from 'vue';


const props = defineProps(['products']);
const pro = (props.products)
let products = reactive(pro)
//console.log('products');
const searchkey = ref('')
const show = ref(true)
function search() {
    
    const term = searchkey.value
    show.value = false
    if (term) {

        products = products.filter((el, index) => {
            return el.name.toLowerCase().includes(term.toLowerCase())
        })

    } else {
        products = props.products

    }
    show.value = true
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="py-4 my-4">
                    <input type="search" v-model="searchkey" @keyup="search"
                        class="px-2 py-1 text-sm text-gray-900 border border-blue-400 focus:border-blue-100 placeholder:text-gray-400 dark:text-white dark:bg-gray-100 w-full block rounded"
                        placeholder="Search for Products">
                </div>
                <div class="flex flex-row flex-wrap content-center items-center justify-space">
                    <div v-for="product in products" :key="product.id" v-if="show"
                        class="w-36 h-32 bg-white relative m-5 dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">
                        <div class="absolute bottom-0 w-full">
                            <img :src="product.image_url" alt="" srcset="">
                            <div class="px-3 py-0 bg-gray-900 font-medium text-center">
                                <p class="text-white uppercase"> {{ product.name }}</p>
                            </div>
                            <div class="flex flex-row justify-between">
                                <p class="text-center p-0 bg-green-500 w-full text-sm">Qty: {{ product.quantity -
                                    product.sold }}</p>
                                <p class="text-center p-0 bg-blue-700 w-full text-sm">&#8358; {{ product.selling_price }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
