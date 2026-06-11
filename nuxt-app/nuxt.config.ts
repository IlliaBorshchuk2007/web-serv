export default defineNuxtConfig({
    compatibilityDate: '2025-07-15',
    devtools: { enabled: true },
    modules: ['@nuxt/ui'],
    nitro: {
        devProxy: {
            '/laravel-api': {
                target: 'http://localhost:8000/api',
                changeOrigin: true,
                prependPath: true,
            }
        }
    }
})
