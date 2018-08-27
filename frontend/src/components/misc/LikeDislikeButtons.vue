<template>
    <div class="level is-mobile" :style="{fontSize}">
        <div class="level-left">
            <div
                class="likable like level-item"
                :class="{active: status === statusLiked}"
            >
                <span 
                    class="likable-amount"
                    @click="$emit('likedUsers')"
                >
                    {{ likes }}
                </span>
                <span 
                    class="fa-stack fa-2x"
                    @click="$emit('like')"
                >
                    <i class="fa fa-heart fa-stack-1x" />
                </span>
            </div>
            <div
                class="likable dislike level-item"
                :class="{active: status === statusDisliked}"
            >
                <span 
                    class="likable-amount"
                    @click="$emit('dislikedUsers')"
                >
                    {{ dislikes }}
                </span>
                <span 
                    class="fa-stack fa-2x"
                    @click="$emit('dislike')"
                >
                    <i class="fa fa-heart fa-stack-1x" />
                    <i class="fa fa-bolt fa-stack-1x fa-inverse" />
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import {STATUS_LIKED, STATUS_DISLIKED} from '@/services/api/codes';

export default {
    name: 'LikeDislikeButtons',

    data: function () {
        return {
            statusLiked: STATUS_LIKED,
            statusDisliked: STATUS_DISLIKED
        };
    },

    props: {
        status: {
            required: true,
            type: String
        },
        likes: {
            required: true,
            type: Number
        },
        dislikes: {
            required: true,
            type: Number
        },
        fontSize: {
            required: false,
            type: String,
            default: '1rem'
        },
    }
};
</script>

<style lang="scss" scoped>
    .likable {
        cursor: pointer;

        .likable-amount {
            color: inherit;
            font-size: 1.5em;
            font-weight: bolder;
        }

        & :hover {
            .fa-heart {
                color: black;
            }
        }
    }

    .likable-amount {
        margin-right: 5px;
    }

    .active {
        color: rgba(22, 125, 240, 0.7);
        .likable-amount {
            color: rgb(22, 125, 240);
        }

        & :hover {
            .fa-heart {
                color: rgb(22, 125, 240);
            }
        }
    }

    .fa-bolt {
        top: -5%;
        left: 2%;
        font-size: 70%;
    }
</style>
