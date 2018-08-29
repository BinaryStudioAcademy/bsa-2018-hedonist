<template>
    <section>
        <PlacePreview
            v-for="(checkInId, index) in checkIns.allIds"
            :key="checkInId"
            :check-in="getCheckInById(checkInId)"
            :place="getPlaceByCheckInId(checkInId)"
            :timer="50 * (index+1)"
        />
    </section>
</template>

<script>
import { mapGetters } from 'vuex';
import PlacePreview from '@/components/place/PlacePreview';

export default {
    name: 'CheckInsContainer',

    components: {
        PlacePreview
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
