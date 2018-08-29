<template>
    <div></div>
</template>

<script>
    import {mapState,mapGetters,mapActions} from 'vuex'

    export default {
        name: "UserListPage",
        created(){
            this.getListById(this.$route.params.id);
        },
        methods:{
            ...mapActions('userList',['getListById'])
        },
    }
</script>

<style scoped>

</style>