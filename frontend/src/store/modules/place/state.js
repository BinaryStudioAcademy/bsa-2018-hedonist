import { STATUS_NONE } from '@/services/api/codes';

export default {
    places: [],
    currentPlace: null,
    visitors: {
        byId: {},
        allIds: []
    },
    liked: STATUS_NONE
};
