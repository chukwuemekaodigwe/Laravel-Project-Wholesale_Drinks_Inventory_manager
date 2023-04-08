<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

//import constProducts from '../../data'

const props = defineProps({
    'stocks': {
        default: {}
    },
    'dateIn': {
        default: ''
    }
})

let totalprofit = 0; let ttl = 0; let ttl_sold = 0;

const saveProduct = props.stocks
console.log(props.dateIn)
const products = reactive(saveProduct)

function profit(qty, selling, cost) {
    return (selling - cost) * qty
}

const readonly = ref(false)

function back(){
    router.get('/salesReport')
}
</script>

<template>
    <Head title="Sales Report" />

    <AuthenticatedLayout>
        <template #header>
            <h3 class="font-semibold"> Sales Report for {{ new Date(props.dateIn).toLocaleDateString('en-gb') }}</h3>
        </template>

        <div class="py-12 mb-2">
            <div
                class="pt-0 overflow-x-auto bg-gray-100 rounded-b-none rounded-l-none mx-auto bg-white shadow-lg rounded-l-xl rounded-r-xl md:mx-auto sm:mx-5">
                <div
                    class=" p-3 p-b-0 mb-6 container-fluid border-b-2 border-gray flex flex-row justify-between items-center col-span-2">
                    <h3 class="font-bold text-xl uppercase text-gray-900 p-0 mx-2">
                        Sales Report for {{ new Date(props.dateIn).toLocaleDateString('en-gb') }}
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
                                    Date 
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Product name
                                </th>
                                <!-- <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm:max-w-md">
                                   Total Qty
                                </th> -->
                                <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm:max-w-md">
                                    Qty Sold
                                </th>
                                <!-- <th scope="col" class="px-6 py-4 xs:max-w-md sm:max-w-md">
                                         Cost Price
                                    </th> 
                             
                                <th scope="col" class="px-6 py-4 xs:max-w-md sm:max-w-md">
                                         Selling Price
                                    </th>  -->
                                <th scope="col" class="px-6 py-4 text-right whitespace-nowrap xs:max-w-md sm::max-w-md">
                                    Gross Total
                                </th>

                                <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm:max-w-md text-right">
                                    Profit
                                </th>
                                <!-- <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm:max-w-md">
                                        Purchase Total
                                    </th>-->
                                 
                                <!-- <th scope="col" class="px-6 py-3">
                                    Last Updated
                                </th> -->
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ new Date(props.dateIn).toLocaleDateString('en-gb') }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ product.name }}
                                </th>
                                
                                <!-- <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ product.total_qty }}
                                </td> -->

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ product.qtysold }} <span class="hidden"> {{ ttl_sold = parseInt(ttl_sold) + parseInt(product.qtysold) }}</span>
                                </td>
                                <!-- <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ product.costprice }}
                                </td>

                              

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ product.sellingprice }}
                                </td> -->
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white text-right">
                                    &#8358;  {{  a = product.earning }}
                                    <span class="hidden">{{ ttl = parseInt(ttl) +
                                            parseInt(a) }}</span>
                                </td>
                                <th class="px-6 py-4 p-2 text-blue-800 text-lg text-right">
                                 &#8358; {{  b = product.profit }}
                                 <span class="hidden">{{ totalprofit = parseInt(totalprofit) +
                                            parseInt(b) }}</span>
                               
                                </th>

                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                    <td colspan="2" class="px-6 py-5 text-center bg-gray-200">

                                    </td>
                                    <td colspan="1"
                                            class="px-6 py-4 font-medium text-lg text-gray-900 dark:bg-blue-900 dark:text-white bg-gray-200">
                                             {{ ttl_sold.toLocaleString('en-gb') }}
                                        </td>
                                    <td colspan="1"
                                        class="px-6 py-4 whitespace-nowrap font-medium text-lg text-right text-gray-900 dark:bg-blue-900 dark:text-white bg-blue-200">
                                        &#8358; {{ ttl.toLocaleString('en-gb') }}
                                    </td>
                                    <td colspan="1"
                                        class="px-6 py-4 whitespace-nowrap font-medium text-lg text-gray-900 dark:bg-green-900 dark:text-white text-right bg-green-200">
                                        &#8358; {{ totalprofit.toLocaleString('en-gb') }}
                                    </td>
                                </tr>                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

