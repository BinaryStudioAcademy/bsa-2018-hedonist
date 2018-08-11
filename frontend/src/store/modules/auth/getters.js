import StorageService from '@/services/common/storageService';

export default {
    isLoggedIn: () => StorageService.hasToken(),
    getAuthenticatedUser: () => StorageService.getAuthenticatedUser(),
    getToken: () => StorageService.getToken(),
};
