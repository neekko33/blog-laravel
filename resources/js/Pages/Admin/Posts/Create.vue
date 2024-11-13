<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {Head, useForm, router} from '@inertiajs/vue3'
import {Post, Category, Tag} from '@/types'
import PostEdit from '@/Pages/Admin/Posts/components/PostEdit.vue'


const props = defineProps<{
    categories: Category[],
    tags: Tag[]
}>()

const form = useForm({
    title: '',
    category_id: 1,
    tags_id: [],
    description: '',
    content: ''
})

const submit = () => {
    form.post(`/posts`, {
        preserveScroll: true,
        onSuccess: () => {
            router.get('/posts')
        }
    })
}

</script>

<template>
    <Head title="新增文章"></Head>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">新增文章</h2>
        </template>
        <PostEdit :form="form" :categories="categories" :tags="tags" :submit="submit"/>
    </AuthenticatedLayout>
</template>

<style scoped>
button {
    @apply inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150
}
</style>
