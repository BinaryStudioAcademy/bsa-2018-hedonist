export default {
    state: {
        loading: false,
        error: null
    },
    getters: {
        loading (state) {
            return state.loading;
        },
        error (state) {
            return state.error;
        }
    },
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
    },
    actions: {
        clearError: (context) => {
            context.commit('clearError');
        },
        setError: (context, error) => {
            context.commit('setError', error);
        }
    }
}