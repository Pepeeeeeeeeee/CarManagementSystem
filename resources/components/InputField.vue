<template>
    <div class="mb-3">
        <input :type="type" class="form-control" :placeholder="placeholder" :value="modelValue"
               @input="$emit('update:modelValue', $event.target.value)" required>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: ['modelValue', 'type', 'placeholder'],
    emits: ['update:modelValue'],
})
</script>

<style scoped>
.form-control {
    border-color: #AEA3B0;
}
</style>
