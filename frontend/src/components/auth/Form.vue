<template>
  <form class="form" @submit.prevent>
    <slot></slot>  
  </form>  
</template>

<script>
export default {
  
}
</script>

<style>
.form {
  margin-top: 50px;
  text-align: left;
}
</style>
