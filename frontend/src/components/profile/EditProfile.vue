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
                        @input="onFileChange"
                    >
                        <a class="button is-primary is-fullwidth">
                            <b-icon icon="upload" />
                            <span>Upload new avatar</span>
                        </a>
                    </b-upload>
                </b-field>
                <a class="button is-danger is-fullwidth" @click="deleteAvatar">
                    <b-icon icon="trash" />
                    <span>Delete avatar</span>
                </a>
            </div>
            <section class="column">
                <b-field 
                    label="First name"
                >
                    <b-input v-model="firstName" />
                </b-field>

                <b-field label="Last name">
                    <b-input v-model="lastName" />
                </b-field>

                <b-field label="Email">
                    <b-input 
                        type="email"
                        v-model="user.email"
                        disabled
                    />
                </b-field>

                <b-field label="Old password">
                    <b-input
                        type="password"
                        v-model="oldPassword"
                        password-reveal
                    />
                </b-field>

                <b-field label="New password">
                    <b-input
                        type="password"
                        v-model="newPassword"
                        password-reveal
                    />
                </b-field>

                <b-field label="Phone">
                    <b-input v-model="phone" />
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
                    <b-input v-model="instagram" />
                </b-field>

                <b-field label="Twitter">
                    <b-input v-model="twitter" />
                </b-field>

                <b-field label="Facebook">
                    <b-input v-model="facebook" />
                </b-field>
                <div class="buttons is-right">
                    <a class="button is-primary" @click="saveData">
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
import { mapActions } from 'vuex';

export default {
    name: 'EditProfile',
    data() {
        return {
            birthDay: '',
            birthMonth: '',
            birthYear: '',
            files: [],
            oldPassword: '',
            newPassword: '',
        };
    },
    created() {
        this.setUser(Object.assign({}, this.authUser));

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
            authUser: 'auth/getAuthenticatedUser',
            user: 'profile/getUser'
        }),
        firstName: {
            get () {
                return this.user.first_name;
            },
            set (value) {
                this.updateFirstName(value);
            }
        },
        lastName: {
            get () {
                return this.user.last_name;
            },
            set (value) {
                this.updateLastName(value);
            }
        },
        phone: {
            get () {
                return this.user.phone_number;
            },
            set (value) {
                this.updatePhone(value);
            }
        },
        facebook: {
            get () {
                return this.user.facebook_url;
            },
            set (value) {
                this.updateFacebook(value);
            }
        },
        instagram: {
            get () {
                return this.user.instagram_url;
            },
            set (value) {
                this.updateInstagram(value);
            }
        },
        twitter: {
            get () {
                return this.user.twitter_url;
            },
            set (value) {
                this.updateTwitter(value);
            }
        }
    },
    methods: {
        ...mapActions({
            updateProfile: 'profile/updateProfile',
            deleteUserAvatar: 'profile/deleteUserAvatar',
            setUserAvatar: 'profile/setUserAvatar',
            setUser: 'profile/setUser',

            updateFirstName: 'profile/updateFirstName',
            updateLastName: 'profile/updateLastName',
            updatePhone: 'profile/updatePhone',
            updateFacebook: 'profile/updateFacebook',
            updateInstagram: 'profile/updateInstagram',
            updateTwitter: 'profile/updateTwitter',
            updateDateOfBirth: 'profile/updateDateOfBirth',
            updateUserAvatar: 'profile/updateUserAvatar',
            updatePassword: 'profile/updatePassword',
        }),
        saveData() {
            if (this.oldPassword !== '' && this.newPassword !== '') {
                this.updatePassword({old_password: this.oldPassword, new_password: this.newPassword})
                    .then(() => {
                        this.saveProfileInfo();
                    })
                    .catch((error) => {
                        console.log(error);
                        // this.onError({
                        //     message: error.message
                        // });
                        return false;
                    })
            } else {
                this.saveProfileInfo();
            }
        },
        saveProfileInfo() {
            const formData = new FormData();
            formData.append('first_name', this.user.first_name);
            formData.append('last_name', this.user.last_name);
            formData.append('phone_number', this.user.phone_number);
            formData.append('instagram_url', this.user.instagram_url);
            formData.append('facebook_url', this.user.facebook_url);
            formData.append('twitter_url', this.user.twitter_url);

            if (this.birthYear && this.birthMonth && this.birthDay) {
                this.updateDateOfBirth(this.birthYear + '/' + ('0' + this.birthMonth).slice(-2) + '/' + ('0' + this.birthDay).slice(-2));
                formData.append('date_of_birth', this.user.date_of_birth);
            }
            if (this.files && this.files.length) {
                let file = this.files[0];
                formData.append('avatar_url', file, file.name);
            }
            this.updateProfile({formData: formData, userId: this.user.id})
                .then(() => {
                    this.onSuccess({
                        message: 'Data successfully changed'
                    });
                });
        },
        onFileChange() {
            if (this.files && this.files.length) {
                this.updateUserAvatar(URL.createObjectURL(this.files[0]));
            }
        },
        deleteAvatar() {
            this.deleteUserAvatar(this.user.id)
                .then(() => {
                    this.files = [];
                });
        },
        onSuccess (success) {
            this.$toast.open({
                message: success.message,
                type: 'is-success'
            });
        },
        onError (error) {
            this.$toast.open({
                message: error.message,
                type: 'is-danger'
            });
        },
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