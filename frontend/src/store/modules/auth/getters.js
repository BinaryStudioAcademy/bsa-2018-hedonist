export default {
    isLoggedIn: state => !!state.token,
    getAuthenticatedUser: state => state.currentUser,
    getToken: state => state.token,
};