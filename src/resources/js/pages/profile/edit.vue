<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="6" lg="4" style="max-width: 450px;">
        <v-card class="elevation-12">
          <v-toolbar class="">
            <v-toolbar-title class="text-gold-gradient ml-2 text-profile">
              {{ $t("Profile") }}
            </v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-form v-if="emailAuth" v-model="formIsValid" @submit.prevent="UpdateProfile">
              <v-row>
                <v-col cols="12">
                  <v-row>
                    <v-col>
                      <v-text-field v-model="form.name" color="yellow" :label="$t('Name')" type="text" name="name"
                        id="name" :value="form.name" outlined height="61" hide-details
                        @keydown="clearFormErrors, showMsg"><template slot="label">
                          <div class="yellow--text">Name</div>
                        </template></v-text-field>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col>
                      <v-file-input v-model="form.file" color="yellow" label="Avatar" name="file" id="file"
                        :rules="[validationRequired]" :error="form.errors.has('file')"
                        :error-messages="form.errors.get('file')" outlined height="61" hide-details
                        @keydown="clearFormErrors, showMsg" @change="UploadAvatar" class="file-input">
                        <template #prepend-inner>
                          <div style="width: 30px">
                            <v-img style="margin: auto 0" max-height="30" max-width="30"
                              :src="form.avatar === 'https://bucket-dev.baanbaan.site/' ? '/images/icon-user.png' : form.avatar" />
                          </div>
                        </template>
                        <template slot="label">
                          <div class="yellow--text">Avatar</div>
                        </template>
                      </v-file-input>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>

              <v-row align="center">
                <v-col class="text-end text-md-right">
                  <v-btn type="submit" color="primary" class="font-weight-bold gold-gradient text-black"
                    :loading="loading" @click="UpdateProfile">
                    {{ $t("Save") }}
                  </v-btn>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from "axios";
import { config } from "~/plugins/config";
import Form from "vform";
import FormMixin from "~/mixins/Form";
import Oauth from "~/components/Oauth";
import Web3Auth from "~/components/Web3Auth";
import { mapState } from "vuex";
import VueRecaptcha from "vue-recaptcha";
import { mapGetters } from 'vuex'
import objectToFormData from '~/plugins/objectToFormData'

