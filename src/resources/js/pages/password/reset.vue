<template>
  <v-container class="container-mt" fluid>
    <v-row align="center" justify="center">
      <v-col sm="12" md="6" lg="5" class="style-wrap">
        <v-stepper alt-labels v-model="e1" color="yellow" style="background: transparent;box-shadow: none;">

          <v-stepper-header style="box-shadow: none;">
            <Steper :el="e1" />
          </v-stepper-header>
          <v-form ref="form" v-model="formIsValid" @submit.prevent="reset">

            <v-stepper-items>
              <v-stepper-content class="pt-0" step="1">
                <v-card class="elevation-12">
                  <v-toolbar class="d-flex justify-center dark--text gold-gradient">
                    <v-toolbar-title class="font-weight-bold" style="font-size: 20px">
                      {{ $t('Reset Password') }}
                    </v-toolbar-title>
                    <v-spacer />
                  </v-toolbar>
                  <v-card-text>
                    <input type="hidden" name="ref_code" id="ref_code" value="" />
                    <input type="hidden" name="username" id="username" value="" v-model="ShowMessage" />
                    <span class="text-caption text-medium-emphasis text-gold-gradient">
                      Phone number
                    </span>
                    <v-row>
                      <v-col cols="auto" class="pe-1">
                        <v-select class="select-code text-center" style="width: 88px;" height="61" v-model="form.country_code"
                          :items="countryCodes" item-value="code" item-text="formattedText" outlined  placeholder="+1"
                          @change="handlerSelectCode"> <template v-slot:selection="{ item }">
                            {{ item.code }}
                          </template>
                        </v-select>
                      </v-col>
                      <v-col class="ps-1">
                        <v-text-field class="mb-0 text-start text-gold-gradient" hide-details height="61"
                          v-model="form.phone" name="phone" placeholder="" outlined @keydown="clearFormErrors"
                          @keypress="isNumber($event)">
                          <template slot="label"> </template>
                        </v-text-field>

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
                    <v-row>
                      <v-col cols="12">
                        <v-btn @click="chkstep1" large class="gold-gradient btn__font"
                          style="width: 100%;height: 50px;">
                          {{ $t('Send OTP') }}
                        </v-btn>
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
                    <div class="my-7 text-alter-style text-center " style="font-size: 16px;">Enter OTP sent to
                      <span class="text-color-style">+{{ form.username }}</span>
                    </div>
                    <p class="text-center" style="font-size: 16px;">00:{{ lessthan10 }}{{ timerCount }}</p>
                    <v-row justify="center mb-1">
                      <v-col cols="12" sm="10" md="10" lg="10" style="max-width: 330px;">
                        <v-otp-input class="opt-input" length="6" height="62" v-model="form.opt"
                          :disabled="disabled == 1" @keypress="isNumber($event)"></v-otp-input>
                      </v-col>
                    </v-row>
                    <p v-if="isOTPErrorMessage" class="alert-style text-center">
                      OTP Incorrect, enter again
                    </p>
                    <div class="text-alter-style text-center mb-8" style="font-size: 16px;">Didn’t receive OTP?
                      <span></span>
                      <a href="#"
                        style="color: #F6B605; text-underline-offset: 2px; text-decoration-line: underline; text-decoration-thickness: 1px;"
                        class="text-color-style" @click="enable_verify">
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
                      {{ $t('Reset Password ') }}
                    </v-toolbar-title>
                    <v-spacer />
                  </v-toolbar>
                  <v-card-text style="min-height: 311px;">
                    <span class="text-caption text-medium-emphasis text-gold-gradient">
                      New password
                    </span>
                    <!-- <div class="mt-2 text-caption text-medium-emphasis yellow--text">New Password</div> -->
                    <v-text-field class="mb-6" hide-details color="yellow" v-model="form.password" type="password"
                      height="61" name="password" :rules="[validationRequired, v => validationMinLength(v, 8)]"
                      :error="form.errors.has('password')" :error-messages="form.errors.get('password')" outlined
                      counter @click:append="showPassword = !showPassword"
                      @keydown="clearFormErrors($event, 'password')" />
                    <p v-if="(form.password === '' || form.password === null) && isErrorMessage" class="alert-style">
                      Please require
                      new password
                      <v-icon>mdi-alert-circle</v-icon>
                    </p>
                    <span class="text-caption text-medium-emphasis text-gold-gradient">
                      Confirm new password
                    </span>

                    <!-- <div class="text-caption text-medium-emphasis yellow--text">Confirm password</div> -->
                    <v-text-field class="mb-6" hide-details color="yellow" v-model="form.password_confirmation"
                      type="password" name="password_confirmation" height="61"
                      :rules="[validationRequired, v => validationMatch(form.password, v)]"
                      :error="form.errors.has('password_confirmation')"
                      :error-messages="form.errors.get('password_confirmation')" outlined counter
                      @click:append="showPassword2 = !showPassword2"
                      @keydown="clearFormErrors($event, 'password_confirmation')" />
                    <p v-if="(form.password_confirmation === '' || form.password_confirmation === null) && isErrorMessage"
                      class="alert-style mb-2">Please require Confirm new password
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
import {
  config
} from '~/plugins/config'
import { countries } from '~/plugins/countries'
import axios from 'axios'
import Form from 'vform'
import FormMixin from '~/mixins/Form'
import VueCountryCode from "vue-country-code";
import Steper from '~/components/Step/Steper'


