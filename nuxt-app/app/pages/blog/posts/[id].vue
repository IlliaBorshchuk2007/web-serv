    <template>
    <div class="container mt-4">
        <div v-if="post" class="card">
            <div class="card-body">
                <h1 class="card-title">{{ post.title }}</h1>
                <p><strong>Автор:</strong> {{ post.user?.name }}</p>
                <p><strong>Категорія:</strong> {{ post.category?.title }}</p>
                <p><strong>Дата публікації:</strong> {{ post.published_at }}</p>
                <div v-html="post.content"></div>
                <a href="/blog-posts" class="btn btn-secondary mt-3">Назад</a>
            </div>
        </div>
        <div v-else>
            <p>Завантаження...</p>
        </div>
    </div>
</template>

<script setup lang="ts">
    const route = useRoute();
    const post = ref(null);

    const getPost = () => {
        fetch(`http://127.0.0.1:8000/api/blog/posts/${route.params.id}`)
            .then(response => response.json())
            .then(data => {
                post.value = data;
            });
    };

    getPost();
</script>
