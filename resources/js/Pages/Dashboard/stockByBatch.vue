<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

//import constProducts from '../../data'

const props = defineProps({
    'stocks': {
        default: {}
    },
    'batch': {
        default: ''
    }
})
const saveProduct = props.stocks
console.log(props.stocks)
const products = reactive(saveProduct)

function profit(qty, selling, cost) {
    return (selling - cost) * qty
}

const readonly = ref(false)

function back(){
    router.get('/stocksReport')
}
</script>

<template>
    <Head title=" Stock Report" />

    <AuthenticatedLayout>
        <template #header>
            <h3 class="font-semibold"> Stocks Report</h3>
        </template>

        <div class="py-12 mb-2">
            <div
                class="pt-0 overflow-x-auto bg-gray-100 rounded-b-none rounded-l-none mx-auto bg-white shadow-lg rounded-l-xl rounded-r-xl md:mx-auto sm:mx-5">
                <div
                    class=" p-3 p-b-0 mb-6 container-fluid border-b-2 border-gray flex flex-row justify-between items-center col-span-2">
                    <h3 class="font-bold text-xl uppercase text-gray-900 p-0 mx-2">
                        Stocks Report for {{ props.batch }}
                    </h3>
                    <div class="flex flex-row justify-end">
                        <button class="px-4 py-1 focus:ring-violet-700 outline-0 text-white text-medium text-uppercase 
                                            font-medium bg-violet-600 hover:bg-violet-900 focus:bg-violet-900 rounded"
                            @click="back">
                        Back
                    </button>
                    <!-- <button
                        class="px-4 py-1 focus:ring-red-700 outline-0 text-white text-medium text-uppercase font-medium bg-red-600 hover:bg-red-900 focus:bg-red-900 rounded"
                        @click="next">
                            Next
                        </button> -->

                    </div>
                </div>

                <div class="relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Date Created
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Product name
                                </th>
                                <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm:max-w-md">
                                   Total Qty
                                </th>
                                <!-- <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm:max-w-md">
                                    Qty Sold
                                </th>
                                <th scope="col" class="px-6 py-4 xs:max-w-md sm:max-w-md">
                                         Total Remaining
                                    </th>  -->
                                <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm::max-w-md">
                                    Cost Price
                                </th>

                                <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm:max-w-md">
                                    Selling Price
                                </th>
                                <!-- <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm:max-w-md">
                                        Purchase Total
                                    </th>-->
                                 
                                <th scope="col" class="px-6 py-3">
                                    Last Updated
                                </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ new Date(product.created_at).toLocaleDateString('en-gb') }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ product.name }}
                                </th>
                                
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ product.total_qty }}
                                </td>
<!-- 
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ product.qtysold }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ product.total_qty - product.qtysold }}
                                </td> -->

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ product.cost_price }}
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ product.selling_price }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ new Date(product.updated_at).toLocaleDateString('en-gb') }}
                                </td>
                                <td class="px-6 py-4 p-2" :class="product.status ? 'text-red-500' : 'text-green-500'">
                                    {{ product.status ? 'Sold' : 'In Stock' }}
                                </td>

                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="px-6 py-5 text-left bg-gray-200">

                                </td>
                                <td colspan="4" class="px-6 py-5 text-right bg-gray-200">

                                </td>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

