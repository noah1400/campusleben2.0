<script>
import NewEventErrorNotif from './NewEventErrorNotif.vue';
import AddPostsForm from './AddPostsForm.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { Switch, Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ref } from 'vue'
export default {
    components: {
        NewEventErrorNotif,
        AddPostsForm,
        Datepicker,
        Switch,
        Disclosure,
        DisclosureButton,
        DisclosurePanel
    },
    emits: ['close_create'],
    data(){
        return {
        loader: false,
        previewImage: false,
        previewImageSrc: '',
        format: 'dd.MM.yyyy HH:mm',
        error_messages: [],
        error: false,
        start_date: ref(new Date()),
        end_date: ref(new Date()),
        limit: ref(false),
        public_event: ref(false),
        };
    },
    methods: {

        submitEvent() {
            let formData = new FormData(document.getElementById("eventForm"));


            this.loader = true;
            let vm = this;
            axios
                .post("/admin/api/events/create", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    vm.loader = false;
                    vm.$refs.eventForm.reset();
                    vm.$emit('close_create');
                })
                .catch((error) => {
                    let errors = error.response.data.errors;
                    vm.error_messages = [];
                    if(errors){
                        for (let pair of Object.entries(errors)) {
                            console.log(pair[0] + ", " + pair[1]);
                            vm.error_messages.push(pair[1]);
                        }
                        vm.loader = false;
                        vm.error = true;
                    }else{
                        console.error(error);
                        vm.error_messages.push('Something went wrong, please contact the administrator');
                        vm.loader = false;
                        vm.error = true;
                    }

                    window.scrollTo(0, 0);
                });
        },
        onFileChange(e) {
            this.previewImage = true;
            this.previewImageSrc = URL.createObjectURL(e.target.files[0]);
        },
    }
}
</script>



<template>
    <form ref="eventForm" id="eventForm" class="space-y-8 divide-y divide-gray-200 mt-5">

        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div>
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Neues Event erstellen
                    </h3>
                </div>
                <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Event
                            Name</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg rounded-md shadow-sm">
                                <input type="text" name="name" id="name" autocomplete="name"
                                    class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="description"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Beschreibung</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <textarea id="description" name="description" rows="3"
                                class="h-64 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
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
                                <input type="text" name="location" id="location" autocomplete="location"
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
                                <div v-if="previewImage" class="absolute z-10 inset-0 bg-gray-300 opacity-50"></div>
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
                                <Datepicker v-model="start_date" :format="format" :locale="de" name="start_date"
                                    id="start_date"
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
                                <Datepicker v-model="end_date" :format="format" :locale="de" name="end_date"
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
                                <Switch name="limit" id="limit" v-model="limit"
                                    :class="[limit ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2']">
                                    <span class="sr-only">Voranmeldung aktivieren</span>
                                    <span aria-hidden="true"
                                        :class="[limit ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
                                </Switch>
                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="limit"
                            class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Teilnehmer</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg rounded-md shadow-sm">
                                <input :disabled="!limit" type="text" name="limit" id="limit"
                                    class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>

                            <p class="mt-2 text-sm text-gray-500">
                                Wie viele Teilnehmer können an diesem Event teilnehmen? (0 = unbegrenzt)
                            </p>
                        </div>
                    </div>

                    <Disclosure as="section" aria-labelledby="sponsor-heading" class="flex flex-col items-start">
                        <h2 id="sponsor-heading" class="sr-only">Sponsors</h2>
                        <div class="relative py-4 flex flex-row">
                            <div class="mx-auto flex max-w-7xl space-x-6 divide-x divide-gray-200 px-4 test-sm sm:px-6 lg:px-8">
                                <div>
                                    <DisclosureButton class="group flex items-center font-medium text-gray-700">
                                        <div class="mr-2 h-5 w-5 flex-none text-gray-400 group-hover:text-gray-500" aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0112 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 011.541 1.836v1.044a3 3 0 01-.879 2.121l-6.182 6.182a1.5 1.5 0 00-.439 1.061v2.927a3 3 0 01-1.658 2.684l-1.757.878A.75.75 0 019.75 21v-5.818a1.5 1.5 0 00-.44-1.06L3.13 7.938a3 3 0 01-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836z" clip-rule="evenodd" />
                                            </svg>
                                        </div>

                                        0 Sponsoren
                                    </DisclosureButton>
                                </div>
                                <div class="pl-6">
                                    <button type="button" class="text-gray-500">Alle Entfernen</button>
                                </div>
                            </div>
                        </div>
                        <DisclosurePanel class="px-4 pt-2 border-gray-200 border-t w-100">
                            <div>
                                Hier wird man Sponsoren auswählen. (Wird noch gemacht)
                                <!--
                                    https://tailwindui.com/components/ecommerce/components/category-filters
                                    With expandable product filter panel
                                -->
                            </div>
                        </DisclosurePanel>
                    </Disclosure>


                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Sichtbarkeit</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg">
                                <Switch name="public" id="public" v-model="public_event"
                                    :class="[public_event ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2']">
                                    <span class="sr-only">Sichtbarkeit</span>
                                    <span aria-hidden="true"
                                        :class="[public_event ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
                                </Switch>
                            </div>

                            <p v-if="public_event" :key="public_event" class="mt-2 text-sm text-gray-500">
                                Das Event ist öffentlich sichtbar.
                            </p>
                            <p v-if="!public_event" :key="public_event" class="mt-2 text-sm text-gray-500">
                                Das Event ist nicht öffentlich sichtbar.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <button type="button" @click="$emit('close_create')"
                    class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Cancel
                </button>
                <button v-if="!loader" v-on:click.prevent="submitEvent" :key="loader" type="button"
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
