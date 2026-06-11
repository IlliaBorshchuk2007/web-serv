<template>
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h1>Пости блогу</h1>
            <UButton to="/admin/blog/posts/create">Додати</UButton>
        </div>
        <UTable :data="posts" :columns="columns">
            <template #actions-cell="{ row }">
                <UDropdownMenu :items="getActions(row)">
                    <UButton color="neutral" variant="ghost" icon="i-heroicons-ellipsis-horizontal-20-solid" />
                </UDropdownMenu>
            </template>
        </UTable>
    </div>
</template>

<script setup lang="ts">
const posts = ref([])

const columns = [
    { accessorKey: 'id', header: '#' },
    { accessorKey: 'title', header: 'Заголовок' },
    { accessorKey: 'is_published', header: 'Опубліковано' },
    { accessorKey: 'date_published', header: 'Дата' },
    { id: 'actions', header: 'Дії' }
]

const getActions = (row: any) => [
    [{
        label: 'Редагувати',
        icon: 'i-heroicons-pencil-square-20-solid',
        onSelect: () => navigateTo(`/admin/blog/posts/${row.id}/edit`)
    },
        {
            label: 'Видалити',
            icon: 'i-heroicons-trash-20-solid',
            onSelect: () => deletePost(row.id)
        }]
]

const getPosts = () => {
    fetch('http://localhost:8000/api/admin/blog/posts')
        .then(r => r.json())
        .then(data => { posts.value = data.data })
}

const deletePost = (id: number) => {
    if (confirm('Видалити пост?')) {
        fetch(`http://localhost:8000/api/admin/blog/posts/${id}`, { method: 'DELETE' })
            .then(() => getPosts())
    }
}

getPosts()
</script>
