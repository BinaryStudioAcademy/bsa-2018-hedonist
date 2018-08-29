<template>
    <section>
        <PlaceVisitedPreview
            v-for="(checkInId, index) in checkIns.allIds"
            :key="checkInId"
            :check-in="getCheckInById(checkInId)"
            :check-in-place="getPlaceByCheckInId(checkInId)"
            :timer="50 * (index+1)"
        />
    </section>
</template>

<script>
import { mapGetters } from 'vuex';
import PlaceVisitedPreview from '@/components/place/PlaceVisitedPreview';

export default {
    name: 'CheckInsContainer',

    components: {
        PlaceVisitedPreview
    },

    props: {
        checkIns: {
            required: true,
            type: Object
        }
    },

    computed: {
        ...mapGetters('history', [
            'getCheckInById',
            'getPlaceByCheckInId',
        ])
    }
};
</script>

<style lang="scss" scoped>
    
</style>
