<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

//import constProducts from '../../data'

const props = defineProps({
    'stocks': {
        default: {}
    }
})
const saveProduct = props.stocks.data

let profit = 0; let ttl = 0

const products = reactive(saveProduct)
function toBatch(date) {
    router.get(`/salesReport/${date}`)
}

function deleteStock(batch_no){
    if(confirm('Do you really wish to delete this batch, NOTE you must have to make the changes on the stock records to balance the system. NB: this is irrevocable')){
    router.delete(`/sales/delete/${batch_no}`)

    }
}
</script>

<template>
    <Head title="Sales Report" />

    <AuthenticatedLayout>
        <template #header>
            <h3 class="font-semibold"> General Sales Report</h3>
        </template>

        <div class="py-12">
            <div
                class="pt-0 max-w-6xl bg-gray-100 rounded-b-none rounded-l-none mx-auto bg-white shadow-lg rounded-l-xl rounded-r-xl md:mx-auto sm:mx-5">
                <div
                    class=" p-3 p-b-0 mb-6 container-fluid border-b-2 border-gray flex flex-row justify-between items-center col-span-2">
                    <h3 class="font-bold text-xl uppercase text-gray-900 p-0 mx-2">
                          Sales Report
                    </h3>
                    <div class="flex flex-row justify-end">
                        <button
                            class="hidden min-w-fit px-4 py-2 text-white  rounded-xl bg-violet-500 hover:bg-blue-600 active:bg-violet-700 focus:outline-none focus:ring focus:ring-violet-300 ...">
                            Add New
                        </button>
                    </div>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Date In
                                </th>

<!-- 
                            <th scope="col" class="px-6 py-4 xs:max-w-md sm:max-w-md">
                                   No of Stocks
                                </th>
    -->
                                <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in products" 
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer">
                             
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ new Date(product.dateIn).toDateString() }}
                                </th>
<!-- 
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ product.items }}
                                </th>
                             -->
                                <td class="px-6 py-4 flex justify-between">
                                        <a href="#" @click="toBatch(product.dateIn)"
                                            class="font-medium  dark:text-blue-500 text-green-500">View</a>
                                            
                                            <a href="#"
                                            class="font-medium  dark:text-red-600 text-red-600" @click="deleteStock(product.dateIn)">Delete</a>
                                    </td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-200">
                                <td colspan="3" class="px-6 py-5 text-center">
<button class="px-2 py-2 bg-red-600 w-40 text-white rounded hover:bg-red-800 uppercase" @click="router.get(stocks.prev_page_url)">Prev</button>
<button class="px-2 py-2 bg-blue-600 w-40 text-white rounded hover:bg-blue-800 uppercase" @click="router.get(stocks.next_page_url)">Next</button>
</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout></template>

