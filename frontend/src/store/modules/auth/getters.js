import StorageService from '@/services/common/storageService';

export default {
    hasToken: () => () => StorageService.hasToken(),
    getToken: () => () => StorageService.getToken(),
};
