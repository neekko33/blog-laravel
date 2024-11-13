<script setup lang="ts">
import {Head, router} from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {Category} from '@/types'
import Table from '@/Components/Admin/Table.vue'
import PrimaryButton from '@/Components/Admin/PrimaryButton.vue'
import SecondaryButton from '@/Components/Admin/SecondaryButton.vue'
import {formatDate} from '@/utils'

const props = defineProps<{
    categories: Category[]
}>()

const tableOptions: { label: string, key?: string, render?: Function }[] = [
    {
        label: 'ID',
        key: 'id'
    },
    {
        label: '名称',
        key: 'name'
    },
    {
        label: '创建时间',
        key: 'created_at',
        render: formatDate
    },
    {
        label: '修改时间',
        key: 'updated_at',
        render: formatDate
    },
    {
        label: '操作'
    }
]

const handleDelete = (row) => {
    const confirm = window.confirm('确认删除该分类？')
    if (confirm) {
         router.delete(`/categories/${row.id}`)
    }
}

const handleUpdate = (row) => {
    const prompt = window.prompt('请输入新的分类名称', row.name)
    if (prompt.trim()) {
        router.put(`/categories/${row.id}`, {
            name: prompt.trim()
        })
    }
}

const handleClick = () => {
    const prompt = window.prompt('请输入新的分类名称')
    if (prompt.trim()) {
        router.post(`/categories`, {
            name: prompt.trim()
        })
    }
}

</script>

<template>
    <Head title="分类管理"/>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">分类管理</h2>
                <SecondaryButton @click="handleClick">新增分类</SecondaryButton>
            </div>
        </template>

        <div class="py-6">
            <div class="bg-white rounded-md max-w-7xl mx-auto m:px-6 lg:px-8 space-y-6 py-6 shadow">
                <Table :data="categories" :options="tableOptions">
                    <template #default="{row}">
                        <div class="flex justify-around">
                            <SecondaryButton @click="handleUpdate(row)">编辑</SecondaryButton>
                            <PrimaryButton @click="handleDelete(row)">删除</PrimaryButton>
                        </div>
                    </template>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
