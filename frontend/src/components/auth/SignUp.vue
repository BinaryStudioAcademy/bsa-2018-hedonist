<template>
  <Container title="Create new account">
    <Form>
      <b-field label="Name">
        <b-input
          v-model="newUser.name"
          placeholder="Your Name"
          autofocus>
        </b-input>
      </b-field>
      
      <b-field label="Email">
        <b-input type="email"
          v-model="newUser.email"
          placeholder="Your Email">
        </b-input>
      </b-field>

      <b-field label="Password">
        <b-input type="password"
          v-model="newUser.password"
          placeholder="Your Password"
          password-reveal>
        </b-input>
      </b-field>

      <button type="button" class="button is-primary is-rounded button-wide">Create</button>
    </Form>

    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.0.46/css/materialdesignicons.min.css">
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
      newUser: {
        name: '',
        email: '',
        password: ''
      }
    }
  }
}
</script>

<style>

</style>
