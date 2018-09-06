<template>
    <section class="hero is-medium">
        <div class="hero-body">
            <div class="container">
                <h2 class="subtitle has-text-centered">
                    This profile is private :(
                </h2>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'PrivateProfile'
};
</script>

<style scoped>
    .hero {
        background: #ffffff;
        height: calc(100vh - 52px);
        display: block;
        overflow: hidden;
    }
    .subtitle {
        font-size: 2rem;
    }
</style>