export default {
  components: { Web3Auth, Oauth, VueRecaptcha },
  mixins: [FormMixin],
  middleware: "guest",
  metaInfo() {
    return { title: this.$t("Update Profile") };
  },

  data() {
    return {
      username: false,
      name: null,
      avatar: false,
      contry_code: null,
      contact: null,
      status: null,
      ref_id: null,
      loading: false,
      csrfCookieRetrieved: false,
      image_url: 'https://bucket-dev.baanbaan.site/',
      showPassword: false,
      token: null,
      form: new Form({
        name: '',
        avatar: '/img/container-connection.jpg',
        file: null
      }),
    };
  },
  computed: {
    ...mapGetters({ authenticated: 'auth/check' }),
    ...mapState("auth", ["user"]),
    appLogoUrl() {
      return config("app.logo");
    },
    emailAuth() {
      return config("settings.users.email_auth");
    },
    recaptchaPublicKey() {
      return config("services.recaptcha.public_key");
    },
  }, created() {

    console.log('authenticated:' + this.authenticated);

    if (this.authenticated) {
      // update user balance
      this.$store.dispatch('auth/fetchUser')
    }

  }, methods: {
    async UpdateProfile() {
      this.loading = true;
      let image_url = 'https://bucket-dev.baanbaan.site/'

      console.log('UpdateProfile.');

      this.form.avatar = this.form.avatar.replace(image_url, '');
      console.log('avatar:', this.form.avatar);

      // if (!this.csrfCookieRetrieved) {
      //   await axios.get("/sanctum/csrf-cookie");
      //   this.csrfCookieRetrieved = true;
      // }

      console.log('form.name:', this.form.name);

      if (this.form.name) {

        // log in
        const { data } = await this.form.put("/api/auth/me", {
          headers: {
            'Authorization': 'Bearer ' + this.token,
          }
        }).catch(() => {
          if (this.recaptchaPublicKey) {
            this.form.recaptcha = null;
            this.$refs.recaptcha.reset();
            this.loading = false;
          }
          return {};
        });

        // in case of any error data will be undefined
        if (data) {

          console.log('data:' + data);

          // Store the user
          localStorage.setItem('name', this.form.name);
          this.$store.dispatch("auth/updateUser", data);
          // this.$store.dispatch('message/success', { text: this.$t('Update profile successfully!') })

          // if (this.user.two_factor_auth_enabled && !this.user.two_factor_auth_passed) {
          //   this.$router.push({ name: "2fa" });
          // } else {
          //   this.$router.push({ name: "home" });
          // }
        } else {
          // this.loading = false;
        }
      }
      this.loading = false;
    },
    UploadAvatar(event) {

      console.log('UploadAvatar.');
      console.log('file:', this.form.file);

      if (this.form.file) {
        let imageBase64
        let posturl = '/api/auth/upload-avatar'

        const reader = new FileReader()
        // define a callback function to run, when FileReader finishes its job
        reader.onload = e => { imageBase64 = e.target.result }
        // Start the reader job - read file as a data url (base64 format)
        reader.readAsDataURL(this.form.file)

        const options = { transformRequest: [(data, headers) => objectToFormData(data)] }

        this.form.submit(`post`, posturl, options)
          .then((res) => {

            console.log('res:', res);
            console.log('avatar:', res.data.data);
            this.form.avatar = res.data.data
            // console.log('form.avatar:', this.form.avatar);
            localStorage.avatar = res.data.data

          }).catch(error => {

            this.error = error.message
            console.log('res:', error.message);

          });

      }

      /*
      this.form.post('/api/auth/upload-avatar', {
              headers: {
                'Authorization': 'Bearer ' + this.token,
              }
      }).then((response) => {

        console.log('response:', response);

      });
      */

    }
  }, async mounted() {

    console.log('get me!!!');
    let cname = 'token'
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        this.token = c.substring(name.length, c.length);
      }
    }
    // console.log('token:' + this.token);

    if (this.token) {

      await axios.get('/api/auth/me', {
        headers: {
          'Authorization': 'Bearer ' + this.token,
        }
      }).then((response) => {

        // console.log('response:' + response);
        // console.log('response data:' + response.data);
        // console.log('code:' + response.data.code);

        if (response.data.code == 200) {

          this.username = response.data.data.username
          this.form.name = response.data.data.name
          this.form.avatar = response.data.data.avatar
          this.contry_code = response.data.data.contry_code
          this.contact = response.data.data.contact
          this.ref_id = response.data.data.ref_id
          this.status = response.data.data.status
          this.form.file = response.data.data.avatar

          console.log('username:' + this.username);
          console.log('name:' + this.form.name);
          console.log('avatar:' + this.form.avatar);
          console.log('status:' + this.status);

          this.$store.dispatch('auth/fetchUser')
          console.log('reload');
        } else {

          // this.$store.dispatch('message/error', { text: this.$t('Please login!!!') })
          this.$router.push({ name: 'home' })
        }

      }).catch((e) => {

        console.log(e)
        // this.$store.dispatch('message/error', { text: this.$t('Please login!!!') })
        this.$router.push({ name: 'home' })

      })

    }

  }
};
</script>
<style scoped>
.btn-v {
  color: rgba(255, 255, 255, 0.24);
  height: 55px !important;
  min-width: 100% !important;
  padding: 0px !important;
}

.text-profile {
  font-family: 'Orbitron', sans-serif !important;
  font-weight: 600 !important;
  font-size: 20px !important;
  line-height: 30px !important;
}

::v-deep .v-input__prepend-outer {
  display: none;
}

::v-deep .file-input {
  margin-bottom: 0px !important;
}
</style>
