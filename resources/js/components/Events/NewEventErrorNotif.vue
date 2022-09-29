<template>
    <div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
        <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
            <transition enter-active-class="transform ease-out duration-300 transition"
                enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-if="show"
                    class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-medium text-gray-900">Fehler:</p>
                                <p class="mt-1 text-sm text-gray-500">
                                    <ul class="list-disc list-inside">
                                        <li v-for="message in messages" :key="message">{{ message[0] }}</li>
                                    </ul>
                                </p>
                                <div class="mt-3 flex space-x-7">
                                    <button type="button"
                                        class="rounded-md bg-white text-sm font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Undo</button>
                                    <button type="button"
                                        class="rounded-md bg-white text-sm font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Dismiss</button>
                                </div>
                            </div>
                            <div class="ml-4 flex flex-shrink-0">
                                <button type="button" @click="show = false"
                                    class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="sr-only">Close</span>
                                    <span class="h-5 w-5" >Close</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

  <script setup >
  import { ref } from 'vue'

  const show = ref(true)
</script>

<script>
export default {
    name: "NewEventErrorNotif",
    props: {
        messages: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            show: ref(true)
        }
    }
}
</script>

