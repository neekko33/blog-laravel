<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {Head, router} from '@inertiajs/vue3'
import {Category, Link, Post} from '@/types'
import PostItem from '@/Components/PostItem.vue'
import Pagination from '@/Components/Pagination.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'

defineProps<{
    posts: {
        data: Post[],
        links: Link[]
    },
    categories: Category[]
}>()

const handleClick = () => {
    router.get('/posts/create')
}

</script>

<template>
    <Head title="文章管理"/>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">文章管理</h2>
                <SecondaryButton @click="handleClick">新增文章</SecondaryButton>
            </div>
        </template>
        <div class="py-12">
            <PostItem v-for="post in posts.data" :key="post.id" :post="post" :category="categories.find(item => item.id === post.category_id)" />
            <div class="pt-5 flex justify-center">
                <Pagination :links="posts.links" />
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
