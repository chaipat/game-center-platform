<template>
  <v-container class="container-mt" fluid>
    <v-row justify="center">
      <v-col sm="12" md="6" lg="6" class="style-wrap">
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
                      {{ $t('Change Password') }}
                    </v-toolbar-title>
                    <v-spacer />
                  </v-toolbar>
                  <v-card-text>
                    <input type="hidden" name="username" id="username" value="" />
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
                        <v-text-field color="yellow" hide-details maxlength="22" v-model="form.phone" type="text"
                          name="phone" id="phone" height="61" :rules="[validationRequired]"
                          :error="form.errors.has('phone')" :error-messages="form.errors.get('phone')" outlined
                          @keydown="clearFormErrors" @input="showMsg" @keypress="isNumber($event)" />
                      </v-col>
                    </v-row>
                    <p v-if="(form.country_code === '' || form.country_code === null) && isErrorMessage"
                      class="alert-style">Please require
                      Country code
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
                    <div class="my-7 text-medium-emphasis text-center" style="font-size: 16px;">Enter OTP sent to
                      <span style="color:#F6B605;">+{{ form.username }}</span>
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
                        style="color: #F6B605; text-underline-offset: 2px; text-decoration-line: underline; text-decoration-thickness: 1px;"
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
                      {{ $t('Change Password ') }}
                    </v-toolbar-title>
                    <v-spacer />
                  </v-toolbar>
                  <v-card-text style="min-height: 311px;">
                    <span class="text-caption text-medium-emphasis text-gold-gradient">
                      New password
                    </span>
                    <v-text-field class="mb-6" hide-details v-model="form.new_password" type="password"
                      name="new_password" :rules="[validationRequired, v => validationMinLength(v, 8)]" height="61"
                      :error="form.errors.has('new_password')" :error-messages="form.errors.get('new_password')"
                      outlined @keydown="clearFormErrors($event, 'new_password')" />
                    <p v-if="(form.new_password === '' || form.new_password === null) && isErrorMessage"
                      class="alert-style">Please
                      require new password
                      <v-icon>mdi-alert-circle</v-icon>
                    </p>
                    <span class="text-caption text-medium-emphasis text-gold-gradient">
                      Confirm new password
                    </span>
                    <v-text-field class="mb-6" hide-details v-model="form.new_password_confirmation" height="61"
                      type="password" name="new_password_confirmation"
                      :rules="[validationRequired, v => validationMatch(form.new_password, v)]"
                      :error="form.errors.has('new_password_confirmation')"
                      :error-messages="form.errors.get('new_password_confirmation')" outlined counter
                      @keydown="clearFormErrors($event, 'new_password_confirmation')" />
                    <p v-if="(form.new_password_confirmation === '' || form.new_password_confirmation === null) && isErrorMessage"
                      class="alert-style">Please require Confirm new
                      password
                      <v-icon>mdi-alert-circle</v-icon>
                    </p>
                    <p v-if="(form.new_password_confirmation !== form.new_password) && isErrorMessage"
                      class="alert-style">Password
                      don’t
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
import { mapGetters } from 'vuex'
import VueCountryCode from "vue-country-code";
import Steper from '~/components/Step/Steper'

