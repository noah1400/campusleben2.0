<template>
    <form ref="sponsorForm" id="sponsorForm" class="space-y-8 divide-y divide-gray-200 mt-5">
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Neuer Sponsor hinzufügen
                </h3>
            </div>
            <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Sponsor Name
                    </label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div class="flex max-w-lg rounded-md shadow-sm">
                            <input type="text" name="name" id="name" autocomplete="name"
                                class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="link" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Sponsor Link
                    </label>
                    <div class="mt-1 sm:col-span-2 sm:mt-0">
                        <div class="flex max-w-lg rounded-md shadow-sm">
                            <input type="text" name="link" id="link" autocomplete="link"
                                class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                    </div>
                </div>
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="image" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Cover
                        photo</label>
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
                            Aktiv</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg">
                                <Switch name="active" id="active" v-model="active_sponsor"
                                    :class="[active_sponsor ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2']">
                                    <span class="sr-only">Aktiv</span>
                                    <span aria-hidden="true"
                                        :class="[active_sponsor ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
                                </Switch>
                            </div>

                            <p v-if="active_sponsor" :key="active_sponsor" class="mt-2 text-sm text-gray-500">
                                Der Sponsor wird auf der Startseite angezeigt.
                            </p>
                            <p v-if="!active_sponsor" :key="active_sponsor" class="mt-2 text-sm text-gray-500">
                                Der Sponsor wird nicht auf der Startseite angezeigt.
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
                <button v-if="!loader" v-on:click.prevent="submitSponsor" :key="loader" type="button"
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
            active_sponsor: false,
        }
    },
    emits: ['close_create'],
    methods: {
        onFileChange(e) {
            const file = e.target.files[0];
            this.image = true;
            this.imageSrc = URL.createObjectURL(file);
        },
        submitSponsor() {
            let formData = new FormData(document.getElementById('sponsorForm'));

            this.loader = true;
            let vm = this;
            axios.post('/admin/api/sponsors/create', formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            })
                .then((response) => {
                    vm.loader = false;
                    vm.$refs.sponsorForm.reset();
                    vm.$emit('close_create');
                })
                .catch((error) => {
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
                        console.log(error);
                        vm.error_messages.push('Something went wrong, please contact the administrator');
                        vm.loader = false;
                        vm.error = true;
                    }
                })

            window.scrollTo(0, 0);
        }
    }
}
</script>
