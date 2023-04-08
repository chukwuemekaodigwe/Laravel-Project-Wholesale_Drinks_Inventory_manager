<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const products = defineProps({
    'products':{
        default: {}
    }
})
let i = 0
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h3 class="font-semibold"> Products</h3>
        </template>

        <div class="py-12">
            <div
                class="pt-0 max-w-6xl bg-gray-100 rounded-b-none rounded-l-none mx-auto bg-white shadow-lg rounded-l-xl rounded-r-xl md:mx-auto sm:mx-5">
                <div
                    class=" p-3 p-b-0 mb-6 container-fluid border-b-2 border-gray flex flex-row justify-between items-center col-span-2">
                    <h3 class="font-bold text-xl uppercase text-gray-900 p-0 mx-2">
                        Products
                    </h3>
                    <div class="flex flex-row justify-end">
                        <button :href="route('products')"
                            class="min-w-fit px-4 py-2 text-white  rounded-xl bg-violet-500 hover:bg-blue-600 active:bg-violet-700 focus:outline-none focus:ring focus:ring-violet-300 ...">
                            Add New
                        </button>
                    </div>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th></th>
                                <th scope="col" class="px-6 py-3">
                                </th>
                                <th scope="col" class="px-6 py-3">
                                Product name
                            </th>

                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>
                                <!--
                                        <th scope="col" class="px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                v-for="product in products.products" :key="product.id">
                                <th class="px-6 py-6">
                                    {{   }}
                                </th>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <img :src="`@/${product.image_url}`" alt="" srcset="" class="w-20 ring-3 ring-bg-gray-900">
                                </th>
                                <th class="px-6 py-4 font-medium uppercase text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ product.name }}
                                </th>

                                <td class="px-6 py-4 text-gray-900 whitespace-nowrap uppercase dark:text-white">
                                    {{ product.category }}
                                </td>

                                <td class="px-6 py-4 text-blue-500">
<a :href="route(`productEdit`,`${product.id}`)">Edit</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>