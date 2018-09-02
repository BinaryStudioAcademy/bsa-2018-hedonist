<template>
    <div>
        <GeneralInfo />
        <ListsContainer />
        <ReviewsContainer />
    </div>
</template>

<script>
import {mapState, mapActions, mapGetters} from 'vuex';
import GeneralInfo from '@/components/users/GeneralInfo';
import ListsContainer from '@/components/users/ListsContainer';
import ReviewsContainer from '@/components/users/ReviewsContainer';

export default {
    name: 'OtherUserPage',
    components: {
        GeneralInfo,
        ListsContainer,
        ReviewsContainer
    },
    data(){
        return{

        };
    }
};
</script>

<style scoped>

</style>