<template>
    <button class="btn btn-primary">{{ label }}</button>
</template>

<script >
import {defineComponent} from "vue";

export default defineComponent({
    props: ['label']
})
</script>

<style scoped>
.btn-primary:hover {
    background-color: #AEA3B0;
}

.btn-primary {
    background-color: #827081;
    border: none;
}
</style>
