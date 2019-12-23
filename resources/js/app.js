import Swal from 'sweetalert2';
import vSelect from 'vue-select';
import VueRouter from 'vue-router';
import 'vue-select/dist/vue-select.css';
import 'sweetalert2/src/sweetalert2.scss';
import Editor from '@tinymce/tinymce-vue';
import VueProgressBar from 'vue-progressbar';
import { Form, HasError, AlertError } from 'vform';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window._ = require('lodash');

global.moment = require('moment');
require('tempusdominus-bootstrap-4');
import 'tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css';

/**
 * We'll load jQuery plugin which provides support
 * for JavaScript based features.
 */

try {
    window.$ = windows.jQuery = require('jquery');
} catch (e) {}


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
    
window.Vue = require('vue');
window.swal = Swal;

const options = {
    color: '#0062cc',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
        speed: '0.5s',
        opacity: '0.6s',
        termination: 1000
    },
    autoRevert: true,
    location: 'top',
    inverse: false
};

Vue.use(VueRouter);
Vue.use(VueProgressBar, options);

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('editor', Editor);
Vue.component('v-select', vSelect);
Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const routes = [
    { path: '/admin', redirect: '/admin/dashboard' },
    { path: '/admin/dashboard', component: require('./components/DashboardComponent.vue').default },
    { path: '/admin/categories', component: require('./components/CategoryComponent.vue').default },
    { path: '/admin/tags', component: require('./components/TagComponent.vue').default },
    { path: '/admin/posts', component: require('./components/PostComponent.vue').default },
    { path: '/admin/posts/create', component: require('./components/AddOrEditPostComponent.vue').default },
    { path: '/admin/posts/edit/:postId', component: require('./components/AddOrEditPostComponent.vue').default },
    { path: '/admin/posts/view/:postId', component: require('./components/ViewPostComponent.vue').default },
    { path: '/admin/users', component: require('./components/UserComponent.vue').default },
    { path: '/admin/users/view/:userId', component: require('./components/ViewUserComponent.vue').default },
    { path: '/admin/user/settings', component: require('./components/EditUserComponent.vue').default },
];

const router = new VueRouter({
    routes,
    mode: 'history'
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
});
