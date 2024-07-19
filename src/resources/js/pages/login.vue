<template>
  <v-container class="fill-height" style="backdrop-filter: blur(3px);" fluid>
    <v-row align="center" justify="center" id="alert-success"
      v-bind:class="[isActive ? activeClass : '', inactiveClass]">
      <v-col sm="12" md="8" lg="6" class="alert-container">
        <v-alert color="success" icon="$success">{{ text }}</v-alert>
      </v-col>
    </v-row>
    <v-row align="center" justify="center">
      <v-col sm="8" md="6" lg="4" class="style-wrap">
        <v-card class="card-login mx-auto">
          <v-toolbar color="primary" class="bg-gradient-primary d-flex justify-space-around">
            <v-toolbar-title class="title-login"> LOGIN </v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <oauth />
            <web3-auth />
            <v-form v-if="emailAuth" v-model="formIsValid" @submit.prevent="login">
              <div class="text-caption text-medium-emphasis text-gold-gradient" style="width: fit-content">
                Phone number
              </div>
              <div class="phone__wrapper">
                <v-select class="select-code text-center" height="61" v-model="form.pre_phone" :items="countryCodes"  placeholder="+1"
                  item-value="code" item-text="formattedText" outlined @change="handlerSelectCode"> <template
                    v-slot:selection="{ item }">
                    {{ item.code }}
                  </template>
                </v-select>
                <v-text-field height="61" hide-details class="mb-0" color="yellow" v-model="form.phone" type="text"
                  name="phone" id="phone" maxlength="22" :rules="[validationRequired]" :error="form.errors.has('phone')"
                  :error-messages="form.errors.get('phone')" outlined @input="showMsg" @keydown="clearFormErrors"
                  @keypress="isNumber($event)" />

              </div>
              <p v-if="(form.pre_phone === null || form.pre_phone === '' || !form.pre_phone) && isErrorMessage"
                class="alert-style mb-2">Please require Country code
                <v-icon>mdi-alert-circle</v-icon>
              </p>
              <p v-if="(form.phone === null || form.phone === '' || !form.phone) && isErrorMessage" class="alert-style">
                Please require
                Phone number
                <v-icon>mdi-alert-circle</v-icon>
              </p>
              <div>
                <span class="text-caption text-medium-emphasis text-gold-gradient mb-2">
                  Password
                </span>
                <v-text-field hide-details color="yellow" height="61" v-model="form.password" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off-outline'
                  " :type="showPassword ? 'text' : 'password'" class="mb-0" name="password" id="password"
                  :rules="[validationRequired]" :error="form.errors.has('password')"
                  :error-messages="form.errors.get('password')" outlined :counter="true"
                  @click:append="showPassword = !showPassword" @keydown="clearFormErrors, showMsg" />
              </div>
              <p v-if="(form.password === null || form.password === '' || !form.password) && isErrorMessage"
                class="alert-style mt-2">
                Please require password
                <v-icon>mdi-alert-circle</v-icon>
              </p>
              <v-checkbox style="font-size: 16px; opacity: 0.7; margin-top: 10px" v-model="form.remember"
                name="remember" id="remember" :label="$t('Remember me')" color="yellow" true-value="1" false-value=""
                class="mb-3" @click="keep_remember">
                <template slot="label">
                  <div style="color: white">Remember me</div>
                </template>
              </v-checkbox>

              <vue-recaptcha v-if="recaptchaPublicKey" ref="recaptcha" :sitekey="recaptchaPublicKey"
                :loadRecaptchaScript="true" :theme="this.$vuetify.theme.isDark ? 'dark' : 'light'" class="mb-3"
                @verify="(token) => (form.recaptcha = token)" />

              <input type="hidden" name="username" id="username" value="" v-model="ShowMessage" />

              <v-row align="center">
                <v-col class="text-left text-md-left">
                  <v-btn width="83" type="submit" color="primary" class="app-button-primary"
                    style="letter-spacing: 0px;" :loading="loading">
                    <!-- :disabled="!formIsValid || loading || (!!recaptchaPublicKey && !form.recaptcha)"  -->
                    LOGIN
                  </v-btn>
                </v-col>
                <v-col class="d-flex flex-column text-right text-md-right">
                  <router-link class="text-gold-gradient" :to="{ name: 'register' }">
                    Not signed up?
                  </router-link>
                  <router-link style="text-decoration: none; color: #bcbcbc" :to="{ name: 'password.reset' }">
                    Forgot password?
                  </router-link>
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
import axios from 'axios'
import { config } from '~/plugins/config'
import { countries } from '~/plugins/countries'
import Form from 'vform'
import FormMixin from '~/mixins/Form'
import Oauth from '~/components/Oauth'
import Web3Auth from '~/components/Web3Auth'
import { mapState } from 'vuex'
import VueRecaptcha from 'vue-recaptcha'
import VueCountryCode from "vue-country-code";
import { mapGetters } from 'vuex'

