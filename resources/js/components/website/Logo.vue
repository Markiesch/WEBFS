<script setup>
defineProps({
    class: {
        type: [String, Array, Object],
        default: '',
    },
});
</script>

<template>
    <div :class="['flex items-center gap-2', $props.class]">
        <img src="/images/dragon-small.png" alt="Dragon Logo" class="max-xs:!hidden h-12 w-12" />
        <span class="font-cty text-3xl font-bold whitespace-nowrap text-yellow-300">De Gouden Draak</span>
        <img src="/images/dragon-small-flipped.png" alt="Dragon Logo Flipped" class="max-xs:!hidden h-12 w-12" />
    </div>
</template>
