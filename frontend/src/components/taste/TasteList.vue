<template>
    <div class="container">
        <ul>
            <li v-for="(taste, index) in tastes" class="taste"
                v-bind:class="{added: taste.check, pop: taste.isAnimate, popin: !taste.isClick}" :key="taste.id"
                v-bind:style="{ animationDelay: index * 0.02 + 's' }">
                <div class="pill" @click="checkTaste(index)">
                    {{ taste.name }}
                    <i v-if="taste.check" class="fas fa-check"></i>
                    <i v-else class="fas fa-plus"></i>
                </div>
            </li>
        </ul>
        <div class="loadMore">Load more</div>
        <button class="doneButton loggedOut">Save and register</button>
    </div>
</template>

<script>
    export default {
        name: "TasteList",
        data() {
            return {
                timeDelay: 0,
                tastes: [
                    {
                        id: 1,
                        name: 'Craft beer',
                        check: false,
                        isAnimate: false,
                        isClick: false
                    },
                    {
                        id: 2,
                        name: 'Ice-cream',
                        check: false,
                        isAnimate: false,
                        isClick: false
                    },
                    {
                        id: 3,
                        name: 'Live-music',
                        check: false,
                        isAnimate: false,
                        isClick: false
                    },
                    {
                        id: 4,
                        name: 'Sport-bar',
                        check: false,
                        isAnimate: false,
                        isClick: false
                    },
                    {
                        id: 5,
                        name: 'Lunch',
                        check: false,
                        isAnimate: false,
                        isClick: false
                    },
                    {
                        id: 6,
                        name: 'Sushi',
                        check: false,
                        isAnimate: false,
                        isClick: false
                    }
                ]
            }
        },
        methods: {
            checkTaste(index) {
                let taste = this.tastes[index];
                taste.check = !taste.check;
                taste.isClick = true;
                taste.isAnimate = true;
                setTimeout(function () {
                    taste.isAnimate = false;
                }, 200);
            }
        }
    }
</script>

<style lang="scss" scoped>
    @keyframes popin {
        0% {
            transform: scale(0)
        }
        50% {
            transform: scale(1.1)
        }
        100% {
            transform: scale(1)
        }
    }

    @keyframes pop {
        0% {
            transform: scale(1.02)
        }
        50% {
            transform: scale(.9)
        }
        100% {
            transform: scale(1)
        }
    }

    .container {
        border-radius: 3px;
        background: #fff;
        position: relative;
        text-align: center;
        padding: 20px;
    }

    .taste {
        animation-fill-mode: both;
        animation-duration: .2s;
        animation-iteration-count: 1;
        animation-timing-function: ease;

        display: inline-block;
        margin: 0 5px 7px 5px;

        .pill {
            border-radius: 100px;
            background: #2d5be3;
            color: #fff;
            cursor: pointer;
            font-size: 0.9rem;
            line-height: 100%;
            padding: 7px 10px 7px 12px;
            position: relative;

            i {
                margin-left: 5px;
            }
        }
        .pill:hover {
            top: -1px;
        }
    }

    .taste.added {
        .pill {
            background: #f94877;
        }
    }

    .taste.popin {
        animation-name: popin;
    }

    .taste.pop {
        animation-name: pop;
    }

    .loadMore {
        border-radius: 100px;
        background: #efeff4;
        cursor: pointer;
        display: inline-block;
        font-size: 13px;
        line-height: 100%;
        margin: 15px auto;
        padding: 7px 10px 7px 10px;
    }

    .doneButton {
        font-size: 1rem;
        letter-spacing: 0;
        box-shadow: none;
        border-radius: 5px;
        background: #2d5be3;
        border: none;
        clear: both;
        color: #fff;
        cursor: pointer;
        font-weight: 500;
        padding: 15px;
        display: block;
        margin: 10px auto;
        text-align: center;
        width: 200px;
    }
</style>