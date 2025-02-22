<template>
    <button class="btn btn-danger">{{ label }}</button>
</template>

<script >
import {defineComponent} from "vue";

export default defineComponent({
    props: ['label']
})
</script>

<style scoped>
</style>
