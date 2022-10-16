<template>
    <div class="bg-white">
      <div class="max-w-lg py-12 px-2 sm:px-4 lg:px-6">
        <h2 class="text-lg font-semibold text-gray-500 mb-3">Unterstützt von</h2>
        <div class="flex flex-row flex-wrap justify-start mx-2 gap-8">
          <div v-for="sponsor in sponsors" :key="sponsor.id" class="flex justify-center">
            <a :href="sponsor.link" target="_blank" rel="noopener noreferrer">
                <img class="h-12 transition ease-in-out delay-75 hover:-translate-y-1 hover:scale-110 duration-300" :src="'/storage/' + sponsor.image" :alt="sponsor.name" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
    export default {
        props: {
            sponsors: {
                type: Array,
                required: true
            }
        },
    };
  </script>
