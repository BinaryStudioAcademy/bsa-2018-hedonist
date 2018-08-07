import axios from 'axios';
import store from '../store';
import authCookie from './auth';
import configuration from '../config';

const httpService = axios.create({
    baseURL: process.env.HOST,
    timeout: configuration.TIMEOUT
});

httpService.interceptors.request.use(config => {
        if (store.getters.token) {
            config.headers['X-Token'] = authCookie.getToken()
        }
        return config;
    },
    error => {
        Promise.reject(error);
    });

httpService.interceptors.response.use(
    response => {
        return response.data;
    },
    error => {
        return Promise.reject(error);
    }
);

export default httpService;