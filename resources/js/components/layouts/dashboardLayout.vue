<script>
    import Tabs from '../dashboard_components/Tabs.vue'
import { ref } from 'vue'
import {
    Dialog,
    DialogPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {
    BellIcon,
    CalendarIcon,
    ChartBarIcon,
    FolderIcon,
    HomeIcon,
    InboxIcon,
    MenuAlt2Icon,
    UsersIcon,
    XIcon,
} from '@heroicons/vue/outline'
import { SearchIcon } from '@heroicons/vue/solid'
export default {
    components: {
        Tabs,
        CalendarIcon,
        ChartBarIcon,
        FolderIcon,
        HomeIcon,
        InboxIcon,
        Dialog,
        DialogPanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        TransitionChild,
        TransitionRoot,
        MenuAlt2Icon,
        XIcon,
    },
    data() {
        return {
            componentKey: false,
            navigation: [],
            currentTab: null,
            userNavigation: [],
            sidebarOpen: ref(false),
        }
    },
    methods: {
        selectTab(tab) {
            this.$router.push({ name: tab.name.toLowerCase()})
            this.currentTab = tab;
            this.navigation.forEach(item => {
                item.current = false;
            });
            tab.current = true;
        }
    },
    created() {
        this.$route.params.tab = this.$route.params.tab || window.location.pathname.split('/')[3];
        this.navigation = [
            { id: 0, name: 'Dashboard', href: '#', icon: HomeIcon, current: true },
            { id: 1, name: 'Users', href: '#', icon: UsersIcon, current: false },
            { id: 2, name: 'Events', href: '#', icon: CalendarIcon, current: false },
            { id: 3, name: 'Sponsors', href: '#', icon: FolderIcon, current: false },
            { id: 4, name: 'Documents', href: '#', icon: InboxIcon, current: false },
            { id: 5, name: 'Reports', href: '#', icon: ChartBarIcon, current: false },
        ];
        this.currentTab = this.navigation[0];
        this.userNavigation = [
            { name: 'Your Profile', href: '#' },
            { name: 'Settings', href: '#' },
            { name: 'Sign out', href: '#' },
        ]
        console.log(this.$route.params);
        this.navigation.forEach(item => {
            if (item.name.toLowerCase() == this.$route.params.tab.toLowerCase()) {
                this.selectTab(item);
            }
        });
    }
}





</script>
<template>

    <div>
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="relative z-40 md:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                    enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300"
                    leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-600 bg-opacity-75" />
                </TransitionChild>

                <div class="fixed inset-0 flex z-40">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                        enter-from="-translate-x-full" enter-to="translate-x-0"
                        leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                        leave-to="-translate-x-full">
                        <DialogPanel class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
                            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                                enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100"
                                leave-to="opacity-0">
                                <div class="absolute top-0 right-0 -mr-12 pt-2">
                                    <button type="button"
                                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                        @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                    </button>
                                </div>
                            </TransitionChild>
                            <div class="flex-shrink-0 flex items-center px-4">
                                <a href="/">
                                    <img class="h-8 w-auto" src="/storage/images/csm_logo_campusleben.png"
                                        alt="CampusLeben" />
                                </a>
                            </div>
                            <div class="mt-5 flex-1 h-0 overflow-y-auto">
                                <nav :key="componentKey" @click="componentKey = !componentKey" class="px-2 space-y-1">
                                    <a v-for="item in navigation" :key="item.name" :href="item.href"
                                        :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']"
                                        @click="selectTab(item)">
                                        <component :is="item.icon"
                                            :class="[item.current ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300', 'mr-4 flex-shrink-0 h-6 w-6']"
                                            aria-hidden="true" />
                                        {{ item.name }}
                                    </a>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                    <div class="flex-shrink-0 w-14" aria-hidden="true">
                        <!-- Dummy element to force sidebar to shrink to fit close icon -->
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex-1 flex flex-col min-h-0 bg-gray-800">
                <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
                    <a href="/">
                        <img class="h-8 w-auto" src="/storage/images/csm_logo_campusleben.png" alt="CampusLeben" />
                    </a>
                </div>
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav :key="componentKey" @click="componentKey = !componentKey" class="flex-1 px-2 py-4 space-y-1">
                        <a v-for="item in navigation" :key="item.name" :href="item.href"
                            :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']"
                            @click="selectTab(item)">
                            <component :is="item.icon"
                                :class="[item.current ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300', 'mr-3 flex-shrink-0 h-6 w-6']"
                                aria-hidden="true" />
                            {{ item.name }}
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="md:pl-64 flex flex-col">
            <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-transparent">
                <button type="button"
                    class="px-4  text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
                    @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <MenuAlt2Icon class="h-6 w-6" aria-hidden="true" />
                </button>
            </div>

            <main class="flex-1">
                <div class="py-6  bg-gray-50">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <h1 class="text-2xl font-semibold text-gray-900">{{ currentTab.name }}</h1>
                    </div>
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 bg-gray-50">
                        <Tabs :tab="currentTab"></Tabs>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

