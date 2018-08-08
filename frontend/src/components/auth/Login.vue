<template>
  <div class="columns">
    <div class="column is-4 is-offset-4">
      <div class="box">
        <h3 class="title is-4">Login into your account</h3>
        <p class="subtitle">Don't have an account? 
          <router-link class="link link-signup" to="/signup">Create New</router-link>
        </p>

        <form action="" class="form">
          <div class="field">
            <p class="control has-icons-right">
              <input
                class="input"
                type="email"
                v-model="user.email"
                placeholder="Type your Email"
                autofocus>

              <span class="icon is-right">
                <i class="mdi mdi-email-outline mdi-24px"></i>
              </span>
            </p>
          </div>

          <div class="field">
            <p class="control has-icons-right">
              <input
                class="input"
                :type="hidePassword ? 'password' : 'text'"
                v-model="user.password"
                placeholder="Type your Password"
                ref="pass">

              <span class="icon is-right" @click="togglePassword">
                <i v-if="hidePassword" class="mdi mdi-eye mdi-24px"></i>
                <i v-else class="mdi mdi-eye-off mdi-24px"></i>
              </span>
            </p>
          </div>

          <div class="form-footer">
            <router-link class="link" to="/recover">Forgot Password?</router-link>
            <button type="button" class="button is-rounded is-hovered">Login</button>
          </div>
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
        email: '',
        password: ''
      },

      hidePassword: true
    }
  },

  methods: {
    togglePassword: function () {
      this.hidePassword = !this.hidePassword
      this.$refs.pass.focus()
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

.subtitle {
  color: #8a94a6;
  font-size: 14px;
}

.link {
  color: #0e58cf;
  font-weight: 500;
}

.link-signup {
  margin-left: 16px;
}

.form {
  margin-top: 66px;
}

.field {
  margin-bottom: 22px;
}

.field:last-child {
  margin-bottom: 0;
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
  top: 3px;
  pointer-events: auto;
}

.mdi-eye:hover,
.mdi-eye-off:hover {
  cursor: pointer;
}

.form-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 14px;
}

.button {
  width: 130px;
  height: 42px;
  font-size: 14px;
  color: #fff;
  background-color: #0d69ff;
}

.button:hover {
  border-color: none;
}
</style>
