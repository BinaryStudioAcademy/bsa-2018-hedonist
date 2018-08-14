<template>
    <div class="navbar-start">
        <div class="navbar-item">
            <div class="control has-icons-right" v-bind:class="{'show-list': isShow}" v-click-outside="onClickOutside">
                <input class="input" type="search" placeholder="I'm looking for..." v-model="search" v-on:focus="getCategories">
                <span class="icon is-right">
                    <i class="fas fa-caret-down"></i>
                </span>
                <ul class="place-category-list">
                    <li v-for="category in categories" :key="category.id">
                        <a href="#">{{ category.name }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-item">
            <div class="control">
                <input class="input" type="search" value="Lviv, UA">
            </div>
        </div>
        <div class="navbar-item is-paddingless navbar-search-btn">
            <span class="icon is-large">
                <i class="fas fa-lg fa-search"></i>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SearchInput",
        data() {
            return {
                search: '',
                isShow: false,
                categories: [
                    {
                        id: 1,
                        name: 'Restaurant'
                    },
                    {
                        id: 2,
                        name: 'Bar'
                    }
                ]
            }
        },
        methods: {
            getCategories() {
                this.isShow = true;
            },
            onClickOutside() {
                this.isShow = false;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .show-list {
        .input {
            border-radius: 4px 4px 0 0;
        }
        .place-category-list {
            display: block;
        }
    }

    .place-category-list {
        display: none;
        z-index: 999999;
        position: absolute;
        top: 37px;
        width: 100%;
        background: #fff;
        border: 1px solid #7957d5;
        border-top: none !important;
        box-shadow: rgba(0, 0, 0, 0.1) 0 0 2px 0;
        vertical-align: baseline;

        a {
            background: #fff;
            cursor: pointer;
            display: block;
            padding: 5px 10px;
            text-decoration: none;
            zoom: 1;
            color: #333;
            min-height: 32px;
            font-weight: 500;
            font-size: 0.9rem;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        a:hover {
            background: #efeff4;
            color: #4e595d;
        }
    }
</style>