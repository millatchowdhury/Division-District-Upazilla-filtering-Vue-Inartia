<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { router } from '@inertiajs/vue3';

//get data from controller 
const props = defineProps({
    divisions:Array,
    districts:Array,
    upazillas:Array
});

// v-model data get 
const form = useForm({
    divisions:'', // When will select division then assign id here
    districts: props?.districts ?? '', 
    upazillas: props?.upazillas ?? '', 
});

// const divisonFilters = () => {
//     router.visit(
//         route('filter.create'),  //used name route
//         {
//             data:{'divisions': form.divisions}, // send data to controller
//             only:['districts'], // get district from controller
//             preserveState:true, // save data to browser
//         } 
//     );
// }

const divisonFilters = () => {
    router.visit(
        route('filter.create'),{
            data:{'divisions': form.divisions},
            only:['districts'],
            preserveState:true,
        }
    )
}

const districtFilters = () => {
    router.visit(
        route('filter.create'),{
            data:{'districts' : form.districts},
            only:['upazillas'],
            preserveState:true
        }
    )
}




// const divisonFilters = ()=>{
//     router.visit(
//         route('filter.create'),
//         {
//             only: ['districts'],
//             preserveState: true,
//             data:{'divisions':form.divisions},
//             onSuccess: (page)=>{
//             // Example: Display a success message
//                 // console.log(page.props.districts);
//                 console.log('Navigation successful!');
//             // Additional code to update the UI can go here
//             },
//             error(msg){
//                 console.log(msg);
//             }
//         }
//     );
// }



const submit = () => {
    // form.post(route("blogs.store"));
    form.post(route("blogs.store"), {
        onError: (errors) => {
            // Handle errors returned from the server
            console.log(errors);
        },
        onFinish: (response) => {
            console.log(response);
            // Handle what should happen after the form submission
        },
    });
};

const onFileSelected = (event) => {
    // const fileInput = event.target;
    form.product_image = event.target.files[0];
};

</script>

<template>
    

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Blog Create
            </h2>
        </template>

        <div class="py-12">
            <h1>{{ props.upazillas }}</h1>
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" enctype="multipart/form-data">

                            <div class="my-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Division</label>
                                <select @change="divisonFilters" v-model="form.divisions" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Choose a country</option>
                                    <template v-for="division in divisions">
                                        <option :value="division?.id">{{ division?.name }}</option>
                                    </template>
                                </select>
                            </div>

                            <div class="my-6" @change="districtFilters" v-show="districts?.length">
                                <label for="district"  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select District</label>
                                <select id="districts" v-model="form.districts" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Choose a country</option>
                                    <template v-for="district in districts">
                                        <option :value="district?.id">{{district?.name}}</option>
                                    </template>
                                </select>
                            </div>

                            <div class="my-6" v-show="upazillas?.length">
                                <label for="district"  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select upazilla</label>
                                <select id="districts" v-model="form.upazillas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Choose a country</option>
                                    <template v-for="upazilla in upazillas">
                                        <option :value="upazilla?.id">{{upazilla?.name}}</option>
                                    </template>
                                </select>
                            </div>

                            <PrimaryButton
                                type="submit"
                            >
                                Submit
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>



