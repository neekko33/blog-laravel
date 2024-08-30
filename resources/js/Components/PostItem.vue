<script setup lang="ts">
import {Category, Post} from '@/types'
import {formatDate} from '@/utils'
import {Link, router, useForm} from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'
import {ref} from 'vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps<{ post: Post, category: Category }>()
const updatePostImg = ref(false)

const form = useForm({
    img_url: props.post.img_url
})

const onDelete = () => {
    const confirm = window.confirm('确认删除该文章？')
    if (confirm) {
        router.delete(`/posts/${props.post.id}/destroy`)
    }
}

const showModal = () => {
    updatePostImg.value = true
}

const closeModal = () => {
    updatePostImg.value = false
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
    <Modal :show="updatePostImg" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                修改《{{post.title}}》封面图地址
            </h2>
            <div class="mt-6">
                <InputLabel for="img_url" value="图片地址" />
                <TextInput
                    id="img_url"
                    v-model="form.img_url"
                    class="mt-1 block w-3/4"
                    placeholder="请输入URL"
                    @keyup.enter="changeImgUrl"
                />
                <InputError :message="form.errors.img_url" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> 取消 </SecondaryButton>

                <PrimaryButton
                    class="ms-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="changeImgUrl"
                >
                    确认
                </PrimaryButton>
            </div>
            </div>
    </Modal>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 py-2">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg flex">
            <div class="post-img relative flex items-center justify-center cursor-pointer hover:opacity-80" @click="showModal">
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
<!--                <Link :href="`/posts/${post.id}/img`" method="post" as="button" type="button"-->
<!--                      class="bg-amber-500 rounded text-white hover:bg-amber-400">封面-->
<!--                </Link>-->
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
