<template>
    <div class="container" v-if="isUserLoggedIn">
        <div class="columns">
            <div class="column is-one-third">
                <figure class="image avatar">
                    <img :src="user.avatar_url">
                </figure>
                <b-field class="file is-fullwidth">
                    <b-upload 
                        class="upload" 
                        accept="image/*" 
                        v-model="files"
                    >
                        <a class="button is-primary is-fullwidth">
                            <b-icon icon="upload" />
                            <span>Upload new avatar</span>
                        </a>
                    </b-upload>
                </b-field>
                <a class="button is-danger is-fullwidth">
                    <b-icon icon="trash" />
                    <span>Delete avatar</span>
                </a>
            </div>
            <section class="column">
                <b-field label="First name">
                    <b-input v-model="user.first_name" disabled />
                </b-field>

                <b-field label="Last name">
                    <b-input v-model="user.last_name" />
                </b-field>

                <b-field label="Email">
                    <b-input 
                        type="email"
                        v-model="user.email"
                        disabled
                    />
                </b-field>

                <b-field label="Phone">
                    <b-input v-model="user.phone" />
                </b-field>

                <b-field 
                    label="Birth date" 
                    expanded
                >
                    <b-field>
                        <b-input 
                            type="number" 
                            v-model="birthDay"
                            placeholder="Day"
                        />
                        <b-input 
                            type="number" 
                            v-model="birthMonth"
                            placeholder="Month"
                        />
                        <b-input 
                            type="number" 
                            v-model="birthYear"
                            placeholder="Year"
                        />
                    </b-field>
                </b-field>

                <b-field label="Instagram">
                    <b-input v-model="user.instagram" />
                </b-field>

                <b-field label="Twitter">
                    <b-input v-model="user.twitter" />
                </b-field>

                <b-field label="Facebook">
                    <b-input v-model="user.facebook" />
                </b-field>
                <div class="buttons is-right">
                    <a class="button is-primary">
                        <b-icon icon="upload" />
                        <span>Save</span>
                    </a>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: 'EditProfile',
    data() {
        return {
            birthDay: '',
            birthMonth: '',
            birthYear: '',
            files: [],
        };
    },
    created() {
        if (this.user.date_of_birth !== null) {
            let date = new Date(this.user.date_of_birth.date);
            this.birthYear = date.getFullYear();
            this.birthMonth = date.getMonth() + 1;
            this.birthDay = date.getDate();
        }

    },
    computed: {
        ...mapGetters({
            isUserLoggedIn: 'auth/isLoggedIn',
            user: 'auth/getAuthenticatedUser'
        })
    }
};
</script>

<style scoped>
    .container {
        max-width: 700px;
        text-align: left;
        padding: 40px;
    }

    .avatar {
        margin-bottom: 10px;
    }

    .image img {
        width: 200px;
        height: 200px;
    }

    .file.is-fullwidth {
        width: 100%;
    }

    .upload {
        width: 100%;
    }

    @media screen and (max-width: 769px) {
        .is-one-third {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    }
</style>