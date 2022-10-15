<script>
import {
Tab,
TabGroup,
TabList,
TabPanel,
TabPanels,
} from '@headlessui/vue';
import LogoClouds from '../Sponsors/LogoClouds.vue';



export default {
    components: {
    Tab,
    TabGroup,
    TabList,
    TabPanel,
    TabPanels,
    LogoClouds
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
            pre_registration_count: 0,
            auth: false,
            attending: false,
            closed: false,
            full: false,
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
        },
        getRegistrationCount(){
            let url = '/api/event/user/count/' + this.event.id;
            let vm = this;
            axios.get(url).then(response => {
                let res = response.data;
                vm.pre_registration_count = res.count;
                vm.full = (vm.pre_registration_count >= vm.event.limit&&vm.event.limit!=0)?true:false;
                vm.closed = (vm.event.closed == 1)?true:false;
            });

        },
        isAuth(){
            // if pre-registration is disabled, checking auth is unnecessary
            if(this.event.pre_registration_enabled==1){
                let url = '/api/user/isauthenticated';
                let vm = this;
                axios.get(url).then(response => {
                    let res = response.data;
                    vm.auth = res.auth;
                });
            }
        },
        isAttending(){
            if(this.event.pre_registration_enabled==1){
                let url = '/api/event/user/attending/' + this.event.id;
                let vm = this;
                axios.get(url).then(response => {
                    let res = response.data;
                    vm.attending = res.attending;
                });
            }
        },
        attend() {
            let url = '/api/user/attend/' + this.event.id;
            let vm = this;
            axios.post(url).then(response => {
                let res = response.data;
                vm.attending = res.attending;
                vm.pre_registration_count = res.count;
                vm.full = (vm.pre_registration_count >= vm.event.limit&&vm.event.limit!=0)?true:false;
            });
        },
    },
    created() {
        this.getEventPosts();
        this.getRegistrationCount();
        this.isAuth();
        this.isAttending()
    }
}
</script>

<style scoped>

.description:deep() {
    line-height: 1.5em;
    font-size: 1.1em;
}

.description:deep() ul {
    list-style-type: disc;
    margin: -0.5em 0 -0.5em 1.5em !important;
}

.description:deep() li:has( input[type=checkbox]) {
    list-style-type: none;
    margin-left: -1.5em !important;
}

.description:deep() ol {
    list-style-type: decimal;
    margin: -0.5em 0 -0.5em 1.5em !important;
}

.description:deep() li {
    margin: 0 !important;
}

.description:deep() p {
    margin: -0.5em 0 -0.5em 0 !important;
}

.description:deep() hr {
    margin: 0 0 0 0 !important;
}

.description:deep() a {
    color: #3490dc;
    text-decoration: underline;
}

.description:deep() blockquote {
    border-left: 5px solid #ccc;
    margin: 1.5em 10px !important;
    padding: 0.5em 10px;
}

.description:deep() h1,
.description:deep() h2,
.description:deep() h3,
.description:deep() h4,
.description:deep() h5,
.description:deep() h6 {
    margin: 0 0 0.5rem 0;
    font-weight: bold;
}

.description:deep() h1 {
    font-size: 2.2rem;
    line-height: 1.2;
    letter-spacing: -.1rem;
}

.description:deep() h2 {
    font-size: 1.9rem;
    line-height: 1.25;
    letter-spacing: -.1rem;
}

.description:deep() h3 {
    font-size: 1.7rem;
    line-height: 1.3;
    letter-spacing: -.1rem;
}

.description:deep() h4 {
    font-size: 1.5rem;
    line-height: 1.35;
    letter-spacing: -.08rem;
}

.description:deep() h5 {
    font-size: 1.4rem;
    line-height: 1.5;
    letter-spacing: -.05rem;
}

.description:deep() h6 {
    font-size: 1.4rem;
    line-height: 1.6;
    letter-spacing: 0;
}

.description:deep() pre {
    font: 1em/normal 'Roboto Mono', 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', 'source-code-pro', monospace;
    margin-bottom: 1.5rem !important;
    overflow: auto;
}

.description:deep() pre > code {
    display: block;
    padding: 1rem 1.5rem;
    white-space: pre;
}

.description:deep() code {
    font: 1em/normal 'Roboto Mono', 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', 'source-code-pro', monospace;
    margin: 0 0.2rem;
    background: #F1F1F1;
    border: 1px solid #E1E1E1;
    border-radius: 4px;
}

</style>

<template>
    <div class="bg-white">
        <div v-if="event.public==0 || event.public==false" class="text-center bg-red-500 text-white py-2">
            <p class="text-sm">Dieses Event ist nicht öffentlich.</p>
        </div>
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

                <div class="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ event.name }}</h1>



                    <div class="mt-6">
                        <h3 class="sr-only">Beschreibung</h3>

                        <div class="description space-y-6 text-base text-gray-700 whitespace-pre-wrap" v-html="event.description" />
                        <div class="mt-4 space-y-6 text-base text-gray-700 whitespace-pre-line" >
                            Von: {{ event.start_date }}<br>
                            Bis: {{ event.end_date }}<br>
                            Standort: {{ event.location }}<br>
                        </div>
                        <div class="mt-5 space-y-6 text-base text-gray-700 whitespace-pre-line" v-html="'zum Bild: '" />
                        <div class="space-y-6 text-base text-gray-700 whitespace-pre-line" >
                        {{ selected_post.title }}
                        </div>
                    </div>

                    <div v-if="event.pre_registration_enabled==1" class="mt-5 box-border border-solid border-stone-100 border border-spacing-5 p-4">
                        <div v-show="closed" :class="{'text-red-500':auth==true,'text-gray-500':auth==false}">
                            <p class="text-sm">Die Voranmeldung für dieses Event ist abgelaufen.</p>
                        </div>
                        <div v-show="full" :class="'text-red-500'">
                            <p class="text-sm">Das Event ist voll.</p>
                        </div>
                        {{ pre_registration_count }} von {{ (event.limit==0)?"unbegrenzten":event.limit }} Plätzen belegt
                        <div v-if="auth" class="mt-2">
                            <button v-show="!attending" :disabled="(closed || full)" @click="attend"  type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Jetzt anmelden
                            </button>
                            <button v-show="attending" :disabled="(closed)" @click="attend" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-black bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-50">
                                Abmelden
                            </button>
                        </div>
                        <div v-if="!auth" class="mt-4">
                            Um sich für dieses Event anzumelden, müssen Sie sich zuerst einloggen.
                            <a href="/login" class="mt-1 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Jetzt einloggen
                            </a>
                        </div>
                    </div>
                    <LogoClouds v-if="event.sponsors.length > 0" class="mt-10" :sponsors=event.sponsors />
                </div>
            </div>
        </div>
    </div>
</template>
