export const STATUS_LIKED = 'LIKED';
export const STATUS_DISLIKED = 'DISLIKED';
export const STATUS_NONE = 'NONE';
export const likeStatus = {STATUS_NONE,STATUS_LIKED,STATUS_DISLIKED};

export default {
    places: [],
    liked: STATUS_NONE,
    currentPlace: null,
};
