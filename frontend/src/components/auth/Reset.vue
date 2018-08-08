<template>
  <div class="columns">
    <div class="column is-4 is-offset-4">
      <div class="box">
        <h3 class="title is-4">Reset password</h3>

        <form action="" class="form">
          <div class="field">
            <p class="control has-icons-right">
              <label class="custom-label" for="current-password">Current password</label>
              <input
                id="current-password"
                class="input"
                :type="hide.currentPassword ? 'password' : 'text'"
                v-model="user.currentPassword"
                placeholder="Current password"
                ref="currentPassword">

              <span class="icon is-right" @click="togglePassword('currentPassword', $event)">
                <i v-if="hide.currentPassword" class="mdi mdi-eye mdi-24px"></i>
                <i v-else class="mdi mdi-eye-off mdi-24px"></i>
              </span>
            </p>
          </div>

          <div class="field">
            <p class="control has-icons-right">
              <label class="custom-label" for="new-password">New password</label>
              <input
                id="new-password"
                class="input"
                :type="hide.newPassword ? 'password' : 'text'"
                v-model="user.newPassword"
                placeholder="New password"
                ref="newPassword">

              <span class="icon is-right" @click="togglePassword('newPassword', $event)">
                <i v-if="hide.newPassword" class="mdi mdi-eye mdi-24px"></i>
                <i v-else class="mdi mdi-eye-off mdi-24px"></i>
              </span>
            </p>
          </div>

          <button type="button" class="button is-rounded is-hovered">Reset</button>
        </form>
      </div>
    </div>

    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.0.46/css/materialdesignicons.min.css">
  </div>
</template>

<script>
export default {
  data () {
    return {
      user: {
        currentPassword: '',
        newPassword: ''
      },

      hide: {
        currentPassword: true,
        newPassword: true
      }
    }
  },

  methods: {
    togglePassword: function (type, event) {
      if (type == 'currentPassword') {
        this.hide.currentPassword = !this.hide.currentPassword
        this.$refs.currentPassword.focus()
      } else {
        this.hide.newPassword = !this.hide.newPassword
        this.$refs.newPassword.focus()
      }
    }
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Roboto:400,500');

* {
  box-sizing: border-box;
}

.box {
  padding: 54px 72px;
  box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  font-family: 'Roboto', Arial, serif;
}

.title {
  margin-bottom: 32px;
  color: #0a2044;
  font-weight: 500;
}

.field {
  margin-bottom: 22px;
}

.field:last-child {
  margin-bottom: 0;
}

.custom-label {
  font-size: 14px;
  color: #8a94a6;
}

.input {
  position: relative;
  display: inline-block;
  padding: 20px 10px;
  font-weight: 500;
}

.input:focus {
  border: 1px solid #0781ff;
  box-shadow: 0 0 0 1px #0781ff;
}

.control.has-icons-right .icon.is-right {
  top: 27px;
  pointer-events: auto;
}

.mdi-eye:hover,
.mdi-eye-off:hover {
  cursor: pointer;
}

.button {
  width: 100%;
  height: 42px;
  font-size: 14px;
  color: #fff;
  background-color: #0d69ff;
}

.button:hover {
  border-color: none;
}
</style>
