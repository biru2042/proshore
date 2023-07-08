import './bootstrap';

import { createApp } from "vue";

const app = createApp({});
import EventComponent from './components/EventComponent.vue';
app.component('event-component', EventComponent);

app.mount("#app");