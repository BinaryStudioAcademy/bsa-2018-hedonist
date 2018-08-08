<template>
  <Container title="Recover your password">
    <Form>
      <b-field label="Email">
        <b-input type="email"
          v-model="user.email"
          placeholder="Your Email">
        </b-input>
      </b-field>

      <button type="button" class="button is-primary is-rounded button-wide">Recover</button>
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
        email: ''
      }
    }
  }
}
</script>

<style>

</style>
