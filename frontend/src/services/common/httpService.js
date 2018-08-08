import axios from 'axios';
import store from '../../store';
import storageService from './storageService';
import state from '../../state';


export const httpService = {
    request(url) {
        axios.request(url)
            .then((resp) => {
                return Promise.resolve(resp);
            })
            .catch(function(err) {
                return Promise.resolve(err);
            });
    },
    authRequest() {
        return authAxios;
    }
};

const authAxios = axios.create({
    baseURL: process.env.HOST,
    timeout: process.env.TIMEOUT || 10000
});

authAxios.interceptors.request.use(config => {
        if (store.getters.token) {
            config.headers['X-Token'] = storageService.getToken()
        }
        state.commit('setLoading', true);
        return Promise.resolve(config);
    },
    error => {
        state.commit('setLoading', false);
        state.commit('setError', error);
        Promise.reject(error);
    });

authAxios.interceptors.response.use(
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