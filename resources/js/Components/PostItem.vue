<script setup lang="ts">
import {Category, Post} from '@/types'
import {formatDate} from '@/utils'
import {Link, router, useForm} from '@inertiajs/vue3'

const props = defineProps<{ post: Post, category: Category }>()

const form = useForm({
    img_url: props.post.img_url
})

const onDelete = () => {
    const confirm = window.confirm('确认删除该文章？')
    if (confirm) {
        router.delete(`/posts/${props.post.id}/destroy`)
    }
}

const changeImgUrl = () => {
    form.post(`/posts/${props.post.id}/updateImgUrl`,{
        onSuccess: () => {
            closeModal()
        }
    })
}

</script>

<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 py-2">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg flex">
            <div class="post-img relative flex items-center justify-center">
                <img class="w-full" :src="post.img_url" :alt="post.title"/>
            </div>
            <div class="flex-1 px-8 flex flex-col justify-between text-gray-500">
                <div>标题：{{ post.title }}</div>
                <div>分类：{{ category.name }}</div>
                <div>标签：<span v-for="(tag, index) in post.tags" :key="index" class="mr-2">#{{ tag.name }}</span></div>
                <div>创建日期：{{ formatDate(post.created_at) }}</div>
                <div>修改日期：{{ formatDate(post.updated_at) }}</div>
            </div>
            <div class="options flex flex-col justify-between">
                <Link :href="`/posts/${post.id}/publish`" method="post" as="button" type="button"
                      class="bg-gray-400 hover:bg-gray-300 rounded text-white" v-if="!post.published">
                    未发布
                </Link>
                <Link :href="`/posts/${post.id}/unpublish`" as="button" method="post"
                      class="bg-green-500 hover:bg-green-400 rounded text-white" v-else>
                    已发布
                </Link>
                <Link :href="`/posts/${post.id}/edit`" method="get" as="button" type="button"
                      class="bg-blue-500 rounded text-white hover:bg-blue-400">编辑
                </Link>
                <button class="bg-red-500 rounded text-white hover:bg-red-400" @click="onDelete">删除</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.post-img {
    width: 200px;
    height: 150px;
}

.options button {
    @apply px-5 py-1 rounded font-bold
}
</style>
