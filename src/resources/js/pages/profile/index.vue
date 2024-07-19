<template>
  <v-container class="fill-height" fluid style="backdrop-filter: blur(1px)">
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="6" lg="5">
        <v-row justify="center">
          <v-col class=" card2" outlined>
            <v-row justify="center">
              <v-col cols="auto">
                <v-img src="images/logo/Logo.svg" width="50" height="50"></v-img></v-col>
            </v-row>
            <v-row justify="center">
              <v-col cols="auto" align-self="center">
                <span class="text-name">{{ name }}</span>
                <v-btn class="mx-2" fab dark x-small @click="EditProfile" title="Edit profile">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                    <path fill="white"
                      d="M16.293 3.293a1 1 0 0 1 1.414 0l3 3a1 1 0 0 1 0 1.414l-9 9A1 1 0 0 1 11 17H8a1 1 0 0 1-1-1v-3a1 1 0 0 1 .293-.707zM9 13.414V15h1.586l8-8L17 5.414zM3 7a2 2 0 0 1 2-2h5a1 1 0 1 1 0 2H5v12h12v-5a1 1 0 1 1 2 0v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                  </svg>
                  <!-- <v-icon dark> mdi-edit-alt </v-icon> -->
                </v-btn>
              </v-col>
            </v-row>
            <v-row no-gutters justify="center">
              <v-col cols="auto" align-self="center">
                <span class="text-subtitle-style">Registered {{ formattedDate  }}</span>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-col class="border-item">
                  <v-row justify="center">
                    <v-col cols="auto">
                      <span class="text-subtitle-style">Bets</span>
                    </v-col>
                  </v-row>
                  <v-row justify="center">
                    <v-col align-self="center" cols="auto" class="pr-0">
                      <v-img src="images/icons/image 268.png" width="18" height="18"></v-img>
                    </v-col>
                    <v-col align-self="center" cols="auto">
                      <span class="text-value-style">{{ bet | currencyFormat }}</span>
                    </v-col>
                  </v-row>
                </v-col>
              </v-col>
              <v-col cols="12" sm="4">
                <v-col class="border-item">
                  <v-row justify="center">
                    <v-col cols="auto">
                      <span class="text-subtitle-style">Wins</span>
                    </v-col>
                  </v-row>
                  <v-row justify="center">
                    <v-col align-self="center" cols="auto" class="pr-0">
                      <v-img src="images/icons/image 268-2.png" width="18" height="18"></v-img>
                    </v-col>
                    <v-col align-self="center" cols="auto">
                      <span class="text-value-style">{{ win | currencyFormat }}</span>
                    </v-col>
                  </v-row>
                </v-col>
              </v-col>
              <v-col cols="12" sm="4">
                <v-col class="border-item">
                  <v-row justify="center">
                    <v-col cols="auto">
                      <span class="text-subtitle-style">Losses</span>
                    </v-col>
                  </v-row>
                  <v-row justify="center">
                    <v-col align-self="center" cols="auto" class="pr-0">
                      <v-img src="images/icons/image 268-3.png" width="18" height="18"></v-img>
                    </v-col>
                    <v-col align-self="center" cols="auto">
                      <span class="text-value-style">{{ losses | currencyFormat }}</span>
                    </v-col>
                  </v-row>
                </v-col>
              </v-col>
              <v-col cols="12" sm="4">
                <v-col class="border-item">
                  <v-row justify="center">
                    <v-col cols="auto">
                      <span class="text-subtitle-style">Wagered</span>
                    </v-col>
                  </v-row>
                  <v-row justify="center">
                    <v-col align-self="center" cols="auto" class="pr-0">
                      <v-img src="images/icons/image 268-6.png" width="18" height="18"></v-img>
                    </v-col>
                    <v-col align-self="center" cols="auto">
                      <span class="text-value-style">{{ wagered | currencyFormat }}</span>
                    </v-col>
                  </v-row>
                </v-col>
              </v-col>
              <v-col cols="12" sm="4">
                <v-col class="border-item">
                  <v-row justify="center">
                    <v-col cols="auto">
                      <span class="text-subtitle-style">Profit</span>
                    </v-col>
                  </v-row>
                  <v-row justify="center">
                    <v-col align-self="center" cols="auto" class="pr-0">
                      <v-img src="images/icons/image 268-5.png" width="18" height="18"></v-img>
                    </v-col>
                    <v-col align-self="center" cols="auto">
                      <span class="text-value-style">{{ profit | currencyFormat }}</span>
                    </v-col>
                  </v-row>
                </v-col>
              </v-col>
              <v-col cols="12" sm="4">
                <v-col class="border-item">
                  <v-row justify="center">
                    <v-col cols="auto">
                      <span class="text-subtitle-style">Max profit</span>
                    </v-col>
                  </v-row>
                  <v-row justify="center">
                    <v-col align-self="center" cols="auto" class="pr-0">
                      <v-img src="images/icons/image 268-4.png" width="18" height="18"></v-img>
                    </v-col>
                    <v-col align-self="center" cols="auto">
                      <span class="text-value-style">{{ max_profit | currencyFormat }}</span>
                    </v-col>
                  </v-row>
                </v-col>
              </v-col>

            </v-row>
          </v-col>
        </v-row>


      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { config } from '~/plugins/config'
