<script setup lang="ts">
import {InertiaForm} from '@inertiajs/vue3'
import { Category, Tag} from '@/types'
import InputLabel from '@/Components/Admin/InputLabel.vue'
import TextInput from '@/Components/Admin/TextInput.vue'
import Select from '@/Components/Admin/Select.vue'
import {MdEditor} from 'md-editor-v3'
import 'md-editor-v3/lib/style.css'
import InputError from '@/Components/Admin/InputError.vue'
import {computed, ref} from 'vue'
import AutoCompleteInput from '@/Components/Admin/AutoCompleteInput.vue'

const fileName = ref('')

interface FormProps {
    title: string,
    category_id: number,
    tags_id: number[],
    description: string,
    content: string
}

const props = defineProps<{
    categories: Category[],
    tags: Tag[],
    submit: Function,
    form: FormProps & InertiaForm<FormProps>
}>()

const onReadFile = async () => {
    try {
        props.form.errors.content = ''
        const fileHandler: FileSystemFileHandle = await window.showOpenFilePicker()
        if (!fileHandler[0].name.endsWith('.md')) {
            props.form.errors.content = 'Not md file.'
            return
        }
        fileName.value = fileHandler[0].name
        if (!props.form.title) {
            props.form.title = fileName.value.replace('.md', '')
        }
        const file = await fileHandler[0].getFile()
        const reader = new FileReader()
        reader.onload = () => {
            props.form.content = reader.result as string
        }
        reader.readAsText(file)
    } catch (e) {
        props.form.errors.content = 'Read file failed.'
    }
}

const back = () => {
    history.back()
}

const canApply = computed(() => {
    return hasEmptyInput.value || props.form.processing
})

const hasEmptyInput = computed(() => {
    const {title, category_id, description, content, tags_id} = props.form
    return !title || !category_id || !description || !content || tags_id.length === 0
})

</script>

<template>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form @submit.prevent="submit">
                <div class="pb-6 flex justify-end">
                    <div class="flex items-center gap-4">
                        <button
                            class="bg-gray-300 text-black hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-400"
                            @click.prevent="back">返回
                        </button>
                        <button
                            class="bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 disabled:opacity-60"
                            :disabled="canApply" type="submit">保存
                        </button>
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex justify-between gap-6">
                        <div class="flex-1">
                            <InputLabel for="title" value="标题"></InputLabel>
                            <TextInput id="title" class="mt-1 block w-full" v-model="form.title" required/>
                            <InputError :message="form.errors.title" class="mt-2"/>
                        </div>
                        <div class="flex-2">
                            <InputLabel for="title" value="分类"></InputLabel>
                            <Select id="title" class="mt-1 block w-full" v-model="form.category_id"
                                    :data="categories"/>
                            <InputError :message="form.errors.category_id" class="mt-2"/>
                        </div>
                    </div>
                    <div class="mt-4">
                        <InputLabel for="description" value="简介"></InputLabel>
                        <TextInput id="description" class="mt-1 block w-full" v-model="form.description" required />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="tag" value="标签"></InputLabel>
                        <AutoCompleteInput id="tag" class="mt-1 block w-full" v-model="form.tags_id"
                                           :data="tags"/>
                        <InputError :message="form.errors.category_id" class="mt-2"/>
                    </div>
                </div>
                <div class="mt-5 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="pb-4 flex gap-4">
                        <button
                            class="bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900"
                            @click.prevent="onReadFile">文件上传
                        </button>
                        <div class="flex justify-center items-center" v-if="fileName">{{ fileName }}</div>
                        <InputError :message="form.errors.content" class="flex justify-center items-center"/>
                    </div>
                    <MdEditor v-model="form.content"/>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
button {
    @apply inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150
}
</style>
