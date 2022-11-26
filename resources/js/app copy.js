import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'



import EditEvent from './components/Modal.vue'

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

const routes = [{
    path: '/edit-event',
    name: 'EditEvent',
    component: EditEvent
}]
const router = createRouter({
    history: createWebHistory(),
    routes
})


app.use(router).use(BootstrapVue).use(IconsPlugin).mount('#app');