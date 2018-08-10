<template>
  <form class="form" @submit.prevent novalidate="true">
    <slot></slot>  
  </form>  
</template>

<script>
export default {
  
}
</script>

<style scoped>
.form {
  margin-top: 50px;
  text-align: left;
}
</style>
