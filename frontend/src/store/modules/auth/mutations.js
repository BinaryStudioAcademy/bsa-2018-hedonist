import StorageService from "../../../services/common/storageService";

export default {
    SET_TOKEN: (state, token) => {
        state.token = token;
    },
    USER_LOGIN: (state, response) => {
        StorageService.setToken(response.token);
        state.token = response.token;
        state.currentUser = response.user;
    },
    USER_LOGOUT: (state) => {
        StorageService.removeToken();
        state.token = '';
        state.currentUser = null;
    },
    SET_AUTHENTICATED_USER: (state, user) => {
        state.currentUser = user;
    }
}