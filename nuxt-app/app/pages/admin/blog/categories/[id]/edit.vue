<template>
    <div class="container mt-4">
        <h1>Редагувати категорію</h1>
        <UForm :schema="schema" :state="form" @submit="update">
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

const route = useRoute()

const schema = z.object({
    title: z.string().min(3, 'Назва мінімум 3 символи'),
    slug: z.string().optional(),
    is_published: z.boolean().optional(),
})

const form = ref({ title: '', slug: '', is_published: false })

const getCategory = async () => {
    const data: any = await $fetch(`http://localhost:8000/api/admin/blog/categories/${route.params.id}`)
    form.value = {
        title: data.data.title,
        slug: data.data.slug,
        is_published: Boolean(data.data.is_published),
    }
}

const update = async () => {
    console.log('sending:', form.value.is_published)  // ← перевірка
    try {
        const data: any = await $fetch(`http://localhost:8000/api/admin/blog/categories/${route.params.id}`, {
            method: 'PUT',
            body: {
                title: form.value.title,
                slug: form.value.slug,
                is_published: form.value.is_published,
            }
        })
        console.log('response:', data)
        if (data.success) {
            navigateTo('/admin/blog/categories')
        }
    } catch (e) {
        console.error('Помилка:', e)
    }
}

onMounted(() => getCategory())
</script>
