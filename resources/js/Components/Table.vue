<script setup lang="ts">
import Modal from '@/Components/Modal.vue'

const props = defineProps<{
    options: { label: string, key?: string, render?: Function }[],
    data: { id: number }[]
}>()
</script>

<template>
    <Modal>

    </Modal>
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
                    <template v-if="option.render">
                        {{option.render(item[option.key])}}
                    </template>
                    <template v-else>
                        {{ item[option.key] }}
                    </template>
                </td>
                <td v-else class="max-w-[80px]">
                    <slot name="default" :row="item"></slot>
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
