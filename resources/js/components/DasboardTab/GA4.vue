<template>
    <!-- Growth Stats -->
    <div>
        <h3 class="text-lg font-medium leading-6 text-gray-900">Letzten 7 Tage</h3>
        <dl class="mt-2 grid grid-cols-1 divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow md:grid-cols-3 md:divide-y-0 md:divide-x">
            <div class="px-3 py-4 sm:p-5">
                <dt class="text-base font-normal text-gray-900">Besucher</dt>
                <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                    <div class="flex items-baseline text-2xl font-semibold text-indigo-600">
                        {{ tw }}
                        <span class="ml-2 text-sm font-medium text-gray-500">Letzte Woche: {{ lw }}</span>
                    </div>

                    <div :class="[growth > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800', 'inline-flex items-baseline px-2.5 py-0.5 rounded-full text-xs font-medium md:mt-2 lg:mt-0']">
                        <ArrowUpIcon v-if="growth > 0" class="-ml-1 mr-0.5 h-4 w-4 flex-shrink-0 self-center text-green-500" aria-hidden="true" />
                        <ArrowDownIcon v-else class="-ml-1 mr-0.5 h-4 w-4 flex-shrink-0 self-center text-red-500" aria-hidden="true" />
                        <span class="sr-only">{{ growth > 0 ? 'gestiegen' : 'gesunken' }} um </span>
                        {{ growth }}%
                    </div>
                </dd>
            </div>
            <div class="px-3 py-4 sm:p-5">
                <dt class="text-base font-normal text-gray-900">Stats 2</dt>
            </div>
            <div class="px-3 py-4 sm:p-5">
                <dt class="text-base font-normal text-gray-900">Stats 3</dt>
            </div>
        </dl>
    </div>
</template>

<script>
import { ArrowUpIcon, ArrowDownIcon } from '@heroicons/vue/outline'

export default {
    components: {
        ArrowUpIcon,
        ArrowDownIcon
    },
    data() {
        return {
            analytics: null,
            lw: 0,
            tw: 0,
            growth: 0,
        }
    },
    methods: {
        getAnalytics() {
            let vm = this;
            const response = axios.get('/admin/api/analytics/lwtw')
            .then(function(response) {
                vm.analytics = response.data;
                vm.prepareData();
            });
        },
        prepareData() {
            let lastWeekTable = this.analytics.lastWeek.table;
            if (lastWeekTable.length > 0) {
                this.lw = lastWeekTable[0].activeUsers;
            }else{
                this.lw = 0;
            }
            let thisWeekTable = this.analytics.thisWeek.table;
            if (thisWeekTable.length > 0) {
                this.tw = thisWeekTable[0].activeUsers;
            }else{
                this.tw = 0;
            }

            if (this.lw > 0) {
                this.growth = ((this.tw - this.lw) / this.lw) * 100;
            }else{
                this.growth = 100;
            }

            console.log("Analytics: ", this.analytics);
            console.log("Last Week: " + this.lw);
            console.log("This Week: " + this.tw);
            console.log("Growth: " + this.growth);
        }
    },
    created() {
        this.getAnalytics();
    }
}
</script>
