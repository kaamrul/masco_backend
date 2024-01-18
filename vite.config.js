import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel([
            'resources/js/app.js',
            'resources/admin_assets/js/select2.js',

            //Admin Main
            'resources/admin_assets/sass/app.scss',
            'resources/admin_assets/js/app.js',

            // Address
            'resources/admin_assets/js/pages/address/autofill.js',
            'resources/admin_assets/js/pages/address/index.js',


            // Config
            'resources/admin_assets/js/pages/config/dropdown/index.js',
            'resources/admin_assets/js/pages/config/dropdown/list.js',

            'resources/admin_assets/js/pages/config/email/index.js',

            'resources/admin_assets/js/pages/config/email_signature/index.js',
            'resources/admin_assets/js/pages/config/email_signature/update.js',

            'resources/admin_assets/js/pages/config/email_template/index.js',
            'resources/admin_assets/js/pages/config/email_template/update.js',

            'resources/admin_assets/js/pages/config/role/index.js',

            'resources/admin_assets/js/pages/config/location/index.js',

            //===== Employee Start ======//
            'resources/admin_assets/js/pages/employee/index.js',
            'resources/admin_assets/js/pages/employee/create.js',
            'resources/admin_assets/js/pages/employee/update.js',
            'resources/admin_assets/js/pages/employee/show.js',
            'resources/admin_assets/js/pages/employee/ticket/index.js',
            // Employee Attachment
            'resources/admin_assets/js/pages/employee/attachment/index.js',
            // Employee Ticket
            'resources/admin_assets/js/pages/employee/ticket/index.js',

            // Asset Assigned
            'resources/admin_assets/js/pages/employee/index.js',

            'resources/admin_assets/js/jquery.easing.js',
            //===== Employee End ======//

            // Event
            // 'resources/admin_assets/js/pages/event/index.js',
            // 'resources/admin_assets/js/pages/event/create.js',

            // FAQ
            // 'resources/admin_assets/js/pages/faq/index.js',

            // Logs
            'resources/admin_assets/js/pages/logs/activity_log.js',
            'resources/admin_assets/js/pages/logs/login_history.js',
            'resources/admin_assets/js/pages/logs/email_history.js',

            // Notifications
            'resources/admin_assets/js/pages/notification/index.js',
            'resources/admin_assets/js/pages/notification/create.js',
            'resources/admin_assets/js/pages/notification/show.js',

            //Profile
            'resources/admin_assets/js/pages/profile/all_nofification.js',

            // Tickets
            'resources/admin_assets/js/pages/ticket/index.js',
            'resources/admin_assets/js/pages/ticket/create.js',
            'resources/admin_assets/js/pages/ticket/show.js',
            'resources/admin_assets/js/pages/ticket/all.js',

            // Report
            'resources/admin_assets/js/pages/report/stock.js',
            'resources/admin_assets/js/pages/report/order.js',
            'resources/admin_assets/js/pages/report/expense.js',
            'resources/admin_assets/js/pages/report/withdraw.js',
            'resources/admin_assets/js/pages/report/user.js',



            'resources/admin_assets/js/pages/home/dashboard.js',

            'resources/admin_assets/js/pages/home/dashboard.js',
            'resources/admin_assets/js/pages/employee/ams/index.js'
        ]),
    ],
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js',
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '@': '/resources/js',
        }
    },
    build: {
        rollupOptions: {
            output: {
                assetFileNames: (asset) => {
                    let typePath = 'styles'
                    const type = asset.name.split('.').at(1)
                    if (/png|jpe?g|webp|svg|gif|tiff|bmp|ico/i.test(type)) {
                        typePath = 'images'
                    }
                    return `${typePath}/[name]-[hash][extname]`
                },
                chunkFileNames: 'scripts/chunks/[name]-[hash].js',
                entryFileNames: 'scripts/[name]-[hash].js',
            },
        },
    },
});
