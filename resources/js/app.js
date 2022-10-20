/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp, VueElement } from 'vue';
import 'lodash'
import router from './components/router/index';


/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
app.use(router);

import LaravelVuePagination from 'laravel-vue-pagination';
app.component('Pagination', LaravelVuePagination);
// app.component('Switch', Switch);
// app.component('example-component', ExampleComponent);
// app.component('events-list', EventComponent);
// app.component('dashboard-layout', dashboardLayout);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


Object.entries(import.meta.globEager('./**/*.vue')).forEach(([path, definition]) => {
    app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
});

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');

var alert_del = document.querySelectorAll('.alert-del');
alert_del.forEach((x) =>
  x.addEventListener('click', function () {
    x.parentElement.classList.add('hidden');
  })
);
