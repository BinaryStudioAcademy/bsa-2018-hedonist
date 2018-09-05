<template>
    <div class="btn-follow">
        <a class="button" :class="getClass">
                            <span class="icon is-small">
                                <template v-if="isLoading">
                                    <span class = 'loader'></span>
                                </template>
                                <template v-else>
                                    <i :class="getIconClass"></i>
                                </template>
                            </span>
            <span>Follow {{ name }}</span>
        </a>
    </div>
</template>

<script>
    export default {
        name: "FollowButton",
        props: {
            followed: {
                type: Boolean,
                required: true
            },
            name: {
                type: String,
                required: false,
            }
        },
        data(){
            return {
                isLoading: false,
                failCallback: () => {
                    this.isLoading = false;
                    this.$toast.open({message:'Something went wrong',type:'is-danger'});
                },
                successCallback: () => {
                    this.isLoading = false;
                }
            }
        },
        computed: {
            getClass(){
                return this.followed ? 'is-success' : 'is-info'
            },
            getIconClass(){
                return this.followed ? ['fas', 'fa-check-circle'] : ['fas', 'fa-plus-circle'];
            }
        },
        methods:{

        }
    }
</script>

<style lang="scss" scoped>
    .btn-follow {
        display: flex;
        justify-content: center;
        a {
            width: 250px;
        }
    }
    .loader {
        border: 2px solid #d3d3d3;
        border-top: 2px solid #636b6f;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        background: transparent;
        animation: spin 1s linear infinite;
    }
    .icon {
        margin-right:3px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>