<template>
    <div class="control">
        <b-dropdown
            v-model="language"
            :mobile-modal="false"
            hoverable
            @input="changeLang"
            class="language-menu"
        >
            <button class="button current-language" type="button" slot="trigger">
                <template>
                    <span :class="['language-item__icon', currentLangClass]" />
                </template>
            </button>

            <b-dropdown-item class="language-item" value="en">
                <span class="language-item__icon language-item__icon_en" />
            </b-dropdown-item>

            <b-dropdown-item class="language-item" value="ua">
                <span class="language-item__icon language-item__icon_ua" />
            </b-dropdown-item>

            <b-dropdown-item class="language-item" value="ru">
                <span class="language-item__icon language-item__icon_ru" />
            </b-dropdown-item>
        </b-dropdown>
    </div>
</template>

<script>
export default {
    name: 'LanguageSelector',
    data () {
        return {
            language: this.$i18n.locale()
        };
    },
    methods: {
        changeLang () {
            this.$i18n.set(this.language);
        }
    },
    computed: {
        currentLangClass() {
            return 'language-item__icon_' + this.language;
        }
    }
};
</script>

<style lang="scss">
    .language-menu {
        .dropdown-content {
            width: 60px;

            @media screen and (max-width: 911px) {
                width: 100%;
                display: flex;
                justify-content: space-between;
                border: none;
                box-shadow: none;
                padding: 0 20px;
            }
        }
        .dropdown-menu {
            @media screen and (max-width: 911px) {
                display: block;
                padding: 0;
            }
        }
        .current-language {
            background-color: #167df0;
            border: none;
            box-shadow: none;

            &:focus:not(:active), &.is-focused:not(:active) {
                border: none;
                box-shadow: none;
            }

            @media screen and (max-width: 911px) {
                display: none;
            }
        }

        .language-item {
            height: 40px;
            padding: 10px 15px;

            &:hover {
                background-color: #b9c2cc;
            }

            &.is-active{
                background-color: #90c1f7;
            }

            &__icon {
                display: inline-block;
                width: 30px;
                height: 20px;
                background: url('../../assets/lang_icons.png') no-repeat;

                &_en {
                     background-position: -10px -10px;
                }

                &_ru {
                     background-position: -60px -10px;
                }

                &_ua {
                     background-position: -10px -50px;
                }
            }

            @media screen and (max-width: 911px) {
                padding: 10px;
            }
        }
    }

</style>
