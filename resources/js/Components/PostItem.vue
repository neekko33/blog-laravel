<script setup lang="ts">
import { Category, Post } from '@/types'
import { formatDate } from '@/utils'
import { Link, router } from '@inertiajs/vue3'
import SecondaryButton from '@/Components/SecondaryButton.vue'

const props = defineProps<{ post: Post, category: Category }>()

const onDelete = () => {
    const confirm = window.confirm('确认删除该文章？')
    if (confirm) {
        router.delete(`/posts/${props.post.id}/destroy`)
    }
}

</script>

<template>
    <div class="px-6 py-2 mx-auto w-full">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg flex">
            <div class="flex-1 px-8 flex flex-col justify-between text-gray-500 ellipsis">
                <div>标题：{{ post.title }}</div>
                <div>分类：{{ category.name }}</div>
                <div>标签：<span v-for="(tag, index) in post.tags" :key="index" class="mr-2">#{{ tag.name }}</span></div>
                <div>简介：{{post.description}}</div>
                <div>创建日期：{{ formatDate(post.created_at) }}</div>
                <div>修改日期：{{ formatDate(post.updated_at) }}</div>
            </div>
            <div class="options flex flex-col justify-between">
                <Link :href="`/posts/${post.id}/publish`" method="post" as="button" type="button"
                      class="bg-gray-400 hover:bg-gray-300 rounded text-white py-1" v-if="!post.published">
                    未发布
                </Link>
                <Link :href="`/posts/${post.id}/unpublish`" as="button" method="post"
                      class="bg-green-500 hover:bg-green-400 rounded text-white py-1 text-sm" v-else>
                    已发布
                </Link>
                <SecondaryButton :href="`/posts/${post.id}/edit`">编辑</SecondaryButton>
                <SecondaryButton @click="onDelete">删除</SecondaryButton>
            </div>
        </div>
    </div>
</template>

<style scoped>
.post-img {
    width: 200px;
    height: 150px;
}

.ellipsis div {
    @apply w-[28rem] overflow-hidden overflow-ellipsis whitespace-nowrap
}

.options button {
    @apply rounded font-bold
}
</style>
