import normalizer from '../../../services/common/normalizerService';

export default {
    SET_USER_LISTS: (state, userLists) => {
        state.userLists = userLists;
    },
};
