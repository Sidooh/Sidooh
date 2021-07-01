import axios from 'axios';
import {BASE_URL} from "../constants";
import Vue from 'vue';
import store from "../store";
import logger from "../helpers/logger";


const httpClient = axios.create({
    // baseURL: process.env.app_url,
    baseURL: BASE_URL,
    // timeout: 10000, // indicates, 1000ms ie. 1 second
    headers: {
        "Content-Type": "application/json",
        "showLoader": true
        // anything you want to add to the headers
    },
});

const getAuthToken = () => localStorage.getItem('token');

const authInterceptor = (config) => {
    config.headers['Authorization'] = 'Bearer ' + getAuthToken();
    return config;
}

httpClient.interceptors.request.use(authInterceptor);

httpClient.interceptors.request.use(config => {
        if (config.headers['showLoader']) {
            store.dispatch('loader/pending');
        }
        return config;
    },
    error => {
        if (error.config.headers['showLoader']) {
            store.dispatch('loader/done');
        }
        return Promise.reject(error);
    });

// interceptor to catch errors
const errorInterceptor = error => {
    if (error.response.config.headers['showLoader']) {
        store.dispatch('loader/done');
    }

    // check if it's a server error
    if (!error.response) {

        Vue.notify({type: 'warn', text: 'Network/Server error'});

        return Promise.reject(error);
    }

    // all the other error responses
    switch (error.response.status) {
        case 503:
            Vue.notify({type: 'warn', text: error.response.data.message, title: 'Oops!'});
            break;

        case 400:
            logger.error(error.response.status, error.message);
            Vue.notify({type: 'warn', text: 'Nothing to display', title: 'Data Not Found'});
            break;

        case 401: // authentication error, logout the user
            Vue.notify({type: 'warn', text: 'Please login again', title: 'Session Expired'});
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            // router.push('/login');
            // window.location.assign('/login')
            break;

        case 404:
            logger.error(error.response.status, error.message);
            // Vue.notify({type: 'warn', text: error.response.data.message, title: 'Data Not Found'});
            break;

        case 422: // validation errors
            Vue.notify({type: 'info', text: 'Please check the form for errors.', title: 'Invalid inputs'});
            //TODO: Add class to handle this
            // throw ValidationError
            break;

        default:
            logger.error(error.response.status, error.message);
            Vue.notify({type: 'error', text: 'Server Error'});

    }
    return Promise.reject(error);
}

// Interceptor for responses
const responseInterceptor = response => {
    if (response.config.headers['showLoader']) {
        store.dispatch('loader/done');
    }

    switch (response.status) {
        case 200:
            // yay!
            break;
        // any other cases
        default:
        // default case
    }

    return response;
}

httpClient.interceptors.response.use(responseInterceptor, errorInterceptor);

export default httpClient;
