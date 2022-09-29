<template>
<div>
    <Timeline />
</div>
</template>

<script>
import Timeline from "./Timeline.vue";
export default {
    name: "DashboardTab",
    components: {
        Timeline,
    },
    data() {
        return {
            msg: "DashboardTab",
        }
    }
}
</script>
