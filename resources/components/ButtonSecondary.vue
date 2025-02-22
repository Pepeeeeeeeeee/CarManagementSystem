<template>
    <button class="btn btn-secondary">{{ label }}</button>
</template>

<script >
import {defineComponent} from "vue";

export default defineComponent({
    props: ['label']
})
</script>
