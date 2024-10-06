<script setup lang="ts">
import {Head, Link} from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {Tag} from '@/types'
import Table from '@/Components/Table.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import {formatDate} from '@/utils'

const props = defineProps<{
    tags: Tag[]
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

</script>

<template>
    <Head title="分类管理"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">分类管理</h2>
        </template>

        <div class="py-6">
            <div class="bg-white rounded-md max-w-7xl mx-auto m:px-6 lg:px-8 space-y-6 py-6 shadow">
                <Table :data="tags" :options="tableOptions">
                    <template #default>
                        <div class="flex justify-around">
                            <SecondaryButton>编辑</SecondaryButton>
                            <PrimaryButton>删除</PrimaryButton>
                        </div>
                    </template>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
