<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

//import constProducts from '../../data'
const props = defineProps(['products'])

const saveProduct = props.products
const products = reactive(saveProduct)


const dateIn = ref('')

//console.log(saveProduct)
function save() {
  console.log(dateIn)
    router.post('/saveUpdate', { 'products': products, 'dateIn': dateIn.value })
}
</script>

<template>
    <Head title="Stock Keeping" />

    <AuthenticatedLayout>
        <template #header>
            <h3 class="font-semibold"> Stocks</h3>
        </template>

        <div class="py-12">
            <form method="post" @submit.prevent="save">
            <div
                class="pt-0 max-w-7xl bg-gray-100 rounded-b-none rounded-l-none mx-auto bg-white shadow-lg rounded-l-xl rounded-r-xl md:mx-auto">
                <div
                    class="sticky top-0 z-10 bg-white dark:bg-gray-900 p-3 p-b-0 mb-6 container-fluid border-b-2 border-gray flex flex-row justify-between items-center col-span-2">
                    <h3 class="font-bold text-xl uppercase text-gray-900 dark:text-white p-0 mx-2">
                        StockTaking
                    </h3>
                    <div class="flex py-2 px-2 max-w-2xl">

                        <label for="name" class="block m-2 text-sm font-medium text-gray-900 dark:text-white">
                             Date
                        </label>

                        <input type="date" id="small-input" v-model="dateIn" required
                            class="block w-full px-2 py-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>

                    <div class="flex flex-row justify-end">
                        <button type="submit"
                            class="min-w-fit px-2 py-1 text-white text-small rounded bg-blue-900 hover:bg-blue-600 active:bg-violet-700 focus:outline-none focus:ring focus:ring-violet-300 ...">
                            Save
                        </button>
                    </div>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Product name
                                    </th>
                                    <th scope="col" class="px-6 py-4 xs:max-w-md sm:max-w-md">
                                        Expected In Stock
                                    </th>

                                    <th scope="col" class="px-6 py-4 xs:max-w-md sm:max-w-md">
                                    Remaining
                                </th>

                                    <th scope="col" class="px-6 py-4 xs:max-w-md sm:max-w-md">
                                        Quantity Sold
                                    </th>

          <!---                         <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm::max-w-md">
                                        Cost Price
                                    </th>

                                    <th scope="col" class="px-6 py-4 whitespace-nowrap xs:max-w-md sm:max-w-md">
                                        Selling Price
                                    </th>
               
                                 <th scope="col" class="px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th> -->
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="product in products"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                                        {{ product.name }}
                                    </th>
                                    <td class="px-6 py-2 text-gray-900 dark:text-white">
                                        {{ product.exp_qty }}
                                    </td>

                                    <td class="px-6 py-2">
                                        <input type="number" step=".001" id="small-input" v-model="product.quantity"
                                            :max="(product.exp_qty)"
                                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <small class="text-blue-600">Max : {{ product.exp_qty }}</small>
                                </td>
                                    <td class="px-6 py-2 text-gray-900 dark:text-white">
                                        {{ product.qty = (!product.quantity && product.quantity !== 0) ? 0 :
                                            (product.exp_qty - product.quantity)  }}
                                        <input type="hidden" v-model="product.qty">
                                    </td>
                                    <!---<td class="px-6 py-2 text-gray-900 dark:text-white">
                                        {{ product.cost_price }}
                                    </td>

                                    <td class="px-6 py-2 text-gray-900 dark:text-white">
                                        {{ product.selling_price }}
                                    </td>

                                     <td class="px-6 py-4 text-right">
                                                <a href="#"
                                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                            </td> -->
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="px-6 py-5 text-center bg-gray-200">
                                        <button type="submit"
                                            class="px-6 py-2 focus:ring-red-700 outline-0 text-white text-medium text-uppercase font-medium bg-red-600 hover:bg-red-900 focus:bg-red-900 rounded">
                                            Save
                                        </button>
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

