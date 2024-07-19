<template>
  <v-menu v-model="menu" offset-y left>
    <template #activator="{ on }">
      <v-card v-on="on" style="background-color: #24242c !important; border-radius: 8px" link>
        <v-card-text class="d-flex" :class="isMobile ? 'py-0 px-0' : 'py-1 px-1'">
          <div class="app-text-primary align-self-center ml-2 text-thb">
            THB
          </div>
          <div class="ml-2 mr-3 align-self-center text-balance" style="font-size: 12px; color: #FFF !important;">
            {{ balance | currencyFormat }}
          </div>
          <div class="align-self-center">
            <v-btn class="app-button-primary" style="min-width: 30px" :width="isMobile ? 35 : 77"
              :height="isMobile ? 30 : 36">
              <v-icon v-if="isMobile">mdi-wallet-outline</v-icon>
              <span v-else class="text-depo">Deposit</span>
            </v-btn>
          </div>
        </v-card-text>
      </v-card>
    </template>
    <v-list>
      <v-list-item href="/transection">
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-format-list-bulleted</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Transaction</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item href="/topup">
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-format-list-bulleted</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Topup</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <!-- <v-list-item :to="{ name: 'withdraw' }" link exact class="d-none">
        <v-list-item-icon class="mr-2">
          <v-icon>mdi-format-list-bulleted</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>withdraw</v-list-item-title>
        </v-list-item-content>
      </v-list-item> -->
      <!-- <v-list-item @click="GotoMenu('topup')" link exact>
        <v-list-item-icon>
          <v-icon>mdi-chip</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>{{ $t('Topup') }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item> -->
    </v-list>
  </v-menu>
</template>

<script>
import Vue from 'vue'
import AnimatedNumber from '~/components/AnimatedNumber'
import moment from 'moment';
import DeviceMixin from '~/mixins/Device'
import { mapGetters, mapState } from 'vuex'
import { config } from '~/plugins/config'

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
  components: {
    AnimatedNumber,
  },
  mixins: [DeviceMixin],
  data() {
    return {
      menu: false,
      balance: 0,
    }
  },
  created() {
    this.balance = parseFloat(this.$store.state.auth.user.data.balance);
  },
  computed: {
    ...mapState('auth', ['account']),
    ...mapGetters({
      paymentsPackageIsEnabled: 'package-manager/paymentsIsEnabled',
    }),
    creditsIcon() {
      return config('settings.interface.credits_icon')
    },
    faucetEnabled() {
      return config('settings.bonuses.faucet.amount') > 0
    },
    isProviderGamePage() {
      return this.$route.name === 'provider.game'
    },
  },

  methods: {
    GotoMenu(menulink) {
      console.log('goto:' + menulink)
      window.location = menulink
      // this.$route.push({ name: menulink })
      // this.$router.push({ name: 'password.change', params: { token: this.token } })
    },
    display_balnace(val){
      return val.toFixed(2) 
    }
  },
}
</script>
<style scoped>
.text-thb {
  font-family: "Gilroy-SemiBold", sans-serif;
  font-size: 14px;
  line-height: 17.15px;
  letter-spacing: 1.25px;
}

.text-balance {
  font-family: "Gilroy-SemiBold", sans-serif;
  font-size: 12px;
  line-height: 17.15px;
  letter-spacing: 0.25px;
}

.text-depo {
  font-family: "Gilroy-SemiBold", sans-serif;
  font-size: 14px;
  line-height: 17.15px;
  letter-spacing: 0px;
}
</style>
