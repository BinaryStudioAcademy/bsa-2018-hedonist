import StorageService from '@/services/common/storageService';

export default {
    isLoggedIn: (state) => {
        return StorageService.hasToken() || !!state.token;
    },
    getAuthenticatedUser: () => StorageService.getAuthenticatedUser(),
    getToken: () => StorageService.getToken(),
};
