import axios from 'axios';
import storageService from './storageService';

export class HttpService {
    constructor() {
        this.axios = axios.create({
            baseURL: '/api/v1/'
        });

        this.axios.interceptors.request.use(
            config => {
                if (storageService.getToken()) {
                    config.headers['Authorization'] = 'Bearer ' + storageService.getToken();
                }

                config.headers['X-Socket-ID'] = Echo.socketId();

                return Promise.resolve(config);
            },
            error => {
                return Promise.reject(error);
            }
        );
    }

    get(url, params) {
        return this.axios.get(url, params);
    }

    post(url, data) {
        return this.axios.post(url, data);
    }

    put(url, data) {
        return this.axios.put(url, data);
    }

    delete(url, params) {
        return this.axios.delete(url, params);
    }

    makeQueryUrl = (url, params) => {
        let queryUrl = url;
        let stringifiedParams = Object.keys(params).reduce(
            (stringParamsArray, paramName) => {
                if (params[paramName] !== undefined) {
                    stringParamsArray.push(
                        encodeURIComponent(paramName) + '=' + encodeURIComponent(params[paramName])
                    );
                }
                return stringParamsArray;
            },
            []
        );
        let query = stringifiedParams.join('&');
        if (query) {
            queryUrl += '?' + query;
        }
        return queryUrl;
    };
}

export default new HttpService();