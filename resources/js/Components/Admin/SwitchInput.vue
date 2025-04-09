<script setup>

const props = defineProps(['id', 'model', 'label', 'checked'])

</script>

<template>
    <div>
        <label :for="props.id" class="toggle toggle-sm">
            <input v-model="props.model" class="toggle-input peer sr-only" :id="props.id" type="checkbox"
                :checked="props.checked">
            <div class="toggle-body"></div>
            <span class="label label-md">{{ props.label }}</span>
        </label>
    </div>
</template>