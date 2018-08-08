import Vue from 'vue';

export default {
    getUserLocationData(){
        Vue.http.get('userData')
            .then(
                (response) => {
                    success(response.data)
                },
                (response) => {
                    error(response)
                }
            )
    }
}