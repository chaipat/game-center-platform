<template>
  <v-container class="container-mt" fluid>
    <v-row justify="center">
      <v-col sm="8" md="6" lg="6" class="style-wrap">
        <v-stepper alt-labels v-model="e1" style="background: transparent;box-shadow: none;">
          <v-stepper-header style="box-shadow: none;">
            <Steper :el="e1" />
          </v-stepper-header>
          <v-form ref="form" v-model="formIsValid" @submit.prevent="register">
            <v-stepper-items>
              <v-stepper-content class="pt-0 " step="1">
                <v-card class="elevation-12">
                  <v-toolbar class="d-flex justify-center dark--text gold-gradient">
                    <v-toolbar-title class="font-weight-bold" style="font-size: 20px">
                      {{ $t('REGISTRATION') }}
                    </v-toolbar-title>
                    <v-spacer />
                  </v-toolbar>
                  <v-card-text style="min-height: 257px;">
                    <input type="hidden" name="username" id="username" value="" v-model="ShowMessage" />
                    <input type="hidden" name="accept_consent" value="false" />
                    <div class="text-caption text-medium-emphasis text-gold-gradient">Phone number</div>
                    <v-row>
                      <v-col cols="auto" class="pe-1">
                        <v-select class="select-code text-center" style="width: 88px;" height="61" v-model="form.country_code"
                          :items="countryCodes" item-value="code" item-text="formattedText" outlined placeholder="+1"
                          @change="handlerSelectCode"> <template v-slot:selection="{ item }"
                            style="background-color: #F6B605 !important;">
                            {{ item.code }}
                          </template>
                        </v-select>
                      </v-col>
                      <v-col class="ps-1">
                        <v-text-field color="yellow" hide-details maxlength="22" v-model="form.phone" type="text"
                          name="phone" id="phone" height="61" :rules="[validationRequired]"
                          :error="form.errors.has('phone')" :error-messages="form.errors.get('phone')" outlined
                          @keydown="clearFormErrors" @input="showMsg" @keypress="isNumber($event)" />
                      </v-col>
                    </v-row>
                    <p v-if="(form.country_code === '' || form.country_code === null) && isErrorMessage"
                      class="alert-style mb-2">Please
                      require Country code
                      <v-icon>mdi-alert-circle</v-icon>
                    </p>
                    <p v-if="(form.phone === '' || form.phone === null) && isErrorMessage" class="alert-style">Please
                      require Phone number
                      <v-icon>mdi-alert-circle</v-icon>
                    </p>
                    <v-checkbox v-model="agreementAccepted" color="yellow" @click="showMsg">
                      <template v-slot:label>
                        <i18n :style="isMobile ? 'font-size: 13px;' : 'font-size: 16px;'" path="{0}{1}" tag="div">
                          <template v-slot:0>
                            <span style="color: #FFFFFF;opacity: 0.7;">I accept </span>
                            <a href="/terms"
                              style="color: #F6B605; text-underline-offset: 2px; text-decoration-line: underline; text-decoration-thickness: 1px;"
                              class="" @click.stop>
                              {{ $t('Terms of use') }}
                            </a>
                          </template>
                          <template v-slot:1>
                            <span style="color: #FFFFFF;opacity: 0.7;"> and </span>
                            <a href="/policy"
                              style="color: #F6B605; text-underline-offset: 2px; text-decoration-line: underline; text-decoration-thickness: 1px;"
                              class="" @click.stop>
                              {{ $t('Privacy policy') }}
                            </a>
                          </template>
                        </i18n>
                      </template>
                    </v-checkbox>

                    <vue-recaptcha v-if="recaptchaPublicKey" ref="recaptcha" :sitekey="recaptchaPublicKey"
                      :loadRecaptchaScript="true" :theme="this.$vuetify.theme.isDark ? 'dark' : 'light'" class="mb-3"
                      @verify="token => form.recaptcha = token" />

                    <v-row align="center">
                      <v-col class="text-center text-md-left">
                        <v-btn @click="chkstep1" large class="gold-gradient btn__font text-uppercase show-lg-btn"
                          :disabled="(form.phone === '' || form.phone === null) || (form.country_code === '' || form.country_code === null)">
                          {{ $t('Register') }}
                        </v-btn>
                        <v-btn @click="chkstep1" large class="gold-gradient btn__font show-sm-btn"
                          :disabled="(form.phone === '' || form.phone === null) || (form.country_code === '' || form.country_code === null)">
                          {{ $t('Register') }}
                        </v-btn>
                      </v-col>
                      <v-col class="text-center text-md-right text-gold-gradient">
                        <router-link style="color: #F6B605; text-decoration-line: none; " :to="{ name: 'login' }">
                          {{ $t('Already signed up?') }}
                        </router-link>
                      </v-col>
                    </v-row>


                  </v-card-text>
                </v-card>
              </v-stepper-content>

              <v-stepper-content class="pt-0" step="2">
                <v-card class="elevation-12">
                  <v-toolbar class="d-flex justify-center dark--text gold-gradient">
                    <v-toolbar-title class="font-weight-bold text-center">
                      {{ $t('OTP Verification') }}
                    </v-toolbar-title>
                    <v-spacer />
                  </v-toolbar>
                  <v-card-text style="min-height: 375px;">
                    <div class="my-7 text-medium-emphasis text-center" style="font-size: 16px;">Enter OTP sent to
                      <span style="color:#F6B605; font-weight: 500;">+{{ form.username }}</span>
                    </div>

                    <p class="text-center" style="font-size: 16px;">00:{{ lessthan10 }}{{ timerCount }}</p>

                    <v-row justify="center mb-1">
                      <v-col cols="12" sm="10" md="10" lg="10" style="max-width: 330px;">
                        <v-otp-input class="opt-input" length="6" height="62" type="number" v-model="form.opt"
                          :disabled="disabled == 1" @keypress="isNumber($event)"></v-otp-input>
                      </v-col>
                    </v-row>
                    <p v-if="isOTPErrorMessage" class="alert-style text-center">
                      OTP Incorrect, enter again
                    </p>
                    <div class="text-medium-emphasis text-center mb-8" style="font-size: 16px;">Didn’t receive OTP?
                      <span></span>
                      <a href="#"
                        style="color: #F6B605; text-underline-offset: 2px; text-decoration-line: underline; text-decoration-thickness: 1px; font-weight: 500;"
                        class="" @click="enable_verify">
                        {{ $t('Resend') }}
                      </a>
                    </div>
                    <v-row>
                      <v-col cols="12">
                        <v-btn large class="gold-gradient btn__font" style="width: 100%;height: 50px;" @click="chkstep2"
                          :disabled="disabled == 1">
                          {{ $t('Verify') }}
                        </v-btn>
                      </v-col>
                    </v-row>

                  </v-card-text>
                </v-card>
              </v-stepper-content>

              <v-stepper-content class="pt-0" step="3">
                <v-card class="elevation-12">
                  <v-toolbar class="d-flex justify-center dark--text gold-gradient">
                    <v-toolbar-title class="font-weight-bold ml-2">
                      {{ $t('Password ') }}
                    </v-toolbar-title>
                    <v-spacer />
                  </v-toolbar>
                  <v-card-text style="min-height: 311px;">
                    <!-- :label="$t('Password')" -->
                    <span class="text-caption text-medium-emphasis text-gold-gradient">
                      Password
                    </span>
                    <v-text-field class="mb-6" color="yellow" v-model="form.password" height="61" type="password"
                      hide-details name="password" :rules="[validationRequired, v => validationMinLength(v, 8)]"
                      :error="form.errors.has('password')" :error-messages="form.errors.get('password')" outlined
                      @keydown="clearFormErrors($event, 'password')" @input="chk_pass($event)" />
                    <p v-if="(form.password === '' || form.password === null) && isErrorMessage" class="alert-style">
                      Please require new password
                      <v-icon>mdi-alert-circle</v-icon>
                    </p>
                    <!-- :label="$t('Confirm password')" -->
                    <span class="text-caption text-medium-emphasis text-gold-gradient">
                      Confirm password
                    </span>
                    <v-text-field class="mb-6" hide-details color="yellow" v-model="form.password_confirmation"
                      type="password" name="password_confirmation" height="61"
                      :rules="[validationRequired, v => validationMatch(form.password, v)]"
                      :error="form.errors.has('password_confirmation')"
                      :error-messages="form.errors.get('password_confirmation')" outlined
                      @click:append="showPassword2 = !showPassword2"
                      @keydown="clearFormErrors($event, 'password_confirmation')" />
                    <p v-if="(form.password_confirmation === '' || form.password_confirmation === null) && isErrorMessage"
                      class="alert-style mb-2">Please require Confirm new
                      password
                      <v-icon>mdi-alert-circle</v-icon>
                    </p>
                    <p v-if="(form.password_confirmation !== form.password) && isErrorMessage" class="alert-style">
                      Password don’t
                      match,
                      Please enter
                      password again
                      <v-icon>mdi-alert-circle</v-icon>
                    </p>
                    <v-row>
                      <v-col cols="12">
                        <v-btn type="submit" @click="e1 = 3" large class="gold-gradient btn__font"
                          style="width: 100%;height: 50px;">
                          {{ $t('confirm') }}
                        </v-btn>
                      </v-col>
                    </v-row>

                  </v-card-text>
                </v-card>
              </v-stepper-content>
            </v-stepper-items>
          </v-form>
        </v-stepper>


      </v-col>
    </v-row>
  </v-container>
