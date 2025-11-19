import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import type { DefineComponent } from "vue";
import { createApp, h } from "vue";
import { createPinia } from 'pinia';
import { ZiggyVue } from "ziggy-js";


const pinia = createPinia();

const appName = import.meta.env.VITE_APP_NAME || "Laravel";
createInertiaApp({
    title: (title: any) => (title ? `${title} - ${appName}` : appName),
    resolve: (name: any) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./pages/**/*.vue"),
        ),
    setup({ el, App, props, plugin }: any) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
