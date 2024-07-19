<template>
  <v-container class="home-page-bonus-cards mt-10">
    <v-row class="mb-8" justify="center">
      <v-col cols="12" sm="12" md="9" lg="9" :class="isMobile ? 'px-0' : ''">
        <v-img src="/images/bg-game.webp" class="slide-image landing-bg align-center fill-height"
          :class="isMobile ? 'pl-6 pr-6 pb-16 ' : 'pl-12'" cover>
          <template>
            <v-card-title class="fill-height pa-0">
              <v-row class="fill-height">
                <v-col cols="12">
                  <h2 class="banner-title">
                    <span style="color: #f6b605" class="d-block">
                      Win Unlimited Money
                    </span>
                    <span class="d-block text-white">By Playing Online</span>
                    <span style="color: #f6b605" class="d-block">
                      Casino Games
                    </span>
                  </h2>
                  <h5 :class="isMobile ? 'pl-10 pr-10' : ''" class="banner-subtitle">
                    Play casino and earn crypto in online.
                  </h5>
                  <div class="banner-action">
                    <v-btn class="gold-gradient text-btn-tyle">
                      PLAY NOW
                    </v-btn>
                  </div>
                </v-col>
              </v-row>
            </v-card-title>
          </template>
        </v-img>
      </v-col>
      <v-col md="3" lg="3" class="d-none d-md-flex">
        <div justify="center" style="width: 320px !important;">
          <div class="bg-top10-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path
                d="M5.25 5.25V10.4156C5.25 14.1375 8.23125 17.2219 11.9531 17.25C12.8435 17.2562 13.7263 17.0862 14.5506 16.7497C15.375 16.4133 16.1247 15.917 16.7564 15.2896C17.3882 14.6622 17.8896 13.916 18.2317 13.094C18.5739 12.272 18.75 11.3904 18.75 10.5V5.25C18.75 5.05109 18.671 4.86032 18.5303 4.71967C18.3897 4.57902 18.1989 4.5 18 4.5H6C5.80109 4.5 5.61032 4.57902 5.46967 4.71967C5.32902 4.86032 5.25 5.05109 5.25 5.25Z"
                stroke="url(#paint0_linear_247_38137)" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round" />
              <path d="M9 21H15" stroke="url(#paint1_linear_247_38137)" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round" />
              <path d="M12 17.25V21" stroke="url(#paint2_linear_247_38137)" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round" />
              <path
                d="M18.5811 12H19.4998C20.2955 12 21.0585 11.6839 21.6211 11.1213C22.1837 10.5587 22.4998 9.79565 22.4998 9V7.5C22.4998 7.30109 22.4208 7.11032 22.2801 6.96967C22.1395 6.82902 21.9487 6.75 21.7498 6.75H18.7498"
                stroke="url(#paint3_linear_247_38137)" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round" />
              <path
                d="M5.4376 12H4.49072C3.69507 12 2.93201 11.6839 2.3694 11.1213C1.80679 10.5587 1.49072 9.79565 1.49072 9V7.5C1.49072 7.30109 1.56974 7.11032 1.71039 6.96967C1.85104 6.82902 2.04181 6.75 2.24072 6.75H5.24072"
                stroke="url(#paint4_linear_247_38137)" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round" />
              <defs>
                <linearGradient id="paint0_linear_247_38137" x1="12" y1="4.5" x2="12" y2="17.2502"
                  gradientUnits="userSpaceOnUse">
                  <stop stop-color="#F6B605" />
                  <stop offset="1" stop-color="#FAEC06" />
                </linearGradient>
                <linearGradient id="paint1_linear_247_38137" x1="12" y1="21" x2="12" y2="22"
                  gradientUnits="userSpaceOnUse">
                  <stop stop-color="#F6B605" />
                  <stop offset="1" stop-color="#FAEC06" />
                </linearGradient>
                <linearGradient id="paint2_linear_247_38137" x1="12.5" y1="17.25" x2="12.5" y2="21"
                  gradientUnits="userSpaceOnUse">
                  <stop stop-color="#F6B605" />
                  <stop offset="1" stop-color="#FAEC06" />
                </linearGradient>
                <linearGradient id="paint3_linear_247_38137" x1="20.5404" y1="6.75" x2="20.5404" y2="12"
                  gradientUnits="userSpaceOnUse">
                  <stop stop-color="#F6B605" />
                  <stop offset="1" stop-color="#FAEC06" />
                </linearGradient>
                <linearGradient id="paint4_linear_247_38137" x1="3.46416" y1="6.75" x2="3.46416" y2="12"
                  gradientUnits="userSpaceOnUse">
                  <stop stop-color="#F6B605" />
                  <stop offset="1" stop-color="#FAEC06" />
                </linearGradient>
              </defs>
            </svg>
            <div class="d-flex text-body font-weight-bold">
              TOP 10
              <span class="text-secondary-linear ml-1">WINNERS</span>
            </div>
          </div>
          <div class="bg-top10">
            <v-card v-for="(item, index) in list" :key="item.id" class="card-top10"
              style="background-color: rgba(1, 1, 1, 0.5) !important">
              <div class="d-flex">
                <v-avatar size="30" class="mr-1">
                  <v-img class="mx-2" :src="display_images(item.avatar)" max-height="30" max-width="30" min-height="30"
                    min-width="30" />
                </v-avatar>
                <!-- <v-img
                  class="mx-2"
                  :src="item.avatar"
                  max-height="30"
                  max-width="30"
                  min-height="30"
                  min-width="30"
                /> -->
                <div style="color: white !important; font-size: 10px">
                  <div class="mb-1 text-opacity">
                    <svg class="mr-1 ml-1" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                      fill="none">
                      <path
                        d="M5.26471 7.7785C5.03891 8.04249 4.75034 8.24544 4.42556 8.36868C4.10078 8.49192 3.75021 8.53149 3.40613 8.48375C3.06205 8.43601 2.7355 8.30249 2.45654 8.09548C2.17758 7.88847 1.95517 7.61462 1.80977 7.29913C1.66438 6.98364 1.60067 6.63665 1.62451 6.29009C1.64836 5.94354 1.75899 5.60854 1.94622 5.31594C2.13345 5.02334 2.39127 4.78253 2.69596 4.61567C3.00064 4.44882 3.3424 4.36128 3.68977 4.36111C3.85244 4.36196 4.01451 4.38077 4.17304 4.41721V4.41721C3.96835 4.09001 3.86063 3.71148 3.86237 3.32554C3.86237 2.77624 4.08058 2.24943 4.46899 1.86102C4.85741 1.4726 5.38421 1.25439 5.93351 1.25439C6.48282 1.25439 7.00962 1.4726 7.39804 1.86102C7.78645 2.24943 8.00466 2.77624 8.00466 3.32554C8.0064 3.71148 7.89868 4.09001 7.69399 4.41721V4.41721C7.85252 4.38077 8.01459 4.36196 8.17726 4.36111C8.52463 4.36128 8.86639 4.44882 9.17107 4.61567C9.47576 4.78253 9.73358 5.02334 9.92081 5.31594C10.108 5.60854 10.2187 5.94354 10.2425 6.29009C10.2664 6.63665 10.2027 6.98364 10.0573 7.29913C9.91186 7.61462 9.68945 7.88847 9.41049 8.09548C9.13153 8.30249 8.80498 8.43601 8.4609 8.48375C8.11682 8.53149 7.76625 8.49192 7.44147 8.36868C7.11669 8.24544 6.82812 8.04249 6.60232 7.7785L7.31428 10.0568H4.55275L5.26471 7.7785Z"
                        stroke="#fff" stroke-width="0.736407" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="mb-0">{{ item.game }}</span>
                  </div>
                  <p class="mb-0 text-name" style="margin-left: 7px !important;">{{ item.name }}</p>
                </div>
              </div>
              <div style="font-size: 10px;"">
                <p class=" mb-1 text-opacity">
                {{ item.create_at }}
                </p>
                <p class="mb-0 text-end" :style="index > 2 ? 'color: #F8F8F8' : 'color:#FAEC06'">
                  {{ chknumber(item.sum_win) }}
                </p>
              </div>
              <No1 v-if="index == 0" :no="1" class="card-top10--number" />
              <No2 v-if="index == 1" :no="2" class="card-top10--number" />
              <No3 v-if="index == 2" :no="3" class="card-top10--number" />
              <No v-if="index > 2" :no="index + 1" class="card-top10--number-nc" />
            </v-card>
          </div>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Vue from 'vue'
