import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import path from 'path';

export default defineConfig({
	root: '',
	base: '',
	server: {
		https: {
			key: '/etc/ssl/cert-key.pem',
			cert: '/etc/ssl/cert.pem',
		},
		host: '0.0.0.0',
		port: 5173,
		strictPort: true,
	},
	resolve: {
		extensions: ['.ts', '.js'],
	},
	plugins: [tailwindcss()],
	build: {
		manifest: true,
		outDir: 'dist',
		emptyOutDir: true,
		rollupOptions: {
			input: {
				main: path.resolve(__dirname, 'assets/scripts/main.ts'),
				styles: path.resolve(__dirname, 'assets/styles/main.css'),
				fonts: path.resolve(__dirname, 'assets/styles/fonts.css'),
			},
		},
	},
});
