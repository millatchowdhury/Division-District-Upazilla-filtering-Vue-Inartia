<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";

const { props } = usePage();
const query = ref(props.query);
const suggestions = ref([]);

const form = useForm({});

const fetchSuggestions = async () => {
    if (query?.value?.length > 2) {
        // Make a request to the server-side endpoint
        const response = await useForm().post('/search/suggest', {
            query: query.value,
        });

        // Update the suggestions based on the response
        suggestions.value = response.data;
    } else {
        suggestions.value = [];
    }
};
</script>

<template>
    <div>
        <input v-model="query" @input="fetchSuggestions" />
        <ul v-if="suggestions.length">
            <li v-for="suggestion in suggestions" :key="suggestion.id">
                {{ suggestion.title }}
            </li>
        </ul>
    </div>
</template>