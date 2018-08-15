import StorageService from '@/services/common/storageService';

export default {
    hasToken: () => () => StorageService.hasToken(),
    getAuthenticatedUser: (state) => state.currentUser,
    getToken: () => () => StorageService.getToken(),
};
