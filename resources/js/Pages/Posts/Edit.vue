<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {Head, useForm, router} from '@inertiajs/vue3'
import {Post, Category, Tag} from '@/types'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import Select from '@/Components/Select.vue'
import {MdEditor} from 'md-editor-v3'
import 'md-editor-v3/lib/style.css'
import InputError from '@/Components/InputError.vue'
import {ref} from 'vue'
import AutoCompleteInput from '@/Components/AutoCompleteInput.vue'

const fileName = ref('')

const props = defineProps<{
    post: Post,
    categories: Category[],
    tags: Tag[]
}>()

const form = useForm({
    id: props.post.id,
    title: props.post.title,
    category_id: props.post.category_id,
    tags_id: props.post.tags.map(tag => tag.id),
    content: props.post.content
})

const submit = () => {
    form.put(`/posts/${props.post.id}/update`, {
        preserveScroll: true,
        onSuccess: () => {
            router.get('/posts')
        }
    })
}

const onReadFile = async () => {
    try {
        form.errors.content = ''
        const fileHandler: FileSystemFileHandle = await window.showOpenFilePicker()
        if (!fileHandler[0].name.endsWith('.md')) {
            form.errors.content = 'Not md file.'
            return
        }
        fileName.value = fileHandler[0].name
        const file = await fileHandler[0].getFile()
        const reader = new FileReader()
        reader.onload = () => {
            form.content = reader.result as string
        }
        reader.readAsText(file)
    } catch (e) {
        form.errors.content = 'Read file failed.'
    }
}

const back = () => {
    history.back()
}

</script>

<template>
    <Head title="文章编辑"></Head>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">文章编辑</h2>
        </template>
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
                                class="bg-gray-800 text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900"
                                :disabled="form.processing" type="submit">保存
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
                            <div class="flex-1">
                                <InputLabel for="title" value="分类"></InputLabel>
                                <Select id="title" class="mt-1 block w-full" v-model="form.category_id"
                                        :data="categories"/>
                                <InputError :message="form.errors.category_id" class="mt-2"/>
                            </div>
                            <div class="flex-1">
                                <InputLabel for="tag" value="标签"></InputLabel>
                                <AutoCompleteInput id="tag" class="mt-1 block w-full" v-model="form.tags_id"
                                                   :data="tags"/>
                                <InputError :message="form.errors.category_id" class="mt-2"/>
                            </div>
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
    </AuthenticatedLayout>
</template>

<style scoped>
button {
    @apply inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150
}
</style>
