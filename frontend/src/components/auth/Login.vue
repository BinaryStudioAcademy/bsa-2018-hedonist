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
        <button type="button" class="button is-primary is-rounded">Login</button>
      </div>
    </Form>
  </Container>
</template>

<script>
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
  }
}
</script>

<style scoped>
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
