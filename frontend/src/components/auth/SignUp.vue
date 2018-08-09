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
      
      <b-field
        label="Email"
        :type="input.email.type">

        <b-input
          v-model="newUser.email"
          placeholder="Your Email"
          name="email"
          @blur="onBlur('email')"
          @focus="onFocus('email')">
        </b-input>
      </b-field>

      <b-field
        label="Password"
        :type="input.password.type">

        <b-input type="password"
          v-model="newUser.password"
          placeholder="Your Password"
          @blur="onBlur('password')"
          @focus="onFocus('password')"
          @keyup.enter="onSignUp"
          password-reveal>
        </b-input>
      </b-field>

      <button
        type="button"
        class="button is-primary is-rounded button-wide"
        @click="onSignUp"
        @keyup.enter="onSignUp">
          Create
      </button>
    </Form>

    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.0.46/css/materialdesignicons.min.css">
  </Container>
</template>

<script>
import { required, email, minLength } from 'vuelidate/lib/validators'
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
      newUser: {
        firstName: '',
        lastName: '',
        email: '',
        password: ''
      },

      input: {
        email: {
          type: ''
        },
        password: {
          type: ''
        }
      }
    }
  },

  methods: {
    ...mapActions(['signUp']),

    onSignUp () {
      if (!this.$v.newUser.$invalid) {
        this.signUp(this.newUser)

        this.refreshInput()
      }
    },

    onBlur (el) {
      if (this.$v.newUser[el].$invalid) {
        this.input[el].type = 'is-danger'
      } else {
        this.input[el].type = 'is-success'
      }
    },

    onFocus (el) {
      this.input[el].type = ''
    },

    refreshInput () {
      this.newUser = {
        firstName: '',
        lastName: '',
        email: '',
        password: ''
      },

      this.input = {
        email: {
          type: ''
        },
        password: {
          type: ''
        }
      }
    }
  }, 

  validations: {
    newUser: {
      email: {
        required,
        email
      },
      password: {
        required,
        minLength: minLength(6)
      }
    }
  }
}
</script>

<style>

</style>
