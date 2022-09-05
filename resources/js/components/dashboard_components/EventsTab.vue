<script>
export default {
    components: {
        Pagination: LaravelVuePagination,
        TransitionRoot,
        TransitionChild,
        Dialog,
        DialogPanel,
        DialogTitle,
        NewEventForm,
        EditEventForm,
        DeleteEventModal
    },
    data() {
        return {
            laravelData: {},
            editEventId: null,
            newEvent: false,
            editEvent: false,
            showEvents: true,
            toDeleteId: -1,
        };
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults(page = 1) {
            axios.get('/admin/api/events?page=' + page)
                .then(response => {
                    this.laravelData = response.data;
                });
        },
        setEditID(id) {
            this.editEventId = id;
            this.editEvent = true;
            this.newEvent = false;
            this.showEvents = false;
        },
        closeCreate() {
            this.newEvent = false;
            this.showEvents = true;
            this.getResults();
        },
        closeEdit() {
            this.editEvent = false;
            this.showEvents = true;
            this.getResults();
        },
        openDeleteModal(id) {
            this.toDeleteId = id;
        },
    },
};
</script>

<script setup>
import axios from "axios";
import LaravelVuePagination from "laravel-vue-pagination";
import EditEventForm from "./EditEventForm.vue";
import NewEventForm from "./NewEventForm.vue";
import { ref } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import DeleteEventModal from "../Events/DeleteEventModal.vue";

const deleteModal = ref(false);
</script>

<template>
    <div v-if="showEvents" :key="showEvents">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">Events</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Liste aller Veranstaltungen
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                        @click="
    newEvent = true;editEvent = false;showEvents = false;
                        ">
                        Neue Veranstaltung
                    </button>
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
                                            Name
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Start Datum
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Enddatum
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Öffentlich
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                                            <span class="sr-only">Bearbeiten</span>
                                            <Pagination :data="laravelData" @pagination-change-page="
                                                getResults
                                            " />
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="event in this.laravelData.data" :key="event.id">
                                        <td
                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                            {{ event.name }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ event.start_date }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ event.end_date }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span v-if="event.public == 1"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Öffentlich
                                            </span>
                                            <span v-if="event.public == 0"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Privat
                                            </span>
                                        </td>
                                        <td
                                            class="flex flex-col relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900"
                                                @click="setEditID(event.id)">Bearbeiten<span class="sr-only">, {{
                                                        event.name
                                                }}</span></a>
                                            <a href="#" class="text-red-600 hover:text-red-900"
                                                @click="deleteModal=true;openDeleteModal(event.id)">Löschen<span class="sr-only">, {{
                                                        event.name
                                                }}</span></a>
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
    <div v-if="newEvent" :key="newEvent">
        <button type="button"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
            @click="newEvent = false;editEvent=false;showEvents=true">
            Zurück
        </button>
        <NewEventForm @close_create="closeCreate"></NewEventForm>
    </div>
    <div v-if="editEvent" :key="editEvent">
        <button type="button"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
            @click="editEvent = false;newEvent = false;showEvents = true">
            Zurück
        </button>
        <EditEventForm @close_edit="closeEdit" :event_id="editEventId"></EditEventForm>
    </div>

    <DeleteEventModal :show="deleteModal" :event_id="toDeleteId" @close="deleteModal=false;toDeleteId=-1" @deleted="deleteModal=false;toDeleteId=-1;getResults()"></DeleteEventModal>
</template>
