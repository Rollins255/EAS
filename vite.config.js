import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'
globalThis.structuredClone = globalThis.structuredClone || (obj => JSON.parse(JSON.stringify(obj)));


// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
  },
  server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    watch: {
      usePolling: true,
    }
  },
  define: {
    'import.meta.env.TEST': JSON.stringify(process.env.NODE_ENV === 'test'),
  },
  test:{
    globals:true,
    environment:'happy-dom'
  }
})
