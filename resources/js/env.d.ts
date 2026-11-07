/// <reference types="vite/client" />

interface Window {
    axios: import('axios').AxiosInstance;
}

declare module '*.vue' {
    import type { DefineComponent } from 'vue';

    const component: DefineComponent<object, object, unknown>;

    export default component;
}
