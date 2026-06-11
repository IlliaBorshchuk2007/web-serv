<template>
    <div class="container mt-4">
        <h1>Створити пост</h1>
        <UForm :schema="schema" :state="form" @submit="store">
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

const schema = z.object({
    title: z.string().min(3, 'Заголовок мінімум 3 символи'),
    slug: z.string().optional(),
    content_raw: z.string().optional(),
    is_published: z.boolean().optional(),
})

const form = ref({ title: '', slug: '', content_raw: '', is_published: false })

const store = async () => {
    try {
        const data: any = await $fetch('http://localhost:8000/api/admin/blog/posts', {
            method: 'POST',
            body: form.value
        })
        if (data.success) {
            navigateTo('/admin/blog/posts')
        }
    } catch (e) {
        console.error('Помилка:', e)
    }
}
</script>
