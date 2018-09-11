import { STATUS_NONE } from '@/services/api/codes';

export default {
    places: [],
    places_amount: null,
    currentPlace: null,
    visitors: {
        byId: {},
        allIds: []
    },
    liked: STATUS_NONE
};
