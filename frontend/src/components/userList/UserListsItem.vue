<template>
        <div class="column is-one-third is-square user-list-container" v-if="show">
            <div class="user-list-content">
                <div class="user-list-name">{{ userList.list_name }}</div>
                <div class="user-list-places-count">{{ userList.places_count }} places saved in the list</div>
                <div class="user-list-button-wrap">
                    <div class="button is-info user-list-button-show-places" @click="open(userList.list_name)">
                        Show places in the list
                    </div>
                </div>
            </div>
            <figure class="image is-square">
                <img :src="userList.img_preview.url">
            </figure>
        </div>
</template>

<script>
    export default {
        name: "UserListsItem",
        data() {
            return {
                show: false
            }
        },
        props: {
            userList: {
                required: true,
                type: Object,
            },
            timer: {
                required: true,
                type: Number,
            }
        },
        methods: {
            open(place_name) {
                this.$toast.open({
                    message: 'action to open the list of places "'+place_name+'"',
                    type: 'is-danger',
                    position: 'is-top'
                });
                this.$router.push('/user/list');
            }
        },
        created() {
            setTimeout(() => {
                this.show = true
            }, this.timer)
        }
    }
</script>

<style lang="scss" scoped>
    .user-list-container {
        position: relative;
    }
    .user-list-content {
        z-index: 1;
        position: absolute;
        left: 0; right: 0; top: 0;
        min-height: 100%;
        padding: 1.5rem;
        color: #ffffff;
        text-shadow: 2px 2px 4px #000, -1px -1px 4px #000;
    }
    .user-list-name {
        font-size: x-large;
        font-weight: 400;
    }
    .user-list-button-wrap {
        position: absolute;
        bottom: 0;
        left: 0;
        padding: 1.5rem;
    }
    .user-list-button-show-places {
        text-shadow: none;
    }
</style>