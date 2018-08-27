<template>
    <form @submit.prevent>
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">Likes or dislikes</p>
            </header>
            <section class="modal-card-body">
                <p>Users</p>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Close</button>
            </footer>
        </div>
    </form>    
</template>

<script>
export default {
    name: 'ReviewUsersLikedModal'
};
</script>

<style lang="scss" scoped>
    .modal-card-title {
        text-align: center;
    }
    
    .modal-card-body {
        display: flex;
        justify-content: space-between;
        width: 460px;
    }
</style>
