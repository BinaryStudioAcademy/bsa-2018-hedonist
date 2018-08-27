export default {
    getReviewSchema: () => {
        return {
            created_at: '',
            description: '',
            dislikes: 0,
            like: 'NONE',
            likes: 0,
            user_id: 0
        };
    },
    reviews: {},
    users: {}
};
