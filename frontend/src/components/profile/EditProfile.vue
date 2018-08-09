<template>
    <div class="container">
        <div class="columns">
            <div class="column is-one-third">
                <figure class="image avatar">
                    <img src="http://via.placeholder.com/200x200">
                </figure>
                <b-field class="file is-fullwidth">
                    <b-upload class="upload" accept="image/*" v-model="files">
                        <a class="button is-primary is-fullwidth">
                            <b-icon icon="upload"></b-icon>
                            <span>Upload new avatar</span>
                        </a>
                    </b-upload>
                </b-field>
                <a class="button is-danger is-fullwidth">
                    <b-icon icon="trash"></b-icon>
                    <span>Delete avatar</span>
                </a>
            </div>
            <section class="column">
                <b-field label="First name">
                    <b-input v-model="user.firstName"></b-input>
                </b-field>

                <b-field label="Last name">
                    <b-input v-model="user.lastName"></b-input>
                </b-field>

                <b-field label="Email">
                    <b-input type="email"
                             v-model="user.email"
                             disabled>
                    </b-input>
                </b-field>

                <b-field label="Phone">
                    <b-input v-model="user.phone"></b-input>
                </b-field>

                <b-field label="Birth date" expanded>
                    <b-field>
                        <b-input type="number" v-model="user.birthDay" placeholder="Day"></b-input>
                        <b-input type="number" v-model="user.birthMonth" placeholder="Month"></b-input>
                        <b-input type="number" v-model="user.birthYear" placeholder="Year"></b-input>
                    </b-field>
                </b-field>

                <b-field label="Instagram">
                    <b-input v-model="user.instagram"></b-input>
                </b-field>

                <b-field label="Twitter">
                    <b-input v-model="user.twitter"></b-input>
                </b-field>

                <b-field label="Facebook">
                    <b-input v-model="user.facebook"></b-input>
                </b-field>
                <div class="buttons is-right">
                    <a class="button is-primary">
                        <b-icon icon="upload"></b-icon>
                        <span>Save</span>
                    </a>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EditProfile",
        data() {
            return {
                user: {
                    firstName: 'John',
                    lastName: 'Carter',
                    email: 'carter@example.com',
                    phone: '+380999999999',
                    birthDay: 11,
                    birthMonth: 11,
                    birthYear: 1990,
                    instagram: '@john',
                    twitter: '@carter',
                    facebook: ''
                },
                files: []
            }
        }
    }
</script>

<style scoped>
    .container {
        max-width: 700px;
        text-align: left;
    }

    .avatar {
        margin-bottom: 10px;
    }

    .upload {
        width: 100%;
    }
</style>