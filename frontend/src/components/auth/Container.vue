<template>
    <div class="columns">
        <div class="column is-4-widescreen is-5-desktop container is-8-tablet">
            <div class="box">
                <h3 class="title is-4">{{ title }}</h3>
                <slot />
            </div>
        </div>
    </div>  
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        }
    }
};
</script>

<style scoped>
* {
  box-sizing: border-box;
}

.columns {
  padding: 40px;
}

.box {
  padding: 54px 72px;
  box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  font-family: 'Roboto', Arial, serif;
  text-align: center;
}

.title {
  margin-bottom: 32px;
  color: #0a2044;
  font-weight: 500;
}

.subtitle {
  color: #8a94a6;
  font-size: 14px;
}

.link {
  color: #0e58cf;
  font-weight: 500;
}

.button-wide {
  width: 100%;
}
@media screen and (max-width: 414px) {
    .box{
        padding: 20px;
    }
}
</style>
