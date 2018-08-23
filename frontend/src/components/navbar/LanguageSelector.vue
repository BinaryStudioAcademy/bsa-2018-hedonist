<template>
    <div class="control">
        <div class="select">
            <select v-model="language" @change="changeLang">
                <option value="en" class="lang-item lang-item_en">English</option>
                <option value="ua" class="lang-item lang-item_ua">Українська</option>
                <option value="ru" class="lang-item lang-item_ru">Русский</option>
            </select>
        </div>
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
    }
};
</script>

<style lang="scss" scoped>

</style>
