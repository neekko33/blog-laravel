<script setup lang="ts">
import {ChevronLeftIcon, ChevronRightIcon} from '@heroicons/vue/20/solid'
import {Link} from '@/types'

defineProps<{
    links: Array<Link>
}>()

</script>

<template>
    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm bg-white mx-auto" aria-label="Pagination">
        <template v-for="(link, index) in links" :key="index">
            <template v-if="index === 0">
                <a :href="link.url"
                   class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    <span class="sr-only">Previous</span>
                    <ChevronLeftIcon class="h-5 w-5" aria-hidden="true"/>
                </a>
            </template>
            <template v-else-if="index === links.length - 1">
                <a :href="link.url" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    <span class="sr-only">Next</span>
                    <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                </a>
            </template>
            <template v-else>
                <a :href="link.url" aria-current="page" :class="link.active?'active':'not-active'">{{ link.label }}</a>
            </template>
        </template>
    </nav>
</template>

<style scoped>
.active {
    @apply relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600
}

.not-active {
    @apply relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0
}
</style>
