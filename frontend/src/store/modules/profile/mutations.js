export default {
    SET_USER: (state, user) => {
        state.user = user;
    },
    SET_USER_FIRST_NAME: (state, firstName) => {
        state.user.first_name = firstName;
    },
    SET_USER_LAST_NAME: (state, lastName) => {
        state.user.last_name = lastName;
    },
    SET_USER_PHONE: (state, phone) => {
        state.user.phone_number = phone;
    },
    SET_USER_FACEBOOK: (state, facebook) => {
        state.user.facebook_url = facebook;
    },
    SET_USER_INSTAGRAM: (state, instagram) => {
        state.user.instagram_url = instagram;
    },
    SET_USER_TWITTER: (state, twitter) => {
        state.user.twitter_url = twitter;
    },
    SET_USER_DATE_OF_BIRTH: (state, dateOfBirth) => {
        state.user.date_of_birth = dateOfBirth;
    },
    SET_USER_AVATAR: (state, avatarUrl) => {
        state.user.avatar_url = avatarUrl;
    }
};
