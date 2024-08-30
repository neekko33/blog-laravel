<script setup lang="ts">
const props = defineProps<{
    options: { label: string, key?: string }[],
    data: { id: number }[]
}>()
</script>

<template>
    <table class="border border-collapse w-full">
        <thead class="bg-gray-100">
        <tr>
            <th v-for="(option, index) in options" :key="index">{{ option.label }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in data" :key="item.id">
            <template v-for="(option, index) in options" :key="index">
                <td v-if="option.key">
                    {{ item[option.key] }}
                </td>
                <td v-else>
                    <slot name="default"></slot>
                </td>
            </template>
        </tr>
        </tbody>
    </table>
</template>

<style scoped>
th, td {
    @apply border px-2 py-2.5 text-center
}
</style>
