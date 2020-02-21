<template>
    <a @click="deleteDialog">
        <slot name="button"></slot>
    </a>
</template>

<script>
    export default {
        props: ['eventCall', 'payload'],
        methods: {
            deleteDialog() {
                this.$root.$emit(this.eventCall, this.payload);
            }
        }
    };
</script>
