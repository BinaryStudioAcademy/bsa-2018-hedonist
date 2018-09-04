<template>
    <div>
        <Preloader :active="isLoading" />
        <GeneralInfo />
        <ListsContainer />
        <ReviewsContainer />
    </div>
</template>

<script>
import {mapActions} from 'vuex';
import Preloader from '@/components/misc/Preloader';
import GeneralInfo from '@/components/users/GeneralInfo';
import ListsContainer from '@/components/users/ListsContainer';
import ReviewsContainer from '@/components/users/ReviewsContainer';

export default {
    name: 'OtherUserPage',
    components: {
        Preloader,
        GeneralInfo,
        ListsContainer,
        ReviewsContainer
    },
    data(){
        return{
            isLoading: true,
            loadingTime: 2000
        };
    },
    created() {
        setTimeout(()=>{
            this.isLoading = false;
        },this.loadingTime);
    },
    loaded: function() {
        return !(this.isLoading);
    }
};
</script>

<style scoped>

</style>