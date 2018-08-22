import reviewState from './state';

export default {
    ADD_REVIEW: (state, review) => {

        let newReview = review;

        newReview.user = {
            avatar_url:"http://www.piketec.com/web/medien/bilder/automotive-testing_1511958981/automotive-testing.png",
            email:"test@test.com",
            first_name:"TEST",
            id:2,
            last_name:"TEST",
        };

        reviewState.reviews.push(newReview);
    },
};


