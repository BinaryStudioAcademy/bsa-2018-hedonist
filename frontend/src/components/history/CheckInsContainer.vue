<template>
    <section>
        <PlaceVisitedPreview
            v-for="(checkInId, index) in checkIns.allIds"
            :key="checkInId"
            :checkin="getCheckInById(checkInId)"
            :place="getPlaceByCheckInId(checkInId)"
            :timer="50 * (index+1)"
        />
        <div class="no-check-ins-text" v-if="checkIns.allIds.length < 1">
            {{ $t('check-ins_page.no-check-ins') }}
        </div>
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
    .no-check-ins-text {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        margin-top: 50px;
    }
</style>
