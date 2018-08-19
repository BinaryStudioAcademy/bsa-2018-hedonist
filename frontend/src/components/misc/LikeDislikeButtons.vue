<template>
    <div class="level is-mobile" :style="{fontSize}">
        <div
                class="likable like level-item"
                @click="$emit('like')"
                :class="{active: like === 'LIKED'}"
        >
            <span class="likable-amount">
                {{likes}}
            </span>
            <span class="fa-stack fa-2x">
                <i class="fa fa-heart fa-stack-1x"/>
            </span>
        </div>
        <div
                class="likable dislike level-item"
                @click="$emit('dislike')"
                :class="{active: like === 'DISLIKED'}"
        >
            <span class="likable-amount">
                {{dislikes}}
            </span>
            <span class="fa-stack fa-2x">
                <i class="fa fa-heart fa-stack-1x"/>
                <i class="fa fa-bolt fa-stack-1x fa-inverse"/>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LikeDislikeButtons",
        props:{
            like:{
                required: true,
                type: String
            },
            likes:{
                required: true,
                type: Number
            },
            dislikes:{
                required: true,
                type: Number
            },
            fontSize:{
                required: false,
                type: String,
                default: '1rem'
            },
        },
    }
</script>

<style lang="scss" scoped>
    .likable {
        cursor: pointer;

        .likable-amount{
            color:inherit;
        }

        & :hover {
            color: black;
        }

    }

    .likable-amount{
        margin-right: 5px;
    }

    .active {
        color: rgba(22,125,240,0.7);
        &:hover, .likable-amount{
            color: rgb(22,125,240);
        }
    }

    .fa-bolt {
        top: -5%;
        left: 2%;
        font-size: 70%;
    }
</style>