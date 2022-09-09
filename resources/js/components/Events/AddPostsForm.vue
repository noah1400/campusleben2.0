<script>
import { PlusCircleIcon } from '@heroicons/vue/outline';
import EditPostModal from './EditPostModal.vue';
export default {
    components: {
        EditPostModal,
        PlusCircleIcon,
    },
    props: {
        event_id: {
            type: Number,
            required: false
        }
    },
    emits: ['close','save','delete'],
    data() {
        return {
            old_posts: [],
            updated_posts: [],
            new_posts: [],
            upload_files: [],
            posts_to_delete: [],
            post_to_edit: null,
            edit_post_modal: false,
            next_id: 0,
            unsaved_posts: false,
            postAdded: false,
        }
    },
    created() {
        // check if event_id is set
        if (this.event_id) {
            this.getEventPosts();
        }
    },
    methods: {
        getEventPosts() {
            let url = '/api/posts/' + this.event_id;

            axios.get(url).then(response => {
                let res = response.data;
                for (let i = 0; i < res.length; i++) {
                    var post = {
                        id: res[i].id,
                        name: res[i].subtitle,
                        src: '/storage/'+res[i].picture,
                        alt: res[i].subtitle,
                        subtitle: res[i].subtitle,
                    }
                    if(res[i].id > this.next_id) {
                        this.next_id = res[i].id;
                    }
                    this.old_posts.push(post);
                }
            });
        },
        addPost(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            for (let i = 0; i < files.length; i++) {
                this.createPost(files[i]);
            }
            this.unsaved_posts = true;
        },
        createPost(file) {
            let reader = new FileReader();
            reader.onload = (e) => {
                var post = {
                    id: this.next_id,
                    name: file.name,
                    src: e.target.result,
                    alt: file.name,
                    subtitle: '',
                }
                this.next_id++;
                this.new_posts.push(post);
                var upload_file = {
                    id: post.id,
                    picture: file,
                    subtitle: '',
                }
                this.upload_files.push(upload_file);
            };
            reader.readAsDataURL(file);

        },
        openEditModal(post) {
            this.post_to_edit = post;
            this.edit_post_modal = true;
        },
        updatePost(edited_post) {
            let post = edited_post;
            if(this.old_posts.find(p => p.id == post.id)){
                if(this.updated_posts.find(p=>p.id == post.id)){
                    this.updated_posts.find(p=>p.id == post.id).subtitle = post.subtitle;
                }else{
                    this.updated_posts.push(post);
                }
            }
            else{
                if(this.upload_files.find(p=>p.id == post.id)){
                    this.upload_files.find(p=>p.id == post.id).subtitle = post.subtitle;
                }else{
                    this.upload_files.push(post);
                }
            }
            this.unsaved_posts = true;
        },
        savePosts(){
            let vm = this;
            for (let i = 0; i < this.upload_files.length; i++) {
                let url = '/admin/api/posts/newpost';
                let formData = new FormData();
                formData.append('picture', this.upload_files[i].picture);
                formData.append('subtitle', this.upload_files[i].subtitle);
                formData.append('event_id', this.event_id);
                axios.post(url, formData).then(response => {
                })
                .catch(error => {
                    console.log(error.response.data);
                    vm.old_posts.push(vm.upload_files[i]);
                    vm.new_posts = vm.new_posts.filter(p => p.id != vm.upload_files[i].id);
                });
            }
            this.upload_files = [];
            for (let i = 0; i < this.updated_posts.length; i++) {
                let url = '/admin/api/posts/update';
                let formData = new FormData();
                formData.append('id', this.updated_posts[i].id);
                formData.append('subtitle', this.updated_posts[i].subtitle);
                axios.post(url, formData).then(response => {
                });
            }
            this.updated_posts = [];
            for(let i = 0; i < this.posts_to_delete.length; i++){
                let url = '/admin/api/posts/delete/'+this.posts_to_delete[i].id;
                axios.delete(url).then(response => {
                });
            }
            this.posts_to_delete = [];
            this.unsaved_posts = false;
            this.postAdded = true;
            setTimeout(() => {
                this.postAdded = false;
            }, 1500);
        },
        deletePost(post) {
            if(this.old_posts.find(p => p.id == post.id)){
                this.posts_to_delete.push(post);
            }
            else{
                this.upload_files = this.upload_files.filter(p => p.id != post.id);
            }
            this.new_posts = this.new_posts.filter(p => p.id != post.id);
            this.old_posts = this.old_posts.filter(p => p.id != post.id);
            this.unsaved_posts = true;
        },
    }
}

</script>

<template>
    <form ref="postForm" id="postForm">
    <EditPostModal v-if="edit_post_modal" :post="post_to_edit" @close="edit_post_modal = false" @delete="deletePost" @save="updatePost" />
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div>
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Posts
                    </h3>

                    <div class="grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 grid-flow-row gap-4">
                        <div v-for="post in old_posts" :key="post.id">
                            <button :id="'old_' + post.id" type="button" @click="openEditModal(post)" class="relative
                        flex
                        h-24
                        w-24
                        cursor-pointer
                        items-center
                        justify-center
                        rounded-md
                        bg-white
                        text-sm
                        font-medium
                        uppercase
                        test-gray-900
                        hover:bg-gray-50
                        focus:outline-none
                        focus:ring
                        focus:ring-opacity-50
                        focus:ring-offset-4"><span class="absolute inset-0 overflow-hidden rounded-md">
                                    <img :src="post.src" :alt="post.name"
                                        class="h-full w-full object-cover object-center" />
                                </span></button>
                        </div>
                        <div v-for="post in new_posts" :key="post.id">
                            <button :id="'new_' + post.id" type="button" @click="openEditModal(post)" class="relative
                        flex
                        h-24
                        w-24
                        cursor-pointer
                        items-center
                        justify-center
                        rounded-md
                        bg-white
                        text-sm
                        font-medium
                        uppercase
                        test-gray-900
                        hover:bg-gray-50
                        focus:outline-none
                        focus:ring
                        focus:ring-opacity-50
                        focus:ring-offset-4"><span class="absolute inset-0 overflow-hidden rounded-md">
                                    <img :src="post.src" :alt="post.name"
                                        class="h-full w-full object-cover object-center" />
                                </span></button>
                        </div>
                        <button id="addPost" type="button" @click="$refs.postInput.click()" class="relative
                        h-24
                        w-24
                        cursor-pointer
                        items-center
                        justify-center
                        rounded-md
                        bg-transparent
                        text-sm
                        font-medium
                        test-gray-900
                        hover:bg-gray-50"><span class="absolute inset-0 overflow-hidden rounded-md">
                                <div class="w-full h-full flex items-center justify-center">
                                    <PlusCircleIcon class="h-10 w-10 text-gray-400" />
                                </div>
                            </span></button>
                    </div>
                </div>
            </div>
        </div>
        <input type="file" ref="postInput" class="hidden" accept=".jpg,.jpeg,.png" @change="addPost" multiple />
        <button type="button" @click="savePosts" class="mt-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Save
        </button>
        <!-- Saved notification green text -->
        <p class="text-green-500 text-sm font-medium " v-show="postAdded">
            Posts saved
        </p>
        <p class="text-red-500 text-sm font-medium " v-show="unsaved_posts">
            Posts unsaved
        </p>
    </form>
</template>
