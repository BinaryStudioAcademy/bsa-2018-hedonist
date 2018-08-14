import StorageService from '@/services/common/storageService';

export default {
    hasToken: () => () => StorageService.hasToken(),
    getAuthenticatedUser: () => () => StorageService.getAuthenticatedUser(),
    getToken: () => StorageService.getToken(),
};