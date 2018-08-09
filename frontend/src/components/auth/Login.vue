<template>
  <Container title="Login into your account">
    <p class="subtitle">Don't have an account? 
      <router-link class="link link-signup" to="/signup">Create New</router-link>
    </p>
    <Form>
      <b-field>
        <b-input type="email"
          v-model="user.email"
          placeholder="Your Email"
          name="email"
          autofocus>
        </b-input>
      </b-field>

      <b-field>
        <b-input type="password"
          v-model="user.password"
          placeholder="Your Password"
          password-reveal>
        </b-input>
      </b-field>

      <div class="login-footer">
        <router-link class="link" to="/recover">Forgot Password?</router-link>
        <button 
          type="button"
          class="button is-primary is-rounded"
          @click="onLogin">
            Login
        </button>
      </div>
    </Form>

    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.0.46/css/materialdesignicons.min.css">
  </Container>
</template>

<script>
import { mapActions } from 'vuex'
import Container from './Container'
import Form from './Form'

export default {
  components: {
    Container,
    Form
  },

  data: function () {
    return {
      user: {
        email: '',
        password: ''
      }
    }
  },

  methods: {
    ...mapActions(['login']),

    onLogin () {
      this.login(this.user)
    }
  }
}
</script>

<style>
.link-signup {
  margin-left: 16px;
}

.login-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 14px;
}
</style>