export default {
  components: { VueCountryCode, Steper },
  mixins: [FormMixin],
  middleware: ['guest', 'email_auth'],
  metaInfo() {
    return {
      title: this.$t('Password reset')
    }
  },

  data: () => ({
    e1: 1,
    showPassword: false,
    showPassword2: false,
    ShowMessage: null,
    counting: false,
    timerEnabled: false,
    timerCount: 30,
    isErrorMessage: false,
    isOTPErrorMessage: false,
    lessthan10: null,
    disabled: 0,
    countryCodes: countries,
    form: new Form({
      token: null,
      country_code: null,
      phone: null,
      username: null,
      password: null,
      password_confirmation: null,
      opt: null,
      ref_code: null
    })
  }), watch: {

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
            this.$store.dispatch('message/error', { text: this.$t('OTP has expired.') })
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

  }, computed: {
    appLogoUrl() {
      return config('app.logo')
    }
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
            // this.form.country_code = country.code;
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
    async reset() {
      if (this.form.username && this.form.password && this.form.ref_code && this.form.password == this.form.password_confirmation) {
        this.isErrorMessage = false
        const { data } = await this.form.put('/api/auth/set_password')

        if (data.code == 200) {

          await this.$store.dispatch('auth/fetchUser')

          // this.$store.dispatch('message/success', { text: data.message })
          this.$store.dispatch('message/success', { text: this.$t('You have successfully changed your password!') })
          this.$router.push({ name: 'home' })
        } else {

          let errmsg1 = 'There is no username.!!!';

          if (data.message)
            this.$store.dispatch('message/error', { text: this.$t(data.message + '!!!') })
          else
            this.$store.dispatch('message/error', { text: this.$t(errmsg1 + '!!!') })
        }

      } else {
        this.isErrorMessage = true
        let errmsg = 'Please enter your username & password!!!';

        if (!this.form.country_code) {
          msg = 'Incorrect country code.';
        } else if (!this.form.phone) {
          msg = 'Incorrect phone no.';
        } else if (this.form.password != this.form.password_confirmation) {
          errmsg = 'Password confirmation is incorrect.!!!';
        }

        // console.log('data:' + data.message);
        this.$store.dispatch('message/error', { text: this.$t(errmsg + '!!!') })
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
      this.form.ref_code = this.form.username
      // this.ShowMessage = this.form.username
      // console.log('ref_code:' + this.form.ref_code);

    }, chkstate(event) {

      this.form.ref_code = this.form.opt
      console.log('state:' + this.e1);
      console.log('ref_code:' + this.form.opt);

    }, chkstep1(event) {

      console.log('check step 1.');

      if (this.form.country_code && this.form.phone) {
        this.form.username = parseInt(this.form.country_code) + this.form.phone
        this.isErrorMessage = false
        let errMsg = null;
        let code = null;
        let pass = false;
        let res_message = null;
        let postdata = { username: this.form.username };
        console.log('this.form:' + this.form.username);

        let response = axios.post("/api/auth/checkusername", postdata)
          .then(response => {

            code = response.data.code;
            res_message = response.data.message;

            console.log('res from service:', res_message);
            errMsg = 'Username is not in the system.';

            console.log('error:', errMsg);
            this.$store.dispatch('message/error', { text: errMsg })

          }).catch(err => {

            pass = true;
            errMsg = err.response.data.message;

            console.log('Catch:', err);
            // console.log('errMsg:',errMsg);

            this.e1 = 2
            console.log('state:' + this.e1);
            this.timerEnabled = true
          });

      } else {
        this.isErrorMessage = true
        errMsg = '';

        if (!this.form.country_code) {
          errMsg = 'Incorrect country code.';
        } else if (!this.form.phone) {
          errMsg = 'Incorrect phone no.';
        } else {
          errMsg = 'error:Please enter country code and phone number!!!';
        }

        console.log(errMsg);
        this.$store.dispatch('message/error', { text: errMsg })
      }
      console.log('state:' + this.e1);
      // this.startCountdown()

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
          this.$store.dispatch('message/error', { text: this.$t('otp is invalid!!!') })
        } else {

          console.log('error:Please enter otp!!!');
          this.$store.dispatch('message/error', { text: this.$t('Please enter otp!!!') })
        }
      }

    }, isNumber: function (evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;

      // console.log('charCode:' + charCode);
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
        this.$store.dispatch('message/error', { text: this.$t('Please wait a moment !!!') })
      }
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

::v-deep .opt-input .v-input {
  margin-bottom: 0px !important;
}

::v-deep .opt-input .v-input__control .v-text-field__slot input {
  color: white !important;
}

::v-deep .opt-input .v-input__control .v-text-field__slot {
  background: rgb(255 255 255 / 4%) !important;
}

.text-color-style {
  font-weight: 500 !important;
  font-size: 16px !important;
  line-height: 20px !important;
  color: #F6B605;
}

.text-alter-style {
  font-weight: 400 !important;
  font-size: 16px !important;
  line-height: 20px !important;
  color: rgba(255, 255, 255, 0.7);
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

::v-deep .v-list-item--highlighted {
  background: linear-gradient(to bottom, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
}

.v-text-field>>>label {
  width: 100%;
  text-align: center;
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

.error--text>>>fieldset {
  border-color: #fa0606;
}

.theme--dark.v-stepper .v-stepper__step__step {
  color: black !important;
}

.style-wrap {
  max-width: 504px;
  padding: 0px !important;
}

.container-mt {
  margin-top: 10%;
}

@media screen and (max-width: 768px) {
  .style-wrap {
    max-width: 350px !important;
  }

  ::v-deep .v-stepper__content {
    padding: 0px !important;
  }

  .container-mt {
    margin-top: 6%;
  }
}
</style>