<template>
    <div>
        <h3 class="mt-5 text-lg font-medium leading-6 text-gray-900">Timeline</h3>
        <ul role="list" class="mt-2 divide-y divide-grey-200">
            <li v-for="timeEvent in timeline" :key="timeEvent.id" class="py-4">
                <div class="flex space-x-3">
                    <div :class="[timeEvent.color,'p-1 h-7 w-7 rounded-full']">
                        <svg v-if="timeEvent.type == 'create'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-6 h-6">
                            <path fillRule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clipRule="evenodd" />
                        </svg>
                        <svg v-if="timeEvent.type == 'update'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-6 h-6">
                            <path fillRule="evenodd" d="M4.755 10.059a7.5 7.5 0 0112.548-3.364l1.903 1.903h-3.183a.75.75 0 100 1.5h4.992a.75.75 0 00.75-.75V4.356a.75.75 0 00-1.5 0v3.18l-1.9-1.9A9 9 0 003.306 9.67a.75.75 0 101.45.388zm15.408 3.352a.75.75 0 00-.919.53 7.5 7.5 0 01-12.548 3.364l-1.902-1.903h3.183a.75.75 0 000-1.5H2.984a.75.75 0 00-.75.75v4.992a.75.75 0 001.5 0v-3.18l1.9 1.9a9 9 0 0015.059-4.035.75.75 0 00-.53-.918z" clipRule="evenodd" />
                        </svg>
                        <svg v-if="timeEvent.type == 'delete'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-6 h-6">
                            <path fillRule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clipRule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1 space-y-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium">{{ timeEvent.email }}</h3>
                            <p :key="timeEvent.time" class="text-sm text-gray-500">{{ timeEvent.time }}</p>
                        </div>
                        <p class="text-sm text-gray-500">
                            {{ timeEvent.action }}
                        </p>
                    </div>
                </div>
            </li>
        </ul>
        <button @click="loadMore" class="p-2 text-sm font-medium text-center text-gray-500 border rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-gray-100">
            Load More
        </button>
    </div>
    </template>

    <script>
    export default {
        name: "Timeline",
        data() {
            return {
                timelineData: {},
                next_url: "/admin/api/timeline",
                timeline: [],
                id: 0,
            }
        },
        methods: {
            getTimeline() {
                if(this.next_url){
                    let vm = this;

                    axios.get(vm.next_url)
                        .then(function (response) {
                            vm.timelineData = response.data;
                            vm.next_url = vm.timelineData.next_page_url;
                            vm.prepareTimeline();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            prepareTimeline() {
                //update time
                this.timeline.forEach(element => {
                    element.time = this.prepareElapsedTime(element.created_at);
                });
                this.timelineData.data.forEach(element => {
                    let email = element.user_email;
                    let action = element.action;
                    let type = element.type;
                    let color = "bg-gray-200";
                    if (type == "create") {
                        color = "bg-green-200";
                    } else if (type == "update") {
                        color = "bg-yellow-200";
                    } else if (type == "delete") {
                        color = "bg-red-200";
                    }
                    let time = this.prepareElapsedTime(element.created_at);
                    let timelineItem = {
                        id: this.id,
                        email: email,
                        action: action,
                        type: type,
                        color: color,
                        time: time,
                        created_at: element.created_at
                    };
                    this.timeline.push(timelineItem);
                    this.id++;
                });
            },
            prepareElapsedTime(timestamp) {
                // timestamp example : 2022-09-29T20:26:02.000000Z
                // converts timestamp to elapsed time string
                // example 3j 4w 1h 2m 3s
                // 3j = 3 years
                // 4w = 4 weeks
                // 1h = 1 hour
                // 2m = 2 minutes
                // 3s = 3 seconds
                let now = new Date();
                let then = new Date(timestamp);
                let elapsed = now - then;
                let elapsed_years = Math.floor(elapsed / 31536000000);
                if (elapsed_years > 0) {
                    if(elapsed_year > 10){
                        return ">10j";
                    }
                    return elapsed_years + "j";
                }
                let elapsed_weeks = Math.floor(elapsed / 604800000);
                if (elapsed_weeks > 0) {
                    return elapsed_weeks + "w";
                }
                let elapsed_days = Math.floor(elapsed / 86400000);
                if (elapsed_days > 0) {
                    return elapsed_days + "t";
                }
                let elapsed_hours = Math.floor(elapsed / 3600000);
                if (elapsed_hours > 0) {
                    return elapsed_hours + "S";
                }
                let elapsed_minutes = Math.floor(elapsed / 60000);
                if (elapsed_minutes > 0) {
                    return elapsed_minutes + "m";
                }
                let elapsed_seconds = Math.floor(elapsed / 1000);
                if (elapsed_seconds > 0) {
                    return elapsed_seconds + "s";
                }
                return "0s";

            },
            loadMore() {
                this.getTimeline();
            },
        },
        created() {
            this.getTimeline();
        }
    }
    </script>
