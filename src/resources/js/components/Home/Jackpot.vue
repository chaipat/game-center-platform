<template>
  <div class="home-page-jackpot">
    <marquee direction="right">
      <div class="d-flex">
        <div v-for="item in list" :key="item.id" class="d-flex align-center justify-center justify-md-start"
          style="height: 73px; font-size: 14px; width: fit-content">
          <div class="mr-4 ml-10 line-gradient" style="box-shadow: 0px 0px 6px rgba(250, 255, 0, 0.5);"></div>
          <v-avatar size="30">
            <v-img class="mx-2" :src="display_images(item.avatar)" max-height="30" max-width="30" min-height="30"
              min-width="30" />
          </v-avatar>

          <!-- <v-img class="mr-2" :src="item.avatar" max-height="30" max-width="30" min-height="30" min-width="30" /> -->
          <p class="text-gold-gradient mr-6 ml-2 mb-0 d-flex name-style" style="min-width: fit-content">
            {{ chkName(item.name) }}
          </p>
          <p class="text-gold-gradient mr-6 mb-0 d-flex game-style">{{ item.game }}</p>
          <p class="mr-6 mb-0 d-flex">
            <span class="text-gold-gradient font-weight-bold mr-2">{{ item.currency }}</span>
            {{ chknumber(item.sum_win) | currencyFormat }}
          </p>
          <p class="mb-0 d-flex time-style">
            {{ item.create_at }}
          </p>
        </div>
      </div>
    </marquee>
  </div>
</template>

<script>
import Vue from 'vue'
import { config } from '~/plugins/config'
import { mapGetters } from 'vuex'
import axios from 'axios'
import moment from 'moment';

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
  data() {
    return {
      list: [],
      create_at: null

    }
  },
  computed: {
    ...mapGetters({
      paymentsPackageIsEnabled: 'package-manager/paymentsIsEnabled',
    }),
    signupBonus() {
      return config('settings.bonuses.sign_up')
    },
    depositBonus() {
      return config('settings.bonuses.deposit.first.pct')
    },
    faucetEnabled() {
      return config('settings.bonuses.faucet.amount') > 0
    },
    chatRainEnabled() {
      return !!config('settings.bonuses.rain.frequency')
    },
  },
  methods: {
    config,
    chkName(showname) {
      let Aname
      if (!showname) Aname = '(none)'
      else Aname = showname

      // console.log('name:',showname)
      // console.log('Aname:',Aname)

      return Aname
    },
    chknumber(val) {
      let ValNumber = null

      if (val >= 0) {
        ValNumber = '+' + val
      } else if (val == 0) {
        ValNumber = val
      } else {
        ValNumber = '<div class="red">-' + val + '</div>'
      }

      return ValNumber
    },
    display_images(url) {
      let show_images;

      // console.log('in:',url)
      if(url){
        show_images = url
      }else{
        show_images = '/images/icon-user.png';
      }
      // console.log('show_images:', show_images)

      return show_images;
    },
    timePassed(datetime) {
      let date = new Date(datetime * 1000)
      let now = new Date()
      let diff = now.getTime() - date.getTime()
      let second = Math.floor(diff / 1000)

      // console.log('datetime:', datetime);
      // console.log('date:', date);

      if (second < 60) {
        return second + ' second'
      } else if (second < 3600) {
        return Math.floor(second / 60) + ' min'
      } else if (second < 86400) {
        return Math.floor(second / 3600) + ' hour'
      } else if (second < 86400 * 30) {
        return Math.floor(second / 86400) + ' days'
      } else if (second < 86400 * 365) {
        return Math.floor(second / (86400 * 30)) + ' month'
      } else if (second < 86400 * 365 * 20) {
        return Math.floor(second / (86400 * 365)) + ' year'
      } else {
        return ' '
      }
    },
  },
  async mounted() {
    let result = await axios.get('/api/content/publish/winners')
    // console.log('winners >>>>>>>>>>', result.data)
    this.list = result.data.data;

    // this.list = result.data.data.map((item) => {
    //   return { ...item, create_at: moment(item.create_at).fromNow() }
    // })
  },
}
</script>

<style scoped>
.home-page-jackpot {
  border-top: 1px solid rgba(242, 228, 95, 0.41);
  border-bottom: 1px solid rgba(242, 228, 95, 0.11);
  background: linear-gradient(177deg,
      rgba(116, 96, 45, 0.52) -70%,
      rgba(0, 0, 0, 0) 83%);
  backdrop-filter: blur(50px);
  height: 73px;
}

.home-page-jackpot marquee {
  height: 73px;
}

.line-gradient {
  width: 3px;
  height: 56px;
  border-radius: 1.5px;
  background: linear-gradient(to bottom, rgba(255, 245, 113, 1), rgba(246, 179, 6, 1)) !important;
}

.name-style {
  font-family: "Gilroy-Light", sans-serif;
  font-weight: 400;
  font-size: 14px;
  line-height: 21px;
  letter-spacing: 0.1px;
  background: linear-gradient(to right, #FAEB06, #F6B705, #F5B105) !important;
  background-clip: text !important;
  color: transparent !important;
}

.game-style {
  font-family: "Gilroy-Medium", sans-serif;
  font-weight: 400;
  font-size: 14px;
  line-height: 21px;
  letter-spacing: 0.1px;
  background: linear-gradient(to right, #FAEB06, #F6B705, #F5B105) !important;
  background-clip: text !important;
  color: transparent !important;
}

.currency-style {
  font-family: "Gilroy-Medium", sans-serif;
  font-size: 14px;
  font-weight: 400;
  line-height: 17.15px;
  letter-spacing: 1.25px;
  background: linear-gradient(to right, #FAEB06, #F6B705, #F5B105) !important;
  background-clip: text !important;
  color: transparent !important;
}

.time-style {
  color: rgba(255, 255, 255, 0.5);
  min-width: 100px;
  font-family: "Gilroy-Medium", sans-serif;
  font-size: 14px;
  font-weight: 400;
  line-height: 21px;
  letter-spacing: 0.1px;
}
</style>
