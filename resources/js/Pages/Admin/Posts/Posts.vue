<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {Head, router} from '@inertiajs/vue3'
import {Link, Post} from '@/types'
import Pagination from '@/Components/Admin/Pagination.vue'
import SecondaryButton from '@/Components/Admin/SecondaryButton.vue'
import {formatDate} from '@/utils'

defineProps<{
    posts: {
        data: Post[],
        links: Link[]
    },
}>()

const columns = [
    {label: '标题', key: 'title', width: '400'},
    {label: '分类', key: 'category_id'},
    {label: '标签', key: 'tags'},
    {label: '状态', key: 'published'},
    {label: '创建时间', key: 'created_at'},
    {label: '修改时间', key: 'updated_at'}
]

const handleEdit = (id: number) => {
    router.get(`/admin/posts/${id}/edit`)
}

const handleDelete = (id: number) => {
    const confirm = window.confirm('确认删除该文章？')
    if (confirm) {
        router.delete(`/admin/posts/${id}/destroy`)
    }
}

const handleClick = () => {
    router.get('/admin/posts/create')
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
        <div class="max-w-[90%] mx-auto p-6 bg-white rounded-xl m-5 shadow">
            <el-table :data="posts.data" class="min-h-[60vh]" size="large">
                <template v-for="(item, index) in columns" :key="index">
                    <el-table-column v-if="item.key === 'published'" :label="item.label" :width="item.width">
                        <template #default="{ row }">
                            <el-tag type="success" v-if="row[item.key]">已发布</el-tag>
                            <el-tag type="danger" v-else>未发布</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column v-else-if="item.key === 'category_id'" :label="item.label" :width="item.width">
                        <template #default="{ row }">
                            <span type="info">{{ row.category.name }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column v-else-if="item.key === 'tags'" :label="item.label" :width="item.width">
                        <template #default="{ row }">
                            <el-tag v-for="(tag, index) in row.tags" size="small" :key="index" type="info"
                                    class="inline-block mr-2">{{ tag.name }}
                            </el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column v-else-if="item.key === 'created_at' || item.key === 'updated_at'"
                                     :label="item.label" :width="item.width">
                        <template #default="{ row }">
                            {{ formatDate(row[item.key]) }}
                        </template>
                    </el-table-column>
                    <el-table-column v-else :prop="item.key" :label="item.label" :width="item.width"></el-table-column>
                </template>
                <el-table-column label="操作">
                    <template #default="{ row }">
                        <el-button type="primary" size="small" @click="handleEdit(row.id)">编辑</el-button>
                        <el-button type="danger" size="small" @click="handleDelete(row.id)">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <div class="py-5 flex justify-center" v-if="posts.data?.length > 0">
            <Pagination :links="posts.links" v-if="posts.links?.length > 3"/>
        </div>
        <div class="text-gray-400 w-full text-center" v-else>没有更多文章...</div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
