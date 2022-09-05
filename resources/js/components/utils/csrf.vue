<template>
    <input type="hidden" name="_token" :class="'border-none box-content'" :value="token" />
</template>

<script>
    export default {
        data() {
            return {
                token: null
            }
        },
        created() {
            this.token = document.querySelector('meta[name="csrf-token"]').content
        }
    }
</script>
