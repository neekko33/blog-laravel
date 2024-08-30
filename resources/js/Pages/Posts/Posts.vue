<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {Head} from '@inertiajs/vue3'
import {Category, Link, Post} from '@/types'
import PostItem from '@/Components/PostItem.vue'
import Pagination from '@/Components/Pagination.vue'

defineProps<{
    posts: {
        data: Post[],
        links: Link[]
    },
    categories: Category[]
}>()

</script>

<template>
    <Head title="文章管理"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">文章管理</h2>
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
