<template>
    <form ref="locationForm" id="locationForm" class="space-y-8 divide-y divide-gray-200 mt-5">
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Neue Location hinzufügen
                </h3>
            </div>
            <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Location Name
                    </label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div class="flex max-w-lg rounded-md shadow-sm">
                            <input type="text" name="name" id="name" autocomplete="name"
                                class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="page_content"
                        class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Beschreibung</label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <textarea id="page_content" name="page_content" rows="3"
                            class="h-64 block w-full max-w-lg rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <p class="mt-2 text-sm text-gray-500">
                            Seiten Inhalt für die Location
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
                    <label for="image" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Logo</label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div
                            class="relative flex max-w-lg justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                            <img v-if="image" class="absolute z-0 left-0 top-0 right-0 bottom-0 w-full h-full "
                                :src="imageSrc" />
                            <div v-if="image" class="absolute z-10 inset-0 bg-gray-300 opacity-50"></div>
                            <div class="space-y-1 text-center z-10">
                                <svg class="mx-auto h-12 w-12 text-gray-300" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-300">
                                    <label for="image"
                                        class="relative cursor-pointer rounded-md font-medium text-indigo-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input @change="onFileChange" id="image" name="image" type="file"
                                            class="sr-only" />
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
                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Sichtbarkeit</label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div class="flex max-w-lg">
                            <Switch name="clickable" id="clickable" v-model="clickable"
                                :class="[clickable ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2']">
                                <span class="sr-only">Aktiv</span>
                                <span aria-hidden="true"
                                    :class="[clickable ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
                            </Switch>
                        </div>

                        <p v-if="clickable" :key="clickable" class="mt-2 text-sm text-gray-500">
                            Die Location Seite ist sichtbar und kann von allen besucht werden.
                        </p>
                        <p v-if="!clickable" :key="clickable" class="mt-2 text-sm text-gray-500">
                            Die Location Seite ist nicht sichtbar und kann nicht besucht werden.
                        </p>
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
                <button v-if="!loader" v-on:click.prevent="submitlocation" :key="loader" type="button"
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
            <ErrorNotification v-if="error" :show="error" :key="error" :messages="error_messages" @close="error = false">
            </ErrorNotification>
        </div>
    </form>
</template>

<script>
import axios from 'axios';
import { Switch } from '@headlessui/vue'
export default {
    components: {
        Switch
    },
    data() {
        return {
            image: false,
            imageSrc: '',
            loader: false,
            error: false,
            error_messages: [],
            clickable: false,
        }
    },
    emits: ['close_create'],
    methods: {
        onFileChange(e) {
            this.image = true;
            this.imageSrc = URL.createObjectURL(e.target.files[0]);
        },
        submitlocation() {
            this.loader = true;
            let formData = new FormData(document.getElementById('locationForm'));
            let vm = this;
            axios.post('/l/create', formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((response) => {
                vm.loader = false;
                vm.$refs.locationForm.reset();
                vm.$emit('close_create');
            }).catch((error) => {
                let errors = error.response.data.errors;
                vm.error_messages = [];
                if (errors) {
                    for (let pair of Object.entries(errors)) {
                        console.log(pair[0] + ", " + pair[1]);
                        vm.error_messages.push(pair[1]);
                    }
                    vm.loader = false;
                    vm.error = true;
                } else {
                    console.error(error);
                    vm.error_messages.push('Something went wrong, please contact the administrator');
                    vm.loader = false;
                    vm.error = true;
                }

                window.scrollTo(0, 0);
            });
        }
    }
}
</script>
