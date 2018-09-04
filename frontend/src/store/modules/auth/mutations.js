import StorageService from '../../../services/common/storageService';
import { updateWsAuthToken } from '../../../services/common/websocketService';

export default {
    USER_LOGIN: (state, response) => {
        StorageService.setToken(response.access_token);
        state.token = response.access_token;
        state.isLoggedIn = true;
        updateWsAuthToken(response.access_token);
    },
    USER_LOGOUT: (state) => {
        StorageService.removeToken();
        state.token = '';
        state.currentUser = null;
        state.isLoggedIn = false;
    },
    SET_AUTHENTICATED_USER: (state, user) => {
        state.isLoggedIn = true;
        state.currentUser = user;
    },
    REFRESH_TOKEN: (state, token) => {
        state.token = token;
        StorageService.setToken(token);
        updateWsAuthToken(token);
    }
};
