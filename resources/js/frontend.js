import Swal from 'sweetalert2';
import ReactDOM from 'react-dom';
import DOMPurify from 'dompurify';
import React, { Component } from 'react';
import 'sweetalert2/src/sweetalert2.scss';
import Pagination from "react-js-pagination";
import { Editor } from '@tinymce/tinymce-react';
import LazyLoad from 'react-lazyload';
import Datetime from 'react-datetime';
import 'react-datetime/css/react-datetime.css';
import Select from 'react-select'
import CreatableSelect from 'react-select/creatable';

window.swal = Swal;
window.React = React;
window.Editor = Editor;
window.Select = Select;
window.LazyLoad = LazyLoad;
window.Datetime = Datetime;
window.ReactDOM = ReactDOM;
window.Component = Component;
window.DOMPurify = DOMPurify;
window.Pagination = Pagination;
window.CreatableSelect = CreatableSelect;

window._ = require('lodash');

global.moment = require('moment');

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


/**
 * In frontend, we will use reactjs
 */

require('./components/frontend/HomepageComponent');
require('./components/frontend/PostFormComponent');
require('./components/frontend/ShowPostComponent');
require('./components/frontend/ProfileComponent');
require('./components/frontend/SettingsComponent');