</template>


<script>
import { config } from '~/plugins/config'
import { countries } from '~/plugins/countries'
import axios from 'axios'
import Form from 'vform'
import FormMixin from '~/mixins/Form'
import DeviceMixin from '~/mixins/Device'
import Oauth from '~/components/Oauth'
import VueRecaptcha from 'vue-recaptcha'
import Web3Auth from '~/components/Web3Auth'
import VueCountryCode from "vue-country-code";
import FormParameter from '~/components/FormParameter'
import Steper from '~/components/Step/Steper'

export default {
  components: { FormParameter, Web3Auth, Oauth, VueRecaptcha, VueCountryCode, Steper },
  mixins: [FormMixin, DeviceMixin],
  middleware: 'guest',
  metaInfo() {
    return { title: this.$t('Registration') }
  },
  data() {
    return {
      e1: 1,
      agreementAccepted: false,
      showPassword: false,
      showPassword2: false,
      ShowMessage: null,
      country: null,
      countryCodes: countries,
      counting: false,
      timerEnabled: false,
      timerCount: 30,
      isErrorMessage: false,
      isOTPErrorMessage: false,
      lessthan10: null,
      disabled: 0,
      form: new Form({
        country_code: null,
        phone: null,
        username: null,
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
        remember: '', // it's important to pass empty string as false value so $request->filled('remember') returns false,
        recaptcha: null,
        opt: null,
        accept_consent: false,
        fields: {}
      })
    }
  }, watch: {
    timerEnabled(value) {
      if (value) {
        setTimeout(() => {
          this.timerCount--;
        }, 1000);
      }
    },
    timerCount: {
      handler(value) {
        // console.log('timing:', value);
        // console.log('otp:', this.form.opt);

        if (value == 0) {
          this.disabled = 1
          if (this.e1 == 2) {
            console.log('OTP has expired.');
            // this.$store.dispatch('message/error', { text: this.$t('OTP has expired.') })
          }
        }
        if (value > 0 && this.timerEnabled) {
          setTimeout(() => {
            this.timerCount--;
            this.lessthan10 = (this.timerCount < 10) ? '0' : '';
          }, 1000);
        }
      },
      immediate: true // This ensures the watcher is triggered upon creation
    }
  },
  computed: {
    appLogoUrl() {
      return config('app.logo')
    },
    emailAuth() {
      return config('settings.users.email_auth')
    },
    emailVerification() {
      return config('settings.users.email_verification')
    },
    recaptchaPublicKey() {
      return config('services.recaptcha.public_key')
    },
    fields() {
      return config('settings.users.fields')
    }
  },

  async created() {
    this.form.fields = this.fields.reduce((a, field) => ({ ...a, [field.id]: field.default }), {});
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
          // this.form.country_codฝe = country.code;
        }
      }
    };
    xhr.send();
  }
},
  methods: {
    handlerSelectCode(selectedItem) {
      console.log('selectedItem', selectedItem);
      this.form.country_code = selectedItem;
      this.form.username = parseInt(this.form.country_code) + this.form.phone
    },
    async register() {
      // Register the user
      if (this.form.password.length < 8) {

        this.isErrorMessage = true
        let errmsg = 'Password must be at least 8 characters.';
        console.log('errmsg:', errmsg);
        // this.$store.dispatch('message/error', { text: this.$t(errmsg + '!!!') })

      } else if (this.form.country_code && this.form.phone && this.form.password && this.form.password == this.form.password_confirmation) {

        console.log('chk password pass!!!');
        console.log(this.form);
        this.isErrorMessage = false
        await this.form.post('/api/auth/register').then((response) => {

          // console.log('response:' + response);
          // console.log('response data:' + response.data);
          // console.log('response data code:' + response.data.code);
          // console.log('response code:' + response.code);

          if (response.data.code == 200) {

            //Keep cookie
            let d = new Date();
            d.setTime(d.getTime() + 1 * 24 * 60 * 60 * 1000);
            let expires = "expires=" + d.toUTCString();
            // console.log('response:', response);
            localStorage.avatar = '/images/icon-user.png'

            document.cookie = "id=" + response.data.data.id + ";" + expires + ";path=/";
            document.cookie = "username=" + response.data.data.username + ";" + expires + ";path=/";
            document.cookie = "token=" + response.data.token + ";" + expires + ";path=/";
            document.cookie = "is_login=true;" + expires + ";path=/";
            if (response.data.token_type) document.cookie = "token_type=" + response.data.token_type + ";" + expires + ";path=/";
            if (response.data.exp) document.cookie = "exp=" + response.data.exp + ";" + expires + ";path=/";
            if (response.data.exp_timestamp) document.cookie = "exp_timestamp=" + response.data.exp_timestamp + ";" + expires + ";path=/";

            // localStorage.setItem('token', response.data.tokenn)
            localStorage.token = response.data.token
            localStorage.name = this.form.username
            localStorage.username = this.form.username
            // localStorage.username = response.data.username

            // Store the user
            this.$store.dispatch('auth/updateUser', response.data);
            this.$store.state.auth.user.data.balance = 0;
            // this.$store.dispatch('message/success', { text: this.$t('You have successfully registered!') })

            this.$router.push({ name: this.emailAuth && this.emailVerification ? 'verification.index' : 'home' })

          } else {

            let errmsg = 'The username has already been taken.';
            console.log('response:' + response.message);

            // if (response.message)
            //   this.$store.dispatch('message/error', { text: this.$t(response.message + '!!!') })
            // else
            //   this.$store.dispatch('message/error', { text: this.$t(errmsg + '!!!') })
          }

        }).catch((error) => {

          if (this.recaptchaPublicKey) {
            this.form.recaptcha = null
            this.$refs.recaptcha.reset()
          }
          // return {}

          console.log('error:', error);

          let err_message = JSON.parse(error.request.response)

          // if (err_message.message)
          //   this.$store.dispatch('message/error', { text: this.$t(err_message.message + '!!!') })
          // else
          //   this.$store.dispatch('message/error', { text: this.$t(error.message + '!!!') })
        });

        // in case of any error data will be undefined

      } else {
        this.isErrorMessage = true
        let errmsg = 'Please enter your password!!!';
        console.log('No password !!!');
        // this.$store.dispatch('message/error', { text: this.$t(errmsg + '!!!') })

      }

    }, addPlusIfNeeded: function (evt) {
      if (this.form.country_code.charAt(0) !== "+") {
        this.form.country_code = "+" + this.form.country_code;
      } else if (this.form.country_code === "+") {
        console.log(this.form.country_code);
        this.form.country_code = ''
      }
    }, showMsg(event) {

      this.form.username = parseInt(this.form.country_code) + this.form.phone
      this.ShowMessage = this.form.username
      // console.log('user:' + this.form.username);
      // console.log('agreementAccepted:' + this.agreementAccepted);
    }, chkstate(event) {

      console.log('state:' + this.e1);

    }, async chkstep1(event) {

      console.log('check step 1.');
      let errMgs = '';
      let code = '';

      if (this.form.country_code && this.form.phone && this.form.username && this.agreementAccepted) {
        this.isErrorMessage = false

        let res_message = null;
        let postdata = { username: this.form.username };
        let response = await axios.post("/api/auth/checkusername", postdata)
          .then(response => {

            code = response.data.code;
            res_message = response.data.message;
            console.log('response:', response);
            console.log('code:', code);

            if (code == 200) {

              this.e1 = 2
              console.log('state:' + this.e1);
              this.timerEnabled = true
            }
          }).catch(err => {

            // code = err.response.data.code;
            // errMsg = err.response.data.message;
            errMgs = 'Username exists in the system.';

            console.log('Catch:', err);
            // console.log('errMsg:',errMsg);
            console.log(errMgs);
            // this.$store.dispatch('message/error', { text: errMgs })
          }).done(res => {

            console.log('done:', res);

          });

        // console.log('else:',response);

      } else {
        this.isErrorMessage = true
        if (!this.form.country_code) {
          errMgs = 'Incorrect country code.';
        } else if (!this.form.phone) {
          errMgs = 'Incorrect phone no.';
        } else if (!this.agreementAccepted) {
          errMgs = 'Please accept.';
        } else {
          errMgs = 'Please enter phone number and accept!!!';
        }

        console.log(errMgs);
        // this.$store.dispatch('message/error', { text: errMgs })
      }
      // console.log('state:' + this.e1);
      console.log('end method');

    }, chkstep2(event) {

      let opt = this.form.opt;

      console.log('opt:' + opt);
      // console.log('opt length:' + opt.length);

      if (opt == "000000") {
        this.isOTPErrorMessage = false
        this.e1 = 3
        console.log('opt true');
      } else {

        console.log('opt false');

        if (opt) {
          this.isOTPErrorMessage = true
          console.log('error:otp is invalid!!!');
          // this.$store.dispatch('message/error', { text: this.$t('otp is invalid!!!') })
        } else {

          console.log('error:Please enter otp!!!');
          // this.$store.dispatch('message/error', { text: this.$t('Please enter otp!!!') })
        }

      }

    }, isNumber: function (evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;

      console.log('charCode:' + charCode);
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();
      } else if (charCode == 13) {
        evt.preventDefault();
        console.log("Enter!!!");
      } else {
        return true;
      }
    }, play() {
      this.timerEnabled = true;
    }, pause() {
      this.timerEnabled = false;
    }, enable_verify() {
      if (this.timerCount == 0) {
        this.timerCount = 30
        this.disabled = 0
        this.form.opt = '';
      } else {
        console.log('error:Please wait a moment !!!');
        // this.$store.dispatch('message/error', { text: this.$t('Please wait a moment !!!') })
      }
    }, chk_pass(e) {

      console.log(this.form.password);
      console.log('length:', this.form.password.length);

    }
  }
}
</script>
<style scoped>
::v-deep .v-text-field input {
  background: linear-gradient(90deg, #FAEB06 0%, #F6B705 15%, #F5B105 20%) !important;
  background-clip: text !important;
  color: transparent !important;
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

/* 
::v-deep .vue-country-select .dropdown.open {
  background-color: #ffffff00;
  border-radius: 8px;
}

::v-deep .vue-country-select .dropdown-item {
  color: #000 !important;
} */

::v-deep .v-text-field input::placeholder {
  background: linear-gradient(90deg, #FAEB06 0%, #F6B705 84.1%, #F5B105 20%) !important;
  background-clip: text !important;
  color: transparent !important;
  opacity: 0.9;
}

::v-deep .opt-input .v-input__control {
  box-shadow: 0px 5px 7px rgba(255, 208, 0, 0.1);
  border-radius: 8px;
}

::v-deep .opt-input .v-input__control fieldset {
  border: 1.3px solid;
  border-image: linear-gradient(90deg, #FAEB06 0%, #F6B705 84.1%, #F5B105 20%);
}

::v-deep .opt-input .v-input {
  margin-bottom: 0px !important;
}

::v-deep .opt-input .v-input__control .v-text-field__slot input {
  color: white !important;
}

::v-deep .opt-input .v-input__control .v-text-field__slot {
  background: rgb(255 255 255 / 4%) !important;
}

::v-deep .v-select__selections,
::v-deep .v-input__append-inner .notranslate {
  background: linear-gradient(to bottom, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
  text-align: center;
}


::v-deep .v-list-item--highlighted {
  background: linear-gradient(to bottom, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
}

::v-deep .v-select-list .v-select-scrollbar {
  background: linear-gradient(90deg, #f3e745 0%, #facb4b 84%, #fac84a 100%);
}

::v-deep .v-select-list .v-select-scrollbar::-webkit-scrollbar {
  width: 8px;
}

::v-deep .v-select-list .v-select-scrollbar::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px black;
  border-radius: 10px;
}

::v-deep .v-select-list .v-select-scrollbar::-webkit-scrollbar-thumb {
  background: linear-gradient(90deg, #faeb06 0%, #f6b705 84%, #f5b105 100%);
  border-radius: 10px;
}

::v-deep .v-select-list .v-select-scrollbar::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(90deg, #f3e745 0%, #facb4b 84%, #fac84a 100%);
}

.v-text-field>>>label {
  width: 100%;
  text-align: center;
}

.container-mt {
  margin-top: 10%;
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

.v-text-field--outlined>>>fieldset {
  padding: 0.5rem;
  border: double 1px transparent;
  border-radius: 6px;
  background-image: linear-gradient(#1e1e1e, #1e1e1e), linear-gradient(16deg, #faeb06, #f5b105);
  background-origin: border-box;
  background-clip: padding-box, border-box;
}


.v-otp-input>>>input {
  font-family: "Inter", sans-serif;
  text-align: center;
  font-size: 31.21px;
  line-height: 37.77px;
  font-weight: 500;
}

.v-otp-input>>>fieldset {
  border: double 1px transparent;
  border-radius: 6px;
  background-image: linear-gradient(#1e1e1e, #1e1e1e), linear-gradient(16deg, #faeb06, #f5b105);
  background-origin: border-box;
  background-clip: padding-box, border-box;
}

.v-text-field--outlined>>>fieldset {
  padding: 0.5rem;
  border: double 1px transparent;
  border-radius: 6px;
  background-image: linear-gradient(#1e1e1e, #1e1e1e), linear-gradient(16deg, #faeb06, #f5b105);
  background-origin: border-box;
  background-clip: padding-box, border-box;
}

button:disabled {
  background: #dddddd;
}

.error--text>>>fieldset {
  border-color: #fa0606;
}

.theme--dark.v-stepper .v-stepper__step__step {
  color: black !important;
}

.show-sm-btn {
  display: none;
}

.show-lg-btn {
  display: block;
}

.style-wrap {
  max-width: 504px;
  padding: 0px !important;
}

@media screen and (max-width: 768px) {
  .show-sm-btn {
    display: block;
  }

  .container-mt {
    margin-top: 6%;
  }

  .show-lg-btn {
    display: none;
  }

  .style-wrap {
    max-width: 350px !important;
  }

  ::v-deep .v-stepper__content {
    padding: 0px !important;
  }
}
</style>
