import axios from 'axios';
import storageService from "./storageService";

export class HttpService {
    constructor() {
        this.axios = axios.create({
            baseURL: '/api/v1/'
        });

        this.axios.interceptors.request.use(
            config => {
                if (storageService.getToken()) {
                    config.headers['Authorization'] = 'Bearer ' + storageService.getToken()
                }
                return Promise.resolve(config);
            },
            error => {
                return Promise.reject(error);
            }
        );

        this.axios.interceptors.response.use(
            error => {
                return error.response;
            }
        )
    }

    get(url, params) {
        return this.axios
            .get(url, params)
            .catch(error => {
                return error.response;
            });
    }

    post(url, data) {
        return this.axios
            .post(url, data)
            .catch(error => {
                return error.response;
            });
    }

    put(url, data) {
        return this.axios
            .put(url, data)
            .catch(error => {
                return error.response;
            });
    }

    delete(url, params) {
        return this.axios
            .delete(url, params)
            .catch(error => {
                return error.response;
            });
    }
}

export default new HttpService();