import moment from 'moment';
import Vue from 'vue'
// import VueCookies from 'vue-cookies'
import axios from "axios";
// import Form from 'vform'
// import FormMixin from '~/mixins/Form'
import { mapGetters } from 'vuex'

Vue.filter('currencyFormat', function (value) {
  return parseFloat(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
});

new Vue({
  el: '#app',
  data: {
    bet: "33002.00"
  }
});

export default {
  metaInfo() {
    return {
      title: this.$t('Profile')
    }
  },

  data: () => ({
    name: false,
    name: null,
    avatar: false,
    created_ago: null,
    contact: null,
    balance: null,
    status: null,
    ref_id: null,
    bet: 0,
    win: 0,
    losses: 0,
    wagered: 0,
    profit: 0,
    max_profit: 0,
    token: null
  }),
  computed: {
    ...mapGetters({ authenticated: 'auth/check' }),
    formattedDate() {
      return moment(this.created_ago).fromNow();
    }
  },
  methods: {
    getCookie(cname) {
      let name = cname + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let ca = decodedCookie.split(';');
      for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    },
    EditProfile() {

      console.log('edit profile');

      window.location = 'profile/edit';

      // this.$router.push({ name: 'edit-profile' })
      // this.$router.push({ path: 'profile/edit' })
    }
  },
  async mounted() {

    console.log('get profile!!!');
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

          this.name = response.data.data.name
          this.avatar = response.data.data.avatar
          this.contry_code = response.data.data.contry_code
          this.created_ago = response.data.data.created_at
          this.contact = response.data.data.contact
          this.balance = response.data.data.balance
          this.bet = response.data.data.bet
          this.win = response.data.data.win
          this.losses = response.data.data.losses
          this.wagered = response.data.data.wagered
          this.profit = response.data.data.profit
          this.max_profit = response.data.data.max_profit
          this.ref_id = response.data.data.ref_id
          this.status = response.data.data.status

          console.log('name:' + this.name);

          this.authenticated = true

          // await this.$store.dispatch('auth/fetchUser')
          console.log('reload');

          this.$store.dispatch('auth/fetchUser')
          console.log('reload');
        } else {

          this.$store.dispatch('message/error', { text: this.$t('Please login!!!') })
          this.$router.push({ name: 'home' })
        }

      }).catch((e) => {

        console.log(e)
        this.$store.dispatch('message/error', { text: this.$t('Please login!!!') })
        this.$router.push({ name: 'home' })

      })

    }

  }
}
</script>
<style scoped>
.border-card {
  border-radius: 10px;
  border: 1px solid rgba(242, 228, 95, 0.41);
  background: linear-gradient(134deg,
      rgba(116, 96, 45, 0.39) 0%,
      rgba(0, 0, 0, 0) 97.89%);
  backdrop-filter: blur(50px);
}

.text-name {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-weight: 400 !important;
  font-size: 20px !important;
  line-height: 32px !important;
  letter-spacing: 0.25px;
}

.text-subtitle-style {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-weight: 400 !important;
  font-size: 14px !important;
  line-height: 22px !important;
  letter-spacing: 0.1px !important;
  color: rgba(255, 255, 255, 0.7) !important;
}

.text-value-style {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-weight: 400 !important;
  font-size: 14px !important;
  line-height: 22px !important;
  letter-spacing: 0.1px !important;
  color: rgba(255, 255, 255, 1) !important;
}

.card2 {
  position: relative;
  border: 5px solid transparent;
  background: linear-gradient(135deg, #292211 1%, #000000 100%);
  background-clip: padding-box;
  border-radius: 15px;
  padding: 25px;
  max-width: 569px;
}

.card2::after {
  content: "";
  position: absolute;
  top: -0.5px;
  bottom: -0.5px;
  left: -0.5px;
  right: -0.5px;
  background: linear-gradient(135deg, #7f7432 1%, #000000 100%);
  z-index: -1;
  border-radius: 10px;
}

.border-item {
  min-height: 95px;
  border-radius: var(--borderRadius, 4px);
  border: 1px solid rgba(255, 255, 255, 0.12);
  background: var(--bg-02-ci-book, #18181c);
}

.bonus-card {
  transition: all 0.5s;
  min-height: 220px;

  &.hover {
    border-color: var(--v-primary-base) !important;
  }
}
</style>
