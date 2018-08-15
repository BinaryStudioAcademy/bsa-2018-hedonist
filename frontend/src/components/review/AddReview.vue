<template>
    <div>
        <div v-if="isUserLoggedIn" class="add-review">
            <b-field class="media">

                <div class="media-left">
                    <img
                        src="https://ss0.4sqi.net/img/venuepage/v2/add_tip_blank_avatar@2x-4321684c656168f26ae9208901a9d83e.png"
                        height="32"
                        width="32"
                    >
                </div>

                <b-field class="media-content">
                    <b-input maxlength="200" type="textarea"></b-input>
                </b-field>

                <div class="media-right">
                    <button
                        class="button is-primary"
                    >Post</button>
                </div>
            </b-field>
        </div>
        <div v-else class="add-review media">
            <div class="media-left">
                <img
                    src="https://ss0.4sqi.net/img/venuepage/v2/add_tip_blank_avatar@2x-4321684c656168f26ae9208901a9d83e.png"
                    height="32"
                    width="32"
                >
            </div>
            <span class="media-content">
                <a>Login</a>, to leave a review.
            </span>
            <div class="add-review-btn media-right">
                <button
                    class="button is-primary"
                    disabled
                >Post</button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: "AddReview",
    computed: {
        ...mapGetters({isUserLoggedIn: 'hasToken'}),
    }
}
</script>

<style scoped>
    .add-review {
        padding: 15px;
        align-items: center;
    }
</style>