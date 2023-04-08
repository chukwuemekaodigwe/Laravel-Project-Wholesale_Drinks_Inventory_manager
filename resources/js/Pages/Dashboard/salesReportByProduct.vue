<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { onMounted, reactive, ref } from 'vue';
import axios from 'axios';


//import constProducts from '../../data'
const props = defineProps({
    'stocks': {},
    'dates': {}
})
let profit = 0; let ttl = 0; let ttl_sold = 0;

const ready = ref(true);

const dates = reactive({
    'from': props.dates[0],
    'to': props.dates[1]
})

const saveProduct = props.stocks
let products = reactive(saveProduct)

console.log(products)

async function getNewRecord() {

    //const dates = {'to':to.value, 'from': from.value}

    await axios.post('/salesReportByProduct', {
        dates
    })
        .then((res) => {
            ready.value = false
            //console.log(products)
            products = res.data
            console.log(products)

            profit = 0
            ttl = 0
            ttl_sold = 0
            ready.value = true
            //console.log(res.data)
        })
        .catch((err) => {
            console.log({ 'err': err })
        })
}

//console.log(saveProduct)
function save() {
    console.log(dateIn)
    router.post('/saveUpdate', { 'products': products, 'dateIn': dateIn.value })
}
</script>

<template>
    <Head title="Sales Report By Date" />

    <AuthenticatedLayout>
        <template #header>
            <h3 class="font-semibold"> Sales Report By Date</h3>
        </template>

        <div class="py-12">
            <form method="post" @submit.prevent="save">
                <div
                    class="pt-0 max-w-7xl bg-gray-100 rounded-b-none rounded-l-none mx-auto bg-white shadow-lg rounded-l-xl rounded-r-xl md:mx-auto">
                <div
                    class="sticky top-0 z-10 bg-white dark:bg-gray-900 p-3 p-b-0 mb-6 container-fluid border-b-2 border-gray flex flex-row justify-between items-center col-span-2">
                        <h3 class="font-bold text-xl uppercase text-gray-900 dark:text-white p-0 mx-2">
                            Sales Report By Date
                        </h3>
                        <div class="flex flex-col md:flex-row justify-center items-center">
                            <div class="flex py-2 px-2 max-w-2xl sm:max-w-md">

                                <label for="name" class="block m-2 text-sm font-medium text-gray-900 dark:text-white">
                                    From
                                </label>

                                <input type="date" id="small-input" v-model="dates.from" @change="getNewRecord"
                                    class="block w-full px-2 py-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>

                            <div class="flex py-2 px-2 max-w-2xl">

                                <label for="name" class="block m-2 text-sm font-medium text-gray-900 dark:text-white">
                                    To
                                </label>

                                <input type="date" id="small-input" v-model="dates.to" @change="getNewRecord"
                                    class="block w-full px-2 py-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                            <!-- <button type="button" @click="getNewRecord"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Get</button> -->
                        </div>
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-4 xs:max-w-md sm:max-w-md">
                                    S/N
                                </th>

                                    <th scope="col" class="px-6 py-3">
                                        Product name
                                    </th>
                                   
                                    <th scope="col" class="px-6 py-4 xs:max-w-md sm:max-w-md">
                                        Quantity Sold
                                    </th>
                               
                                <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm::max-w-md text-center">
                                    Gross Earnings
                                </th>

                                    <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm:max-w-md text-center">
                                        Net Profit
                                    </th>

                                    <!-- -->

                                    <!-- <th scope="col" class="px-6 py-3">
                                                                <span class="sr-only">Edit</span>
                                                            </th> -->
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(product, index) in products" v-if="ready"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                                        {{ index + 1 }}
                                    </th>

                                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                                        {{ product.name }}
                                    </th>

                                    <!-- <td class="px-6 py-2 text-gray-900 dark:text-white">
                                        {{ product.totalqty }}
                                    </td> -->
                                    <th class="px-6 py-2 text-gray-900 dark:text-white text-center">
                                        {{ product.qtysold }} <span class="hidden">
                                            {{ ttl_sold = parseInt(ttl_sold) + parseInt(product.qtysold) }}
                                        </span>
                                    </th>
                                    <!-- <td class="px-6 py-2 text-gray-900 dark:text-white">
                                        {{ product.totalqty - product.sold }}
                                    </td> -->
                                    <td class="px-6 py-2 text-gray-900 text-center dark:text-white">
                                        &#8358; {{ product.earning.toLocaleString('en-gb') }} <span class="hidden">{{ ttl = parseInt(ttl) +
                                            parseInt(product.earning) }}</span>
                                    </td>

                                    <td class="px-6 py-2 text-gray-900 dark:text-white text-center">
                                        &#8358; {{ product.profit.toLocaleString('en-gb') }} <span class="hidden">
                                            {{ profit = parseInt(profit) +
                                                parseInt(product.profit) }}</span>
                                    </td>

                                    <!-- <td class="px-6 py-4 text-right">
                                                                <a href="#"
                                                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                            </td> -->
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="px-6 py-5 text-center bg-gray-200">

                                    </td>
                                    <td colspan="1"
                                            class="px-6 py-4 font-medium text-lg text-center text-gray-900 dark:bg-blue-900 dark:text-white bg-gray-200">
                                             {{ ttl_sold.toLocaleString('en-gb') }}
                                        </td>
                                    <td colspan="1"
                                            class="px-6 py-4 font-medium text-lg text-center text-gray-900 dark:bg-blue-900 dark:text-white bg-blue-200">
                                            &#8358; {{ ttl.toLocaleString('en-gb') }}
                                        </td>
                                        <td colspan="1"
                                            class="px-6 py-4 font-medium text-lg text-gray-900 dark:bg-green-900 dark:text-white text-center bg-green-200">
                                            &#8358; {{ profit.toLocaleString('en-gb') }}
                                        </td>
                                </tr>
                            </tfoot>

                        </table>

                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

