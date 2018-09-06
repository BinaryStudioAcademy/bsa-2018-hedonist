<template>
    <div class="columns">
        <template
                v-for="user in users"
                :key="user.id"
        >
        </template>
    </div>
</template>

<script>
    export default {
        name: "UserList",
        props: {
            users:{
                type: Array,
                required: true,
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>