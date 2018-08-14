<template>
    <Container title="Login into your account">
        <p class="subtitle">Don't have an account? 
            <router-link 
                class="link link-signup" 
                to="/signup"
            >Create New</router-link>
        </p>
        <Form>
            <b-field :type="input.email.type">
                <b-input
                    v-model="user.email"
                    placeholder="Your Email"
                    name="email"
                    @blur="onBlur('email')"
                    @focus="onFocus('email')"
                    autofocus
                />
            </b-field>

            <b-field :type="input.password.type">
                <b-input 
                    type="password"
                    v-model="user.password"
                    placeholder="Your Password"
                    @blur="onBlur('password')"
                    @focus="onFocus('password')"
                    @keyup.enter="onLogin"
                    password-reveal
                />
            </b-field>

            <div class="login-footer">
                <router-link 
                    class="link" 
                    to="/recover"
                >Forgot Password?</router-link>
                <button 
                    type="button"
                    class="button is-primary is-rounded"
                    @click="onLogin"
                    @keyup.enter="onLogin"
                >
                    Login
                </button>
            </div>
        </Form>
    </Container>
</template>

<script>
import { mapActions } from 'vuex';
import { required, email, minLength } from 'vuelidate/lib/validators';
import Container from './Container';
import Form from './Form';

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
            },

            input: {
                email: {
                    type: ''
                },
                password: {
                    type: ''
                }
            }
        };
    },

    methods: {
        ...mapActions(['login']),

        onLogin () {
            if (!this.$v.user.$invalid) {
                this.login(this.user).then((res)=>{
                    if(res.error){
                        this.onError(res.error);
                    } else {
                        this.onSuccess({
                            message: 'Welcome!'
                        });
                        this.refreshInput();
                        this.$router.push({name: 'home'});
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
            });
        },

        onSuccess (success) {
            this.$toast.open({
                message: success.message,
                type: 'is-success'
            });
        },

        onBlur (el) {
            if (this.$v.user[el].$invalid) {
                this.input[el].type = 'is-danger';
            } else {
                this.input[el].type = 'is-success';
            }
        },

        onFocus (el) {
            this.input[el].type = '';
        },

        refreshInput () {
            this.user = {
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
            };
        }
    },

    validations: {
        user: {
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
};
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
