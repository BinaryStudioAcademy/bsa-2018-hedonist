<template>
  <Container title="Recover your password">
    <Form>
      <b-field
        label="Email"
        :type="input.email.type">

        <b-input
          v-model="user.email"
          placeholder="Your Email"
          name="email"
          @blur="onBlur"
          @focus="onFocus"
          @keyup.enter="onRecover">
        </b-input>
      </b-field>

      <button
        type="button"
        class="button is-primary is-rounded button-wide"
        @click="onRecover"
        @keyup.enter="onRecover">
          Recover
      </button>
    </Form>
  </Container>
</template>

<script>
import { required, email } from 'vuelidate/lib/validators'
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
        email: ''
      },

      input: {
        email: {
          type: ''
        }
      }
    }
  },

  methods: {
    ...mapActions(['recoverPassword']),

    onRecover () {
      if (!this.$v.user.$invalid) {
        this.recoverPassword(this.user.email)
        this.refreshInput()
      }
    },

    onBlur () {
      if (this.$v.user.email.$invalid) {
        this.input.email.type = 'is-danger'
      } else {
        this.input.email.type = 'is-success'
      }
    },

    onFocus (el) {
      this.input.email.type = ''
    },

    refreshInput () {
      this.user = {
        email: ''
      },

      this.input = {
        email: {
          type: ''
        }
      }
    }
  }, 

  validations: {
    user: {
      email: {
        required,
        email
      }
    }
  }
}
</script>

<style>

</style>
