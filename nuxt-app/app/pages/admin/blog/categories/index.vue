<template>
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h1>Категорії блогу</h1>
            <UButton to="/admin/blog/categories/create">Додати</UButton>
        </div>
        <UTable :data="categories" :columns="columns">
            <template #actions-cell="{ row }">
                <UDropdownMenu :items="getActions(row)">
                    <UButton color="neutral" variant="ghost" icon="i-heroicons-ellipsis-horizontal-20-solid" />
                </UDropdownMenu>
            </template>
        </UTable>
    </div>
</template>

<script setup lang="ts">
const categories = ref([])

const columns = [
    { accessorKey: 'id', header: '#' },
    { accessorKey: 'title', header: 'Назва' },
    { accessorKey: 'slug', header: 'Slug' },
    {
        accessorKey: 'is_published',
        header: 'Опубліковано',
        cell: ({ getValue }: any) => getValue() ? '✅' : '❌'
    },
    { id: 'actions', header: 'Дії' }
]

const getActions = (row: any) => [[
    {
        label: 'Редагувати',
        icon: 'i-heroicons-pencil-square-20-solid',
        onSelect: () => navigateTo(`/admin/blog/categories/${row.original.id}/edit`)
    },
    {
        label: 'Видалити',
        icon: 'i-heroicons-trash-20-solid',
        onSelect: () => deleteCategory(row.original.id)
    }
]]

const getCategories = async () => {
    const data: any = await $fetch('http://localhost:8000/api/admin/blog/categories')
    categories.value = data.data
}

const deleteCategory = async (id: number) => {
    if (confirm('Видалити категорію?')) {
        await $fetch(`http://localhost:8000/api/admin/blog/categories/${id}`, { method: 'DELETE' })
        await getCategories()
    }
}

onMounted(() => getCategories())
</script>
