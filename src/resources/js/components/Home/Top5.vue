<template>
  <v-container class="home-page-bonus-cards mt-10 d-flex d-md-none" style="max-width: 1370px">
    <v-row class="mb-8" justify="center">
      <v-col cols="12">
        <div justify="center">
          <div class="bg-top10-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 32 32">
              <defs>
                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" style="stop-color:rgb(250, 236, 6);stop-opacity:1" />
                  <stop offset="100%" style="stop-color:rgb(246, 182, 5);stop-opacity:1" />
                </linearGradient>
              </defs>
              <rect width="32" height="32" fill="none" />
              <path fill="url(#gradient)"
                d="M26 7h-2V6a2.002 2.002 0 0 0-2-2H10a2.002 2.002 0 0 0-2 2v1H6a2.002 2.002 0 0 0-2 2v3a4.005 4.005 0 0 0 4 4h.322A8.169 8.169 0 0 0 15 21.934V26h-5v2h12v-2h-5v-4.069A7.966 7.966 0 0 0 23.74 16H24a4.005 4.005 0 0 0 4-4V9a2.002 2.002 0 0 0-2-2M8 14a2.002 2.002 0 0 1-2-2V9h2Zm14 0a6 6 0 0 1-6.185 5.997A6.2 6.2 0 0 1 10 13.707V6h12Zm4-2a2.002 2.002 0 0 1-2 2V9h2Z" />
            </svg>
            <div class="d-flex text-body font-weight-bold">
              TOP 
              <span class="text-gold-gradient ml-1"> 5 WINNERS</span>
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
import { config } from '~/plugins/config'
import No from '~/components/Home/Number/No'
import No1 from '~/components/Home/Number/No1'
import No2 from '~/components/Home/Number/No2'
import No3 from '~/components/Home/Number/No3'
import axios from 'axios'
import DeviceMixin from '~/mixins/Device'
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
      const formattedNumber = num
      // console.log('++++++++++++++++++++', num);
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

      // console.log('img:',url)
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
    this.list = result.data.data.filter((val, i) => i < 5)

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
  font-size: 16px;
  font-weight: 600;
  line-height: 20px;
  letter-spacing: 1.25px;
  display: flex;
  justify-content: center;
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


</style>
