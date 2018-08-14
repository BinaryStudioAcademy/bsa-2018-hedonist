export default {
    SET_LOADING: (state, isLoading) => {
        state.loading = isLoading;
    },
    setError: (state, error) => {
        state.error = error;
    },
    clearError: state => {
        state.error = null;
    }
};
