import StorageService from '@/services/common/storageService';

export default {
    hasToken: () => () => StorageService.hasToken(),
    isLoggedIn: (state) => !!state.isLoggedIn,
    getAuthenticatedUser: (state) => state.currentUser,
    getToken: () => () => StorageService.getToken(),
};
