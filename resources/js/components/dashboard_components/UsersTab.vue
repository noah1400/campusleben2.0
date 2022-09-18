<script>
    import axios from 'axios';
import LaravelVuePagination from 'laravel-vue-pagination';
export default {
    components: {
        'Pagination': LaravelVuePagination,
    },
    data() {
        return {
            laravelData: {},
        }
    },

    created() {
        this.getResults();
    },

    methods: {
        getResults(page = 1) {
            let vm = this;
            axios.get('/admin/api/users?page=' + page)
                .then(response => {
                    vm.laravelData = response.data;
                }).
                catch(error => {
                    console.log(error);
                });

        },
        viewUser(id) {
        }
    }
}
</script>


<template>
    <div  class="max-h-96">
        <div class="px-4 sm:px-6 lg:px-8 ">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">Users</h1>
                    <p class="mt-2 text-sm text-gray-700">Liste aller Benutzer</p>
                </div>
            </div>
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                                            Name</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                                            <Pagination :data="laravelData" @pagination-change-page="getResults" />
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="person in laravelData.data" :key="person.id">
                                        <td
                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                            {{ person.name }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ person.email }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span v-if="person.isAdmin == 1"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Admin </span>
                                            <span v-if="person.isAdmin == 0"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Member </span>
                                        </td>
                                        <td
                                            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8">


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
</template>

