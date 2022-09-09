<script>
      import { ref } from 'vue'
  import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
  import { CheckIcon } from "@vue-hero-icons/outline"

  const open = ref(true)
export default {
    components: {
        TransitionRoot,
        Dialog,
        TransitionChild,
        DialogPanel,
        DialogTitle
    },
    props: {
        post: {
            type: Object,
            required: true,
        },
    },
    emits: ['close','save','delete'],
}
</script>


<template>
<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

  <div class="fixed inset-0 z-10 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
        <div>
          <div class="text-center">
            <img :src="post.src" class="h-24 w-24 object-cover object-center m-auto" />
            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">{{ post.subtitle }}</h3>
            <div class="mt-2">
                <input type="text" v-model="post.subtitle" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
            </div>
          </div>
        </div>
        <div class="mt-5 sm:mt-6">
            <button type="button" @click="$emit('save',post);$emit('close')" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                Speichern
                </button>
            <button type="button" @click="$emit('delete',post);$emit('close')" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                Löschen
                </button>
          <button @click="$emit('close')" type="button" class="inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm">Go back to dashboard</button>
        </div>
      </div>
    </div>
  </div>
</div>
</template>
