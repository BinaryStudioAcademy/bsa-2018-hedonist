<template>
  <Container title="Create new account">
    <Form>
      <b-field
          label="First name"
          :type="input.firstName.type">
        <b-input
            name="firstName"
            v-model="newUser.firstName"
            placeholder="Your first name"
            @blur="onBlur('firstName')"
            @focus="onFocus('firstName')">
        </b-input>
      </b-field>

      <b-field
          label="Last name"
          :type="input.lastName.type">
        <b-input
            name="lastName"
            v-model="newUser.lastName"
            placeholder="Your last name"
            @blur="onBlur('lastName')"
            @focus="onFocus('lastName')">
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
  </Container>
</template>

<script>
  import {required, email, minLength, alpha} from 'vuelidate/lib/validators'
  import {mapActions} from 'vuex'
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
          firstName: {
            type: ''
          },
          lastName: {
            type: ''
          },
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
          this.signUp(this.newUser).then((res) => {
            if (res.error) {
              this.onError(res.error);
            } else {
              this.refreshInput();
              this.$router.push({name: 'LoginPage'});
              this.onSuccess({
                message: 'You have successfully registered! Now you need to login'
              });
            }
          });
        } else {
          this.onError({
            message: 'Please, check your input data'
          });
        }
      },

      onError (error) {
        this.$toast.open({
          message: error.message,
          type: 'is-danger'
        })
      },
      onSuccess (success) {
        this.$toast.open({
          message: success.message,
          type: 'is-success'
        })
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
        firstName: {
          required,
          alpha
        },
        lastName: {
          required,
          alpha
        },
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
