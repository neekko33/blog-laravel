<script setup lang="ts">
import {Category} from '@/types'

const model = defineModel<number>({required: true})
const props = defineProps<{
    data: Category[],
}>()

</script>

<template>
    <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" v-model="model">
        <template v-for="(item, index) in data" :key="index">
            <option :value="item.id">{{item.name}}</option>
        </template>
    </select>
</template>

<style scoped>

</style>
