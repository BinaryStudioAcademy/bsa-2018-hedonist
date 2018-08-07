import axios from 'axios';
import store from '../store';
import authCookie from './auth';
import configuration from '../config';
import state from '../state';

const httpService = axios.create({
    baseURL: process.env.HOST,
    timeout: configuration.TIMEOUT
});

httpService.interceptors.request.use(config => {
        if (store.getters.token) {
            config.headers['X-Token'] = authCookie.getToken()
        }
        state.commit('setLoading', true);
        return Promise.resolve(config);
    },
    error => {
        state.commit('setLoading', false);
        state.commit('setError', error);
        Promise.reject(error);
    });

httpService.interceptors.response.use(
    response => {
        state.commit('setLoading', false);
        return Promise.resolve(response.data);
    },
    error => {
        state.commit('setLoading', false);
        state.commit('setError', error);
        return Promise.reject(error);
    }
);

export default httpService;