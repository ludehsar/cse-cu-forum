import Swal from 'sweetalert2';
import ReactDOM from 'react-dom';
import DOMPurify from 'dompurify';
import React, { Component } from 'react';
import 'sweetalert2/src/sweetalert2.scss';
import Pagination from "react-js-pagination";
import { Editor } from '@tinymce/tinymce-react';

window.React = React;
window.ReactDOM = ReactDOM;
window.Component = Component;
window.Pagination = Pagination;
window.DOMPurify = DOMPurify;
window.Editor = Editor;

window._ = require('lodash');

global.moment = require('moment');
require('tempusdominus-bootstrap-4');
import 'tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css';

try {
    window.$ = windows.jQuery = require('jquery');
} catch (e) {}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

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

window.swal = Swal;

/**
 * In frontend, we will use reactjs
 */
require('./components/frontend/HomepageComponent');
require('./components/frontend/PostFormComponent');
require('./components/frontend/ShowPostComponent');
require('./components/frontend/ProfileComponent');
