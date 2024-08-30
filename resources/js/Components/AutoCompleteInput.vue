<script setup lang="ts">
import {Tag} from '@/types'
import {computed, ref} from 'vue'

const inputValue = ref('')

const model = defineModel<number[]>({required: true})

const props = defineProps<{
    data: Tag[]
}>()

const selectedTags = computed(() => {
    return model.value.map(id => props.data.find(tag => tag.id === id))
})

const filteredSuggestions = computed(() => {
    if (!inputValue.value) return []
    return props.data.filter(item => item.name.toLowerCase().startsWith(inputValue.value.toLowerCase()) && selectedTags.value.findIndex(itm => itm.id === item.id) === -1).slice(0, 5)
})

const selectSuggestion = (suggestion: Tag) => {
    model.value.push(suggestion.id)
    inputValue.value = ''
}

const onClickTag = (id: number) => {
    model.value.splice(model.value.findIndex(item => item === id), 1)
}
</script>

<template>
    <div class="relative">
        <div class="flex">
            <div
                class="flex border rounded-md flex-1 relative items-center border-gray-300 shadow-sm w-full px-1">
                <div class="tags flex">
                    <span v-for="tag in selectedTags" :key="tag" class="tag">
                        {{ tag.name }}
                        <button class="bg-none border-none cursor-pointer font-bold ml-1"
                                @click.prevent="onClickTag(tag.id)">×</button>
                    </span>
                </div>
                <input
                    class="focus:ring-0 flex-1 border-none rounded-md"
                    v-model="inputValue"
                    placeholder="请输入标签"
                />
                <ul v-if="filteredSuggestions.length > 0" class="suggestions">
                    <li
                        v-for="suggestion in filteredSuggestions"
                        class="p-2 cursor-pointer hover:bg-gray-100"
                        :key="suggestion"
                        @click="selectSuggestion(suggestion)"
                    >
                        {{ suggestion.name }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style scoped>
.suggestions {
    @apply absolute left-0 w-full max-h-[200px] overflow-y-auto list-none p-0 m-0 border border-t-0 rounded-b bg-white z-10;
    top: calc(100% + 1px);
}

.tag {
    @apply inline-block bg-[#e0e0e0] py-1 px-2 mr-1 rounded text-nowrap
}
</style>
