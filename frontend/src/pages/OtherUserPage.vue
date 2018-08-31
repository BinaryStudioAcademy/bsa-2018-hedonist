<template>
    <div>
        <GeneralInfo />
        <ListsContainer />
    </div>
</template>

<script>
import GeneralInfo from '@/components/users/GeneralInfo';
import ListsContainer from '@/components/users/ListsContainer';

export default {
    name: 'OtherUserPage',
    components: {
        GeneralInfo,
        ListsContainer
    },
};
</script>

<style scoped>

</style>