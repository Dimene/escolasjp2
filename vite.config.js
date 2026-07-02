// vite.config.js
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js'),
    },
  },
  server: {
    host: true,           // aceita qualquer hostname local
    port: 5173,           // porta padrão Vite
    strictPort: true,
    https: false,         // HTTP, para dev local simplificado
    allowedHosts: [
      'escola2025.test',  // o host que você usa no Tenet
      'localhost',
    ],
  },
});
