
<script>
export default {
    data() {
        return {
            events: [],
        }
    }
}
</script>

<template>
    <div v-for="event in events" v-bind:id="event.id" :key="event.id" class="m-3 flex-initial bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200 w-48">
        <div class="px-4 py-5 sm:px-6">
            {{ event.name }}
            <!-- Content goes here -->
            <!-- We use less vertical padding on card headers on desktop than on body sections -->
        </div>
        <div class="px-4 py-5 sm:p-6">
            {{ event.description }}
            <!-- Content goes here -->
        </div>
    </div>
</template>
