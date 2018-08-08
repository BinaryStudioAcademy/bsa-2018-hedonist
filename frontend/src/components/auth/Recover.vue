<template>
  <div class="columns">
    <div class="column is-4 is-offset-4">
      <div class="box">
        <h3 class="title is-4">Recover password</h3>

        <form action="" class="form">
          <div class="field">
            <p class="control has-icons-right">
              <label class="custom-label" for="email">Email</label>
              <input
                id="email"
                class="input"
                type="email"
                v-model="user.email"
                placeholder="Your Email">

              <span class="icon is-right">
                <i class="mdi mdi-email-outline mdi-24px"></i>
              </span>
            </p>
          </div>

          <button type="button" class="button is-rounded is-hovered">Recover</button>
        </form>
      </div>
    </div>

    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.0.46/css/materialdesignicons.min.css">
  </div>
</template>

<script>
export default {
  data () {
    return {
      user: {
        email: ''
      }
    }
  }
}
</script>

<style scoped>
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

.custom-label {
  font-size: 14px;
  color: #8a94a6;
}

.input {
  position: relative;
  display: inline-block;
  padding: 20px 10px;
  font-weight: 500;
}

.input:focus {
  border: 1px solid #0781ff;
  box-shadow: 0 0 0 1px #0781ff;
}

.control.has-icons-right .icon.is-right {
  top: 27px;
  pointer-events: auto;
}

.button {
  width: 100%;
  height: 42px;
  font-size: 14px;
  color: #fff;
  background-color: #0d69ff;
}

.button:hover {
  border-color: none;
}
</style>
