<template>
  <div class="columns">
    <div class="column is-4 is-offset-4">
      <div class="box">
        <h3 class="title is-4">{{ title }}</h3>
        <slot></slot>
      </div>
    </div>
  </div>  
</template>

<script>
export default {
  props: [
    'title'
  ]
}
</script>

<style>
@import url('https://fonts.googleapis.com/css?family=Roboto:400,500');

* {
  box-sizing: border-box;
}

.box {
  padding: 54px 72px;
  box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  font-family: 'Roboto', Arial, serif;
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
</style>
