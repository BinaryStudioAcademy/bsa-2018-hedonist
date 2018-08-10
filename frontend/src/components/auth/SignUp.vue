<template>
  <Container title="Create new account">
    <Form>
      <b-field label="First name">
        <b-input
          v-model="newUser.firstName"
          placeholder="Your first name"
          autofocus>
        </b-input>
      </b-field>

      <b-field label="Last name">
        <b-input
          v-model="newUser.lastName"
          placeholder="Your last name"
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
        firtName: '',
        lastName: '',
        email: '',
        password: ''
      }
    }
  }
}
</script>

<style>

</style>
