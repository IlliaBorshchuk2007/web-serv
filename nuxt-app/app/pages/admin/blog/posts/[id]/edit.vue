<template>
    <div class="container mt-4">
        <h1>Редагувати пост</h1>
        <UForm :schema="schema" :state="form" @submit="update">
            <UFormField label="Заголовок" name="title">
                <UInput v-model="form.title" />
            </UFormField>
            <UFormField label="Slug" name="slug" class="mt-3">
                <UInput v-model="form.slug" />
            </UFormField>
            <UFormField label="Контент" name="content_raw" class="mt-3">
                <UTextarea v-model="form.content_raw" :rows="5" />
            </UFormField>
            <UFormField name="is_published" class="mt-3">
                <UCheckbox v-model="form.is_published" label="Опубліковано" />
            </UFormField>
            <div class="mt-3">
                <UButton type="submit">Зберегти</UButton>
                <UButton to="/admin/blog/posts" color="neutral" variant="ghost" class="ms-2">Назад</UButton>
            </div>
        </UForm>
    </div>
</template>

<script setup lang="ts">
import { z } from 'zod'

const route = useRoute()

const schema = z.object({
    title: z.string().min(3, 'Заголовок мінімум 3 символи'),
    slug: z.string().optional(),
    content_raw: z.string().optional(),
    is_published: z.boolean().optional(),
})

const form = ref({ title: '', slug: '', content_raw: '', is_published: false })

const getPost = async () => {
    const data: any = await $fetch(`http://localhost:8000/api/admin/blog/posts/${route.params.id}`)
    form.value = {
        title: data.data.title,
        slug: data.data.slug,
        content_raw: data.data.content_raw ?? '',
        is_published: Boolean(data.data.is_published),
    }
}

const update = async () => {
    try {
        const data: any = await $fetch(`http://localhost:8000/api/admin/blog/posts/${route.params.id}`, {
            method: 'PUT',
            body: form.value
        })
        if (data.success) {
            navigateTo('/admin/blog/posts')
        }
    } catch (e) {
        console.error('Помилка:', e)
    }
}

onMounted(() => getPost())
</script>
