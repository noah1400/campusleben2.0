<template>
    <div v-if="showSponsors" :key="showSponsors">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">Sponsoren</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Liste aller Sponsoren
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                        @click="
    newSponsor = true;editSponsor = false;showSponsors = false;
                        ">
                        Neuer Sponsor
                    </button>
                </div>
            </div>
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                                            Logo
                                        </th>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                                            Name
                                        </th>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                                            Link
                                        </th>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                                            Active
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="sponsor in sponsors" :key="sponsor.id">
                                        <td class="w-32 whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">
                                            <div class="flex flex-col items-center">
                                                <img :src='"/storage/" + sponsor.image' class="max-h-8" />
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">
                                            {{ sponsor.name }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-left">
                                            <a :href="sponsor.link" target="_blank">{{ sponsor.link }}</a>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span v-if="sponsor.active == 1"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktiv
                                            </span>
                                            <span v-if="sponsor.active == 0"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Inaktiv
                                            </span>
                                        </td>
                                        <td
                                            class="flex flex-col relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900"
                                                @click="setEditID(sponsor.id)">Bearbeiten<span class="sr-only">, {{
                                                        sponsor.name
                                                }}</span></a>
                                            <a href="#" class="text-red-600 hover:text-red-900"
                                                @click="deleteModal=true;openDeleteModal(sponsor.id)">Löschen<span class="sr-only">, {{
                                                        sponsor.name
                                                }}</span></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="newSponsor" :key="newSponsor">
        <button type="button"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
            @click="newSponsor = false;editSponsor=false;showSponsors=true">
            Zurück
        </button>
        <NewSponsorForm @close_create="closeCreate"></NewSponsorForm>
    </div>
    <div v-if="editSponsor" :key="editSponsor">
        <button type="button"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
            @click="newSponsor = false;editSponsor=false;showSponsors=true">
            Zurück
        </button>
        <EditSponsorForm @close_edit="closeEdit" :sponsor_id="editSponsorId"></EditSponsorForm>
    </div>
</template>

<script>
import NewSponsorForm from '../Sponsors/NewSponsorForm.vue';
import EditEventForm from '../Events/EditEventForm.vue';
export default {
    data() {
        return {
            editSponsorId: null,
            newSponsor: false,
            editSponsor: false,
            showSponsors: true,
            toDeleteId: -1,
            deleteModal: false,
            sponsors: [],
        };
    },
    created() {
        this.getSponsors();
    },
    methods: {
        getSponsors() {
            let vm = this;
            axios.get("/admin/api/sponsors")
                .then(response => {
                    vm.sponsors = response.data;
                }).
                catch(error => {
                    console.log(error);
                });
        },
        closeCreate() {
            this.newSponsor = false;
            this.showSponsors = true;
            this.getSponsors();
        },
        closeEdit() {
            this.editSponsor = false;
            this.showSponsors = true;
            this.getSponsors();
        },
        setEditID(id) {
            this.editSponsorId = id;
            this.editSponsor = true;
            this.showSponsors = false;
        },
        openDeleteModal(id) {
            this.toDeleteId = id;
        },
    },
    components: { NewSponsorForm, EditEventForm }
}
</script>