import { config } from '~/plugins/config'
import No from '~/components/Home/Number/No'
import No1 from '~/components/Home/Number/No1'
import No2 from '~/components/Home/Number/No2'
import No3 from '~/components/Home/Number/No3'
import axios from 'axios'
import DeviceMixin from '~/mixins/Device'

Vue.filter('currencyFormat', function (value) {
  return parseFloat(value).toFixed(0).replace(/\d(?=(\d{3})+\.)/g, '$&,');
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
    }
  },
  mixins: [DeviceMixin],
  components: { No1, No2, No3, No },
  computed: {
    links() {
      return config('settings.content.social')
    },
    appFullLogoUrl() {
      return config('app.full_logo')
    },
  },
  methods: {
    chkName(showname) {
      let Aname
      if (!showname) Aname = '(none)'
      else Aname = showname

      // console.log('name:',showname)
      // console.log('Aname:',Aname)
      return Aname
    },
    chknumber(val) {
      const num = parseFloat(val).toLocaleString('en-US');
      let ValNumber = null

      if (parseFloat(num) >= 0) {
        ValNumber = '+' + num
      } else {
        ValNumber = '<div class="red">-' + num + '</div>'
      }

      if (parseFloat(num) === 0) {
        ValNumber = num
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
    // console.log(result.data)
    this.list = result.data.data.filter((val, i) => i < 10)
    // console.log('list:',this.list)

    // console.log('user_id:',this.list[0].user_id)
    // console.log('name:',this.list[0].name)
    // console.log('sum_win:',this.list[0].sum_win)
    // console.log('currency:',this.list[0].currency)
    // console.log('avatar:',this.list[0].avatar)
  },
}
</script>

<style scoped>
.text-opacity {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-weight: 400 !important;
  font-size: 10px !important;
  line-height: 12.13px !important;
  color: rgb(255, 255, 255, 100%);
  display: flex;
  justify-content: start;
  align-items: center;
}

.text-name {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-weight: 400 !important;
  font-size: 10px !important;
  line-height: 12.13px !important;
  color: rgb(255, 255, 255);
}

.bg-top10-title {
  padding: 16px 26px;
  display: flex;
  gap: 10px;
  align-items: center;
  border-top-left-radius: 8px;
  border-top-right-radius: 8px;
  background: linear-gradient(172deg, rgba(255, 194, 75, 0.26) 2.93%, rgba(0, 0, 0, 0.01) 60.93%);
  font-family: var(--heading-font);
  font-size: 14px;
  font-weight: 600;
  line-height: 18px;
  letter-spacing: 1.25px;
}

.bg-top10 {
  display: flex;
  flex-direction: column;
  gap: 10px;
  align-items: center;
  padding: 20px 28px;
  border-bottom-left-radius: 8px;
  border-bottom-right-radius: 8px;
  background: linear-gradient(354.66deg,
      rgba(255, 194, 75, 0.26) 8.55%,
      rgba(0, 0, 0, 0.01) 87.49%);
}

.circle {
  border-radius: 50%;
  width: 34px;
  height: 34px;
  padding: 10px;
  background: #fff;
  border: 3px solid #000;
  color: #000;
  text-align: center;
  font: 32px Arial, sans-serif;
}

.text-secondary-linear {
  background: linear-gradient(to bottom, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
  text-align: center;
}

.banner-title {
  font-family: var(--heading-font);
  font-weight: 700;
  letter-spacing: 0.5px;
  font-size: 26px;
  line-height: 43px;
  text-align: center;
}

.banner-subtitle {
  font-family: var(--body-font);
  font-size: 23px;
  font-weight: 400;
  line-height: 32px;
  text-align: center;
  word-break: auto-phrase;
  margin-bottom: 150px;
  margin-top: 10px;
}

.banner-action {
  display: flex;
  justify-content: center;
}

.text-btn-tyle {
  font-family: 'Gilroy-Bold', sans-serif !important;
  font-size: 18px !important;
  font-weight: 600 !important;
  line-height: 22px !important;
  letter-spacing: 0.1px !important;
  border-radius: 7px;
  height: 58px !important;
  min-width: 143px !important;
  padding: 0 19.5555555556px !important;
}

.card-top10 {
  display: flex;
  width: 100%;
  justify-content: space-between;
  padding: 10px 24px 10px 10px;
  position: relative;
}

.card-top10--number {
  position: absolute;
  top: calc(50% - 16px);
  right: -13px;
}

.card-top10--number-nc {
  position: absolute;
  top: calc(50% - 11px);
  right: -11px;
}

@media only screen and (min-width: 960px) {
  .banner-title {
    font-size: 56px;
    line-height: 80px;
    text-align: left;
  }

  .banner-subtitle {
    text-align: left;
    margin-bottom: 80px;
    margin-top: 0px;
  }

  .banner-action {
    justify-content: start;
  }
}

/* 
.v-image__image {
  background-image: url('/images/home/provably-fair.webp') !important;
  background-size: cover;
  background-position: center center !important;
} */

@media screen and (max-width: 768px) {

  ::v-deep .v-image__image {
    background-position: 77% !important;
  }

  ::v-deep .v-image__image::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)) !important;
    border-radius: 8px;
  }
}
</style>
