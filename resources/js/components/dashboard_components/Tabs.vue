<script>
import UsersTab from './UsersTab.vue'
import EventsTab from './EventsTab.vue';
import SponsorsTab from './SponsorsTab.vue';
import DashboardTab from '../DasboardTab/DashboardTab.vue';
import LocationsTab from './LocationsTab.vue';

export default {
    props: {
        tab: {
            required: true
        },
    },
    data() {
        return {
            users: window.users,
            events: window.events,
            posts: window.posts,
        };
    },
    methods: {},
    components: { UsersTab, EventsTab, SponsorsTab, DashboardTab, LocationsTab }
}
</script>
<template>
    <div class="mt-4 flex-1 flex flex-col bg-gray-50 h-full">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 overflow-y-auto overflow-x-hidden">
            <UsersTab v-if="tab.name === 'Users'" />
            <EventsTab v-if="tab.name === 'Events'" />
            <SponsorsTab v-if="tab.name === 'Sponsors'" />
            <DashboardTab v-if="tab.name === 'Dashboard'" />
            <LocationsTab v-if="tab.name === 'Locations'" />
        </div>
    </div>
</template>


