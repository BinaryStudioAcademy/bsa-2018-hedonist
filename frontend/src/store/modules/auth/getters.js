import StorageService from '@/services/common/storageService';

export default {
    isLoggedIn: (state) => {
        let stub = state.token;
        return StorageService.hasToken();
    },
    getAuthenticatedUser: () => StorageService.getAuthenticatedUser(),
    getToken: () => StorageService.getToken(),
};
