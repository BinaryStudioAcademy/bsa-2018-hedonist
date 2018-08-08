<template>
  <Container title="Reset your password">
    <Form>
      <b-field label="Current password">
        <b-input type="password"
          v-model="user.currentPassword"
          placeholder="Curent password"
          password-reveal>
        </b-input>
      </b-field>

      <b-field label="New password">
        <b-input type="password"
          v-model="user.newPassword"
          placeholder="New password"
          password-reveal>
        </b-input>
      </b-field>

      <button type="button" class="button is-primary is-rounded is-hovered button-wide">Reset</button>
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
      user: {
        currentPassword: '',
        newPassword: ''
      }
    }
  }
}
</script>

<style>

</style>
