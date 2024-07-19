<template>
  <v-container class="home-page-bonus-cards">
    <v-row align="center" class="justify-space-between">
      <v-col cols="auto">
        <v-row dense>
          <v-col cols="auto">
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
          </v-col>
          <v-col cols="auto">
            <span class="text-h6 font-weight-bold"><span class="text-gold-gradient-edit text-uppercase">What’s
                news</span></span>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="auto">

        <span class="text-body-1 font-weight-thin ">
          <router-link to="/blog" class="see-more-style"><span>SEE MORE</span></router-link>
        </span>

      </v-col>

    </v-row>
    <v-row class="justify-center flex-row-reverse">
      <v-col v-for="(item, index) in list" :key="item.id" v-if="index < 4" class="colList" cols="12" md="6" lg="3">
        <v-card class="mx-auto" max-width="344" style="background: #1c180a !important;">
          <a :href="'/blog/' + item.id">
            <v-img :src="display_images(item.cover_image)" height="200px"
              style="border-top-left-radius: 13px; border-top-right-radius: 13px;"></v-img>
          </a>

          <v-card-title class="text-gold-gradient-edit-right">
            <p>{{ item.title }}</p>
          </v-card-title>

          <v-card-subtitle>
            <p>{{ item.description }}</p>
          </v-card-subtitle>
          <v-divider class="mx-4"></v-divider>
          <v-card-actions style="padding-bottom: 0px !important;">
            <v-list-item class="grow">
              <v-list-item-avatar color="grey darken-3">
                <v-img class="elevation-6" alt="Admin" src="/images/icon-user.png"></v-img>
              </v-list-item-avatar>

              <v-list-item-content>
                <v-list-item-title class="text-gold-gradient-edit-right text-admin">
                  <p>Admin</p>
                </v-list-item-title>
              </v-list-item-content>

              <v-row align="center" justify="end" class="text-alter">
                <div>
                  <v-icon class="mr-1 icon-alter"> mdi-calendar-blank-outline</v-icon>
                  <span class="subheading mr-2 text-alter">{{ ShowDate(item.created_at) }}</span>
                </div>

              </v-row>
            </v-list-item>
          </v-card-actions>

          <!-- <v-expand-transition>
            <div>
              <v-divider></v-divider>
            </div>
          </v-expand-transition> -->
        </v-card>
      </v-col>

    </v-row>
  </v-container>
</template>

<script>
import axios from "axios";
import { config } from "~/plugins/config";
import { mapGetters } from "vuex";
import moment from 'moment'

export default {
  data() {
    return {
      list: [],
    }
  },
  computed: {
    ...mapGetters({ paymentsPackageIsEnabled: "package-manager/paymentsIsEnabled" }),
    signupBonus() {
      return config("settings.bonuses.sign_up");
    },
    depositBonus() {
      return config("settings.bonuses.deposit.first.pct");
    },
    faucetEnabled() {
      return config("settings.bonuses.faucet.amount") > 0;
    },
    chatRainEnabled() {
      return !!config("settings.bonuses.rain.frequency");
    },
  },
  // async created () {
  //   console.log('Get API Blog')

  //   let result = axios.get('/api/content/publish/blog');
  //   console.log('getblog:' + result.data.data)
  //   this.list = result.data.data

  // },
  methods: {
    config,
    ClickItem(url) {
      console.log(url)
    },
    ShowDate(showdate) {
      return moment(showdate).format("DD MMM. YYYY");
    },
    display_images(url) {
      let show_images;

      // console.log('in:',url)
      if(url){
        show_images = 'https://bucket-dev.baanbaan.site/' + url
      }else{
        show_images = '/images/image-news1.png';
      }
      // console.log('show_images:', show_images)

      return show_images;
    },
  },
  async mounted(route, params) {

    console.log('Mounted Get API Blog')

    let result2 = await axios.get('/api/content/publish/blog');
    // console.log('getblog:' + result2.data.data)
    this.list = result2.data.data

    // let result3 = await axios.get('/api/content/publish/category');
    // console.log('cat:' + result3.data.data)
    // this.cat = result3.data.data
  }
};
</script>
<style scoped>
.see-more-style {
  font-family: "Orbitron", sans-serif;
  color: #F6B605;
  font-size: 14px;
  line-height: 17.56px;
  font-weight: 600;
  letter-spacing: 1.25px;
}

.text-gold-gradient-edit {
  background: linear-gradient(to bottom, #FAEC06, #F6B605) !important;
  background-clip: text !important;
  color: transparent !important;
}

.text-gold-gradient-edit-right p {
  background: linear-gradient(to right, #FAEB06, #F6B705, #F5B105) !important;
  background-clip: text !important;
  color: transparent !important;
  font-family: "Gilroy-SemiBold", sans-serif !important;
  font-size: 14px !important;
  line-height: 16.1px !important;
  font-weight: 400 !important;
}

.text-alter {
  font-size: 11.74px !important;
  line-height: 13.97px !important;
  font-weight: 400 !important;
  font-family: "Gilroy-Medium", sans-serif !important;
  color: #737373;
}

.icon-alter {
  font-size: 17.74px !important;
  line-height: 12.97px !important;
  font-weight: 400 !important;
  color: #737373;
}

.text-admin p{
  background: linear-gradient(to right, #FAEB06, #F6B705, #F5B105) !important;
  background-clip: text !important;
  color: transparent !important;
  font-size: 14px !important;
  line-height: 21px !important;
  font-weight: 400 !important;
  font-family: "Gilroy-Light", sans-serif !important;
  margin-bottom: 0px !important;
}

@media screen and (max-width: 768px) {
  .flex-row-reverse {
    overflow-x: auto;
    height: 25rem;
    display: flex;
    flex-direction: column !important;
    padding-left: 10px !important;
  }

  .colList {
    width: 20rem;
  }
}
</style>