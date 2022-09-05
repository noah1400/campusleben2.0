<script>
export default {
    components: {
        Tab,
        TabGroup,
        TabList,
        TabPanel,
        TabPanels,
    },
    props: {
        event: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            posts: [],
            selected_post: {id: 0, name: '', src: '', alt: '', title: ''},
        };
    },
    methods: {
        getEventPosts() {
            let url = '/api/posts/' + this.event.id;
            let vm = this;
            axios.get(url).then(response => {
                let res = response.data;
                var cover = {
                    id: 0,
                    title: vm.event.name,
                    src: '/storage/' + vm.event.preview_image,
                    alt: vm.event.name,
                }
                vm.selected_post = cover;
                vm.posts.push(cover);
                for (let i = 0; i < res.length; i++) {
                    var post = {
                        id: res[i].id + 1,
                        title: res[i].subtitle,
                        src: '/storage/'+res[i].picture,
                        alt: res[i].subtitle,
                    }
                    vm.posts.push(post);
                }
            });
        }
    },
    created() {
        vm.getEventPosts();
    }
}
</script>

<script setup>
import {
    Tab,
    TabGroup,
    TabList,
    TabPanel,
    TabPanels,
} from '@headlessui/vue';
</script>


<template>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                <!-- Image gallery -->
                <TabGroup as="div" class="flex flex-col-reverse">
                    <!-- Image selector -->
                    <div class="mx-auto mt-6 hidden w-full max-w-2xl sm:block lg:max-w-none">
                        <TabList class="grid grid-cols-4 gap-6">
                            <Tab v-for="image in posts" :key="image.id" @click="selected_post = image"
                                class="relative flex h-24 cursor-pointer items-center justify-center rounded-md bg-white text-sm font-medium uppercase text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-offset-4"
                                v-slot="{ selected }">
                                <span class="sr-only"> {{ image.name }} </span>
                                <span class="absolute inset-0 overflow-hidden rounded-md">
                                    <img :src="image.src" alt="" class="h-full w-full object-cover object-center" />
                                </span>
                                <span
                                    :class="[selected ? 'ring-indigo-500' : 'ring-transparent', 'pointer-events-none absolute inset-0 rounded-md ring-2 ring-offset-2']"
                                    aria-hidden="true" />
                            </Tab>
                        </TabList>
                    </div>

                    <TabPanels class="aspect-w-1 aspect-h-1 w-full">
                        <TabPanel v-for="image in posts" :key="image.id">
                            <img :src="image.src" :alt="image.alt" class="mx-auto h-full object-cover object-center sm:rounded-lg" />
                        </TabPanel>
                    </TabPanels>
                </TabGroup>

                <!-- Product info -->
                <div class="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ event.name }}</h1>



                    <div class="mt-6">
                        <h3 class="sr-only">Description</h3>

                        <div class="space-y-6 text-base text-gray-700 whitespace-pre-line" v-html="event.description" />
                        <div class="mt-5 space-y-6 text-base text-gray-700 whitespace-pre-line" v-html="'zum Bild: '" />
                        <div class="space-y-6 text-base text-gray-700 whitespace-pre-line" >
                        {{ selected_post.title }}
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
</template>
