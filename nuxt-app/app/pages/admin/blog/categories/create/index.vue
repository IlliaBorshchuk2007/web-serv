<template>
    <div class="container mt-4">
        <h1>Створити категорію</h1>
        <UForm :schema="schema" :state="form" @submit="store">
            <UFormField label="Назва" name="title">
                <UInput v-model="form.title" />
            </UFormField>
            <UFormField label="Slug" name="slug" class="mt-3">
                <UInput v-model="form.slug" />
            </UFormField>
            <UFormField name="is_published" class="mt-3">
                <UCheckbox v-model="form.is_published" label="Опубліковано" />
            </UFormField>
            <div class="mt-3">
                <UButton type="submit">Зберегти</UButton>
                <UButton to="/admin/blog/categories" color="neutral" variant="ghost" class="ms-2">Назад</UButton>
            </div>
        </UForm>
    </div>
</template>

<script setup lang="ts">
import { z } from 'zod'

const schema = z.object({
    title: z.string().min(3, 'Назва мінімум 3 символи'),
    slug: z.string().optional(),
    is_published: z.boolean().optional(),
})

const form = ref({ title: '', slug: '', is_published: false })

const store = async () => {
    console.log('is_published:', form.value.is_published)  // ← додай
    try {
        const data: any = await $fetch('http://localhost:8000/api/admin/blog/categories', {
            method: 'POST',
            body: {
                title: form.value.title,
                slug: form.value.slug,
                is_published: form.value.is_published,  // ← явно передай
            }
        })
        if (data.success) {
            navigateTo('/admin/blog/categories')
        }
    } catch (e) {
        console.error('Помилка:', e)
    }
}
</script>