export default {
  components: { Web3Auth, Oauth, VueRecaptcha, VueCountryCode },
  mixins: [FormMixin],
  middleware: 'guest',
  metaInfo() {
    return { title: this.$t('Authentication') }
  },

  data() {
    return {
      isActive: false,
      activeClass: 'active',
      inactiveClass: 'inactive',
      text: null,
      ShowMessage: null,
      loading: false,
      csrfCookieRetrieved: false,
      showPassword: false,
      isErrorMessage: false,
      countryCodes: countries,
      form: new Form({
        pre_phone: null,
        phone: null,
        username: null,
        password: null,
        remember: '', // it's important to pass empty string as false value so $request->filled('remember') returns false,
        // recaptcha: null
      }),
    }
  },

  computed: {
    ...mapGetters({ authenticated: 'auth/check' }),
    ...mapState('auth', ['user']),
    appLogoUrl() {
      return config('app.logo')
    },
    emailAuth() {
      return config('settings.users.email_auth')
    },
    recaptchaPublicKey() {
      return config('services.recaptcha.public_key')
    },
  },
  created() {

    let countryList = [];
    this.countryCodes = this.countryCodes.map(country => ({ code: country.code, formattedText: `${country.name} (${country.code})`, abbr: country.abbr }));
    countryList = this.countryCodes;
    // console.log('countryCodes------', countryList);
    if (this.countryCodes) {
      var xhr = new XMLHttpRequest();
      var url = "https://ipinfo.io/json";
      xhr.open("GET", url, true);
      xhr.setRequestHeader("Content-Type", "application/json");
      xhr.onreadystatechange = () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          const countryIndex = countryList.findIndex(country => country.abbr === response.country);
          if (countryIndex !== -1) {
            const country = countryList[countryIndex];
            countryList.splice(countryIndex, 1);
            countryList.unshift(country);
            // this.form.pre_phone = country.code;
          }
        }
      };
      xhr.send();
    }
    this.form.pre_phone = localStorage.pre_phone
    this.form.phone = localStorage.phone
    this.form.remember = localStorage.remember

    if (this.form.pre_phone && this.form.phone) {
      this.form.username = parseInt(this.form.pre_phone) + this.form.phone
    }
  },
  methods: {
    handlerSelectCode(selectedItem) {
      console.log('selectedItem', selectedItem);
      this.form.pre_phone = selectedItem;
      this.form.username = parseInt(this.form.pre_phone) + this.form.phone

    },
    async login() {

      this.loading = true
      // if (!this.csrfCookieRetrieved) {
      //   await axios.get('/sanctum/csrf-cookie')
      //   this.csrfCookieRetrieved = true
      // }
      if (
        this.form.pre_phone &&
        this.form.phone &&
        this.form.username &&
        this.form.password
      ) {
        this.isErrorMessage = false
        // log in 
        // const pre = this.form.pre_phone.split('+')
        // const user = this.form.username.split('+')
        // this.form.pre_phone = pre[1]
        // this.form.username = user[1]


        const { data } = await this.form.post('/api/auth/login').then((response) => {

          console.log('response:' + response.data);
          console.log('status code:' + response.data.code);

          if (response.data.code == 200) {

            let d = new Date()
            d.setTime(d.getTime() + 1 * 24 * 60 * 60 * 1000) // 1 days
            let expires = 'expires=' + d.toUTCString()

            document.cookie = 'id=' + response.data.data.id + ';' + expires + ';path=/'
            document.cookie =
              'username=' + response.data.data.username + ';' + expires + ';path=/'
            document.cookie = 'token=' + response.data.token + ';' + expires + ';path=/'
            document.cookie = 'is_login=true;' + expires + ';path=/'
            if (response.data.token_type)
              document.cookie =
                'token_type=' + response.data.token_type + ';' + expires + ';path=/'
            if (response.data.exp)
              document.cookie = 'exp=' + response.data.exp + ';' + expires + ';path=/'
            if (response.data.exp_timestamp)
              document.cookie =
                'exp_timestamp=' +
                response.data.exp_timestamp +
                ';' +
                expires +
                ';path=/'

            this.authenticated = true

            localStorage.token = response.data.token
            localStorage.name = response.data.data.name
            localStorage.username = response.data.data.username
            localStorage.avatar = response.data.data.avatar

            if (this.form.remember == 1) {

              localStorage.pre_phone = this.form.pre_phone
              localStorage.phone = this.form.phone
              localStorage.remember = this.form.remember
            } else {

              localStorage.pre_phone = ''
              localStorage.phone = ''
              localStorage.remember = ''
            }

            // Store the user
            this.$store.dispatch('auth/updateUser', response.data)
            // this.$store.dispatch('message/success', {
            //   text: this.$t('Login successfully!'),
            // })

            this.$router.push({
              name:
                this.emailAuth && this.emailVerification
                  ? 'verification.index'
                  : 'home',
            })

          } else {

            this.loading = false
            console.log('message:' + response.data.message)
            // this.$store.dispatch('message/error', { text: response.data.message })
          }

        }).catch((error) => {

          this.loading = false
          console.log('error:' + error);
          console.log('message:' + error.message)
          // this.$store.dispatch('message/error', { text: 'The username or password is incorrect.' })
        });

      } else {
        this.loading = false
        this.isErrorMessage = true
        console.log('No username & password !!!')
        // this.$store.dispatch('message/error', {
        //   text: this.$t('Please enter username & password!!!'),
        // })
      }
      this.loading = false;
    },
    keep_remember(e) {
      console.log('e:' + e)
      console.log('remember:' + this.form.remember)

    },
    showMsg(event) {
      this.form.username = parseInt(this.form.pre_phone) + this.form.phone
      console.log('user:' + this.form.username)
    },
    isNumber: function (evt) {
      evt = evt ? evt : window.event
      var charCode = evt.which ? evt.which : evt.keyCode

      if (charCode === 43) {
        // หยุดการทำงานของฟังก์ชันนี้และไม่ป้องกันการเกิดอีเวนต์
        return true;
      }

      if (
        charCode > 31 &&
        (charCode < 48 || charCode > 57) &&
        charCode !== 46
      ) {
        evt.preventDefault()
      } else {
        return true
      }
    },
    addPlusIfNeeded: function (evt) {
      if (this.form.pre_phone.charAt(0) !== "+") {
        this.form.pre_phone = "+" + this.form.pre_phone;
      }
      else if (this.form.pre_phone === "+") {
        console.log(this.form.pre_phone);
        this.form.pre_phone = ''
      }

    }
  },
}
</script>
<style scoped>
::v-deep .v-text-field input {
  background: linear-gradient(90deg, #FAEB06 0%, #F6B705 15%, #F5B105 20%) !important;
  background-clip: text !important;
  color: transparent !important;
}

::v-deep .v-text-field input::placeholder {
  background: linear-gradient(90deg, #FAEB06 0%, #F6B705 84.1%, #F5B105 20%) !important;
  background-clip: text !important;
  color: transparent !important;
  opacity: 0.9;
}

.country-code-style {
  border: double 1px transparent;
  background-image: linear-gradient(#1e1e1e, #1e1e1e),
    linear-gradient(16deg, #faeb06, #f5b105);
  background-origin: border-box;
  background-clip: padding-box, border-box;
  height: 76%;
  border-radius: 8px;
  width: 84px;
}

::v-deep .v-select__selections,
::v-deep .v-input__append-inner .notranslate {
  background: linear-gradient(to bottom, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
  text-align: center;
}

.v-text-field>>>label {
  width: 100%;
  text-align: center;
}

.v-text-field--outlined>>>fieldset,
.v-text-field--outlined>>>fieldset:hover {
  padding: 0.5rem;
  border: double 1px transparent;
  border-radius: 4px;
  background-image: linear-gradient(#1e1e1e, #1e1e1e),
    linear-gradient(16deg, #faeb06, #f5b105);
  background-origin: border-box;
  background-clip: padding-box, border-box;
  border: 1px solid;
  align-items: center;
}

.error--text>>>fieldset {
  border-color: #fa0606;
}

.inactive {
  display: none;
}

.active {
  display: block;
}

.alert-style {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-weight: 400 !important;
  font-size: 12px !important;
  line-height: 20px !important;
  color: #c32b1f;
}

.alert-style i {
  color: #c32b1f;
  font-size: 18px;
  padding-bottom: 0px;
}

.phone__wrapper {
  display: grid;
  gap: 12px;
  grid-template-columns: 88px 1fr;
  margin-bottom: 10px;
}

::v-deep .v-list-item--highlighted {
  background: linear-gradient(to bottom, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
}


/* pre_phone */
.pphone .theme--dark.v-input input {
  background: linear-gradient(to right, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
  text-align: center;
}

.card-login {
  box-shadow: 0px 7px 8px 0px rgba(0, 0, 0, 0.2);
  max-width: 456px;
}

.card-login .v-card__text {
  background: #1e1e1e;
}

.title-login {
  color: black !important;
  font-weight: 700;
}

.form-login label {
  font-size: 12px;
  font-weight: 400;
  line-height: 20px;
}

.v-input--selection-controls {
  margin-top: 8px;
  padding-top: 0px;
}

.theme--dark.v-btn.v-btn--disabled {
  color: #000 !important;
}

.v-application .text-caption {
  font-size: 12px !important;
  font-weight: 400 !important;
  line-height: 20px !important;
  letter-spacing: 0em !important;
  text-align: left;
}

.style-wrap {
  min-width: 456px;
  padding: 0px !important;
}

@media screen and (max-width: 768px) {
  .style-wrap {
    min-width: 350px !important;
    padding: 20px !important;
  }
}
</style>