export default {
  components: { VueCountryCode, Steper },
  mixins: [FormMixin],
  middleware: ['guest', 'email_auth'],
  metaInfo() {
    return {
      title: this.$t('Password change')
    }
  },
  data: () => ({
    e1: 1,
    showPassword: false,
    showPassword2: false,
    token: null,
    uid: null,
    username: null,
    name: null,
    exp_timestamp: null,
    exp: null,
    timerEnabled: false,
    timerCount: 30,
    isErrorMessage: false,
    isOTPErrorMessage: false,
    lessthan10: null,
    disabled: 0,
    countryCodes: countries,
    form: new Form({
      username: null,
      country_code: null,
      phone: null,
      new_password: null,
      new_password_confirmation: null
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

  }, computed: {
    ...mapGetters({ authenticated: 'auth/check' }),
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
    console.log('authenticated:' + this.authenticated);
    if (this.authenticated) {

      console.log('auth fetchUser !!!');
      this.$store.dispatch('auth/fetchUser')
    } else {

      console.log('auth failed !!!');
    }

  },
  methods: {
    handlerSelectCode(selectedItem) {
      console.log('selectedItem', selectedItem);
      this.form.country_code = selectedItem;
      this.form.username = parseInt(this.form.country_code) + this.form.phone
    },
    async reset(e) {

      console.log('state:', this.e1);

      if (this.e1 == 3) {
        console.log('change password !!!');

        if (this.form.new_password && this.form.new_password == this.form.new_password_confirmation) {
          this.isErrorMessage = false
          console.log('change password pass!!!');

          const { data } = await this.form.post('/api/auth/changepassword', {
            headers: {
              'Authorization': 'Bearer ' + this.token,
            }
          })

          if (data) {

            await this.$store.dispatch('auth/fetchUser')
            // this.$store.dispatch('message/success', { text: data.message })
            this.$router.push({ name: 'home' })

          } else {

            let errmsg = 'The username has already been taken.';
            // console.log('data:' + data.message);
            // this.$store.dispatch('message/error', { text: this.$t(errmsg + '!!!') })
          }

        } else {
          this.isErrorMessage = true
          let errmsg = 'Please enter your password!!!';

          if (this.form.new_password != this.form.new_password_confirmation) {
            errmsg = 'Confirm password is incorrect.!!!';
          }
          // console.log('data:' + data.message);
          // this.$store.dispatch('message/error', { text: this.$t(errmsg + '!!!') })

        }
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
      console.log('user:' + this.form.username);

    }, chkstate(event) {

      console.log('state:' + this.e1);

    }, chkstep1(event) {
      console.log("form---------------", this.form);

      let msg = ''

      console.log('check step 1.');
      // console.log('form country_code:' + this.form.country_code);
      // console.log('form phone:' + this.form.phone);
      // console.log('form username:' + this.form.username);

      // console.log('this.username:', this.username);
      // console.log('this.form.username:', this.form.username);

      if (this.form.country_code && this.form.phone && this.form.username && this.form.username == this.username) {
        console.log('ok');
        this.isErrorMessage = false
        this.e1 = 2
        console.log('state:' + this.e1);
        this.timerEnabled = true
      } else {
        this.isErrorMessage = true
        console.log('error');
        if (!this.form.country_code) {
          msg = 'Incorrect country code.';
        } else if (!this.form.phone) {
          console.log(this.form.phone);
          msg = 'Incorrect phone no.';
        } else if (this.form.username != this.username) {
          msg = 'Incorrect phone no.'

          // this.$store.dispatch('message/error', { text: msg })
        } else {

          msg = 'error:Please enter phone number!!!'

          // console.log('error:Please enter phone number!!!');
          // this.$store.dispatch('message/error', { text: msg })
        }

        // msg = 'error:Please enter phone number!!!'
        console.log(msg);
        // this.$store.dispatch('message/error', { text: msg })

      }
      console.log('state:' + this.e1);
    }, chkstep2(event) {

      let opt = this.form.opt;

      console.log('opt:' + opt);
      // console.log('opt length:' + opt.length);
      if (opt == "000000") {
        this.isOTPErrorMessage = false
        this.e1 = 3
        console.log('opt true');
      } else {

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

      // console.log('charCode:' + charCode);
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();;
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

    }
  }, async mounted(route, params) {

    // const today = new Date();
    // console.log('today:' + today);
    const today = new Date();
    const date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    const dateTime = date + ' ' + time;
    console.log('currentDate:' + dateTime);

    this.token = localStorage.getItem('token')
    // console.log('token:' + this.token);

    if (!this.authenticated) {

      this.authenticated = true
      this.$store.dispatch('auth/fetchUser')

    }

    await axios.get('/api/auth/me', {
      headers: {
        'Authorization': 'Bearer ' + this.token,
        'Accept': 'application/json'
      }
    }).then((response) => {

      // console.log('response:' + response.data);
      // console.log('code:' + response.data.code);
      if (response.data.code == 200) {

        this.uid = response.data.data.id
        this.username = response.data.data.username
        this.name = response.data.data.name

        // console.log('username:' + this.username);
      }
    })
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
  background: linear-gradient(to right, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
  opacity: 0.9;
}

::v-deep .opt-input .v-input__control {
  box-shadow: 0px 3px 9px rgba(255, 208, 0, 0.2);
  border-radius: 8px;
}

::v-deep .opt-input .v-input__control fieldset {
  border: 1px solid;
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


::v-deep .v-list-item--highlighted {
  background: linear-gradient(to bottom, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
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

.theme--dark.v-stepper .v-stepper__step__step {
  color: black !important;
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

button:disabled {
  background: #dddddd;
}

.error--text>>>fieldset {
  border-color: #fa0606;
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
    min-width: 350px !important;
  }

  .container-mt {
    margin-top: 6%;
  }
}
</style>