
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import alertMsg from '@/Components/alertMsg.vue'
import products from '@/data';
const form = useForm({
    quantity: '',
    brand: '',
   
});

const props = defineProps({
    'edit': {
        default: false,
        type: Boolean
    },
    'product': {
        default: {},
        type: Object
    }
})

const categories = [
    {
        'id': 1,
        'name': 'guinness'
    },
    {
        'id': 2,
        'name': 'hero'
    },
    {
        'id': 3,
        'name': 'nbl'
    },

]

const success = ref(false)
const error = ref(false)
const warning = ref(false)

const alertmsg = ref('')

function submit() {

        if (!props.edit) {
            form.post('/newEmpties', {
              
                onSuccess: () => form.reset(),
            })

            success.value = true
            alertmsg.value = 'Added Successfully'

    }
}
</script>

<template>
    <Head title="New Empties" />

    <AuthenticatedLayout>
        <template #header>
            <h3 class="font-semibold"> New Empties</h3>
        </template>

        <div class="py-12">
            <alertMsg :success="success" :error="error" :warning="warning" :message="alertmsg" />
            <div
                class="pt-0 max-w-xl bg-gray-100 rounded-b-none rounded-l-none mx-auto bg-white shadow-lg rounded-l-xl rounded-r-xl md:mx-auto sm:mx-auto">
                <div
                    class=" p-3 p-b-0 mb-6 container-fluid border-b-2 border-gray flex flex-row justify-between items-center col-span-2">
                    <h3 class="font-bold text-xl uppercase text-gray-900 p-0 mx-2">
                        New Empty
                    </h3>
                    <div class="flex flex-row justify-end">
                        <button
                            class="hidden min-w-fit px-4 py-2 text-white  rounded-xl bg-violet-500 hover:bg-blue-600 active:bg-violet-700 focus:outline-none focus:ring focus:ring-violet-300 ...">
                            Products List
                        </button>
                    </div>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">

                    <form @submit.prevent="submit" enctype="multipart/form-data">
                        <div class="py-4 px-2">
                            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Brand</label>


                            <select id="countries" v-model="form.brand"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Choose a Brand</option>
                                <option class="capitalize" v-for="item in categories" :key="item.id"> {{ item.name }}
                                </option>

                            </select>
                            <p class="text-xs text-red-700" v-if="form.errors.name">{{ form.errors.category }}
                            </p>
                        </div>
                        <div class="py-4 px-2">

                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Quantity
                            </label>

                            <input type="number" id="name" v-model="form.quantity"
                                class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <p class="text-xs text-red-700" v-if="form.errors.quantity">{{ form.errors.quantity }}
                            </p>

                        </div>

                        <div class="py-4 px-2">

                            <button type="submit" :disabled="form.processing"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                {{ form.processing ? 'Saving' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
