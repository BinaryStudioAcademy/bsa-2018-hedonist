<template>
    <div class="wrapper">
        <figure class="image is-4by3">
            <img src="" />
        </figure>
        <div class="level list-data is-mobile">
            <div class="list-data__avatar level-item">
                <figure class="image is-32x32">
                    <img :src="" />
                </figure>
            </div>
            <div class="list-data__creator-name level-item">
                by
            </div>
            <div class="list-data__updated-at">
                Updated at:
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ListHeader",
        props: {
            listItem:{
                required:true,
                type: Object
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>