<template>
    <div v-if="showLocations" :key="showLocations">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">Locations</h1>
                    <p class="mt-2 text-sm text-gray-700">List aller Standorte (Cafes)</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <button type="button"
                    @click="showLocations = false; newLocation = true; editLocation = false;"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Hinzufügen</button>
                </div>
            </div>
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                            Name</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Slug</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Clickable</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="location in locations" :key="location.slug">
                                        <td
                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {{ location.name }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ location.slug }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span v-if="location.clickable == 1"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Ja
                                            </span>
                                            <span v-if="location.clickable == 0"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Nein
                                            </span>
                                        </td>
                                        <td
                                            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="newLocation" :key="newLocation">
        <button type="button"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
            @click="newLocation = false;editLocation=false;showLocations=true">
            Zurück
        </button>
        <NewLocationForm @close_create="closeCreate"></NewLocationForm>
    </div>
    <div v-if="editLocation" :key="editLocation">
        Test
    </div>
</template>

<script>
import NewLocation from '../Locations/NewLocationForm.vue';

export default {
    data() {
        return {
            showLocations: true,
            editLocation: false,
            newLocation: false,
            locations: [],
        };
    },
    components: { NewLocation },
    created() {
        this.getLocations();
    },
    methods: {
        closeCreate() {
            this.newLocation = false;
            this.showLocations = true;
            this.editLocation = false;
            this.getLocations();
        },
        getLocations() {
            axios.get('/admin/api/locations').then((response) => {
                this.locations = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
        }
    },
}
</script>
