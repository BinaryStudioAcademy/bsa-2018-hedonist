import LaravelEcho from 'laravel-echo';
import storageService from './storageService';

window.Pusher = require('pusher-js');

const initLaravelEcho = () => {
    let options = {
        broadcaster: 'pusher',
        key: process.env.PUSHER_APP_KEY,
        cluster: process.env.PUSHER_APP_CLUSTER,
        encrypted: true,
        namespace: process.env.APP_EVENTS_NAMESPACE,
        auth: {
            headers: {}
        }
    };

    if (storageService.getToken()) {
        options.auth.headers = {
            Authorization: 'Bearer ' + storageService.getToken()
        };
    }

    return new LaravelEcho(options);
};

window.Echo = initLaravelEcho();

export const updateWsAuthToken = (token) => {
    Echo.connector.pusher.config.auth.headers.Authorization = 'Bearer ' + token;
};

Pusher.log = (m) => console.log(m);
