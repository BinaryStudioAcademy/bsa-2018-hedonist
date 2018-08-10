export default {
    mutations: {
        setLoading: (state, isLoading) => {
            state.loading = isLoading;
        },
        setError: (state, error) => {
            state.error = error;
        },
        clearError: state => {
            state.error = null;
        }
    }
}