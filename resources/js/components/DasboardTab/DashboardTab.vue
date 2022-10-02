<template>
<div>
    <GA4 />
    <Timeline />
</div>
</template>

<script>
import Timeline from "./Timeline.vue";
import GA4 from "./GA4.vue";
export default {
    name: "DashboardTab",
    components: {
    Timeline,
    GA4
},
    data() {
        return {
            msg: "DashboardTab",
        }
    }
}
</script>
