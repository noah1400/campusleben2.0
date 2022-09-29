<script>
import { Switch } from '@headlessui/vue';
import NewEventErrorNotif from './NewEventErrorNotif.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { ref } from 'vue';
export default {
    components: {
        Switch,
        NewEventErrorNotif,
        Datepicker,
    },
    props: {
        event_id: {
            type: Number,
            required: true,
        },
    },
    emits: ['close_edit'],
    methods: {
        getEvent() {
            let vm = this;
            axios.get('/admin/api/event/' + vm.event_id)
                .then(response => {
                    vm.event = response.data;

                    vm.event_name = vm.event.name;
                    vm.event_description = vm.event.description;
                    vm.event_location = vm.event.location;
                    vm.event_start_date = vm.event.start_date;
                    vm.event_end_date = vm.event.end_date;
                    vm.event_pre_regist = (vm.event.pre_registration_enabled == 1) ? true : false;
                    vm.event_closed = (vm.event.closed == 1) ? true : false;
                    vm.event_limit = vm.event.limit;
                    vm.event_preview_image = vm.event.preview_image;
                    vm.event_public = (vm.event.public == 1) ? true : false;
                    vm.previewImageSrc = vm.event.preview_image;
                });
        },
        submitEdit() {
            let formData = new FormData(document.getElementById("eventForm"));
            let vm = this;
            this.loader = true;
            axios.post('/admin/events/update/' + vm.event_id, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(response => {
                    vm.loader = false;
                    vm.$emit('close_edit');

                }).catch(error => {
                    let errors = error.response.data.errors;
                    console.log(error);
                    vm.error_messages = [];
                    for (let pair of Object.entries(errors)) {
                        console.log(pair[0] + ", " + pair[1]);
                        vm.error_messages.push(pair[1]);
                    }
                    vm.loader = false;
                    vm.error = true;
                    window.scrollTo(0, 0);
                });
        },
        onFileChange(e) {
            this.previewImage = true;
            this.previewImageSrc = URL.createObjectURL(e.target.files[0]);
            console.log(this.previewImageSrc);
        },
    },
    data(){
            return {
                event: ref([]),
                loader: ref(false),
                hasLimit: ref(false),
                error: ref(false),
                error_messages: [],
                previewImageSrc: ref(''),
                previewImage: ref(false),

                event_name: ref(''),
                event_description: ref(''),
                event_location: ref(''),
                event_start_date: ref(''),
                event_end_date: ref(''),
                event_pre_regist: ref(false),
                event_closed: ref(false),
                event_limit: ref(0),
                event_preview_image: ref(''),
                event_public: ref(false),
            };
        },
    created() {
        this.getEvent();
    },

}
</script>

<template>
    <AddPostsForm :event_id="event_id" class="mt-4"></AddPostsForm>
    <form ref="eventForm" id="eventForm" class="space-y-8 divide-y divide-gray-200 mt-5">
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div>
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Event bearbeiten
                    </h3>
                </div>
                <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Event
                            Name</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg rounded-md shadow-sm">
                                <input :value="event_name" type="text" name="name" id="name" autocomplete="name"
                                    class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="description"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Beschreibung</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <textarea id="description" name="description" rows="3" v-model="event_description"
                                class="h-64 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            <p class="mt-2 text-sm text-gray-500">
                                Um was geht es in diesem Event?! Wer kommt?
                                Eintritt?!
                            </p>
                            <p class="mt-2 text-sm text-gray-500">
                                <a class="text-indigo-600 hover:text-indigo-500"
                                    href="https://www.markdownguide.org/basic-syntax/">Markdown Syntax</a><br>
                                <a class="text-indigo-600 hover:text-indigo-500"
                                    href="https://www.markdownguide.org/cheat-sheet/">Cheat Sheet</a><br>
                                    <a class="text-indigo-600 hover:text-indigo-500"
                                    href="https://commonmark.org/help/tutorial/index.html">Tutorial</a><br>
                                <span class="text-red-600">Noch nicht alles implementiert</span>
                            </p>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="location"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Standort</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg rounded-md shadow-sm">
                                <input v-model="event_location" type="text" name="location" id="location"
                                    autocomplete="location"
                                    class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>

                            <p class="mt-2 text-sm text-gray-500">
                                Wo findet das Event statt?
                            </p>
                        </div>
                    </div>


                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="preview_image"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Cover photo</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div
                                class="relative flex max-w-lg justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                                <img v-if="previewImage"
                                    class="absolute z-0 left-0 top-0 right-0 bottom-0 w-full h-full "
                                    :src="previewImageSrc" />
                                <img v-if="!previewImage && event_preview_image"
                                    class="absolute z-0 left-0 top-0 right-0 bottom-0 w-full h-full "
                                    :src="'/storage/'+event_preview_image" />
                                <div v-if="event_preview_image" class="absolute z-10 inset-0 bg-gray-300 opacity-50">
                                </div>
                                <div class="space-y-1 text-center z-10">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-300">
                                        <label for="preview_image"
                                            class="relative cursor-pointer rounded-md font-medium text-indigo-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                            <span>Upload a file</span>
                                            <input @change="onFileChange" id="preview_image" name="preview_image"
                                                type="file" class="sr-only" />
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-200">
                                        PNG, JPG, GIF up to 10MB
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Start
                            Datum</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg rounded-md shadow-sm">
                                <Datepicker v-model="event_start_date" :format="'dd.MM.yyyy HH:mm'" language="de"
                                    name="start_date" id="start_date"
                                    class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>

                            <p class="mt-2 text-sm text-gray-500">
                                Wann beginnt das Event?
                            </p>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">End
                            Datum</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg rounded-md shadow-sm">
                                <Datepicker v-model="event_end_date" :format="'dd.MM.yyyy HH:mm'" name="end_date"
                                    id="end_date"
                                    class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>

                            <p class="mt-2 text-sm text-gray-500">
                                Wann endet das Event?
                            </p>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Event
                            Voranmeldung aktivieren?</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg">
                                <Switch name="pre_registration_enabled" id="pre_registration_enabled"
                                    v-model="event_pre_regist"
                                    :class="[event_pre_regist ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2']">
                                    <span class="sr-only">Voranmeldung aktivieren</span>
                                    <span aria-hidden="true"
                                        :class="[event_pre_regist ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
                                </Switch>
                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="limit"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Teilnehmer</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg rounded-md shadow-sm">
                                <input :disabled="!event_pre_regist" v-model="event_limit" type="text" name="limit"
                                    id="limit"
                                    class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>

                            <p class="mt-2 text-sm text-gray-500">
                                Wie viele Teilnehmer können an diesem Event teilnehmen? (0 = unbegrenzt)
                            </p>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Sichtbarkeit</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg">
                                <Switch name="public" id="public" v-model="event_public"
                                    :class="[event_public ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2']">
                                    <span class="sr-only">Sichtbarkeit</span>
                                    <span aria-hidden="true"
                                        :class="[event_public ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
                                </Switch>
                            </div>

                            <p v-if="event_public" :key="event_public" class="mt-2 text-sm text-gray-500">
                                Das Event ist öffentlich sichtbar.
                            </p>
                            <p v-if="!event_public" :key="event_public" class="mt-2 text-sm text-gray-500">
                                Das Event ist nicht öffentlich sichtbar.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <button type="button" @click="$emit('close_edit')"
                    class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Cancel
                </button>
                <button v-if="!loader" v-on:click.prevent="submitEdit" :key="loader" type="button"
                    class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Save
                </button>
                <button v-if="loader" :key="loader" type="button"
                    class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    disabled>
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Loading...
                </button>
            </div>
        </div>
        <div class="relative z-20">
            <NewEventErrorNotif v-if="error" :show="error" :key="error" :messages="error_messages"></NewEventErrorNotif>
        </div>
    </form>
</template>
