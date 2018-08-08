import axios from 'axios';
import storageService from "./storageService";

export class HttpService {
    constructor() {
        this.axios = axios;

        this.authAxios = axios.create({
            baseURL: config.host,
            //timeout: config.TIMEOUT || 10000
        });

        this.authAxios.interceptors.request.use(config => {
                if (storageService.getToken()) {
                    config.headers['Authorization'] = 'Bearer ' + storageService.getToken()
                }
                return Promise.resolve(config);
            },
            error => {
                Promise.reject(error);
            });
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

    static authRequest() {
        return authAxios;
    }
}

export default HttpService();