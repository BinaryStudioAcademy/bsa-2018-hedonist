export default {
    clearError: (context) => {
        context.commit('clearError');
    },
    setError: (context, error) => {
        context.commit('setError', error);
    }
}