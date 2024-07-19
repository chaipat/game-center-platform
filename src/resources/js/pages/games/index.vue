<template>
  <v-container class="pa-0" fluid>
    <ProvablyFair />
    <v-container style="max-width: 1020px;">
      <v-row align="center" class="justify-space-between">
        <v-col cols="12" sm="6">
          <v-col cols="auto">
            <v-row>
              <v-col cols="auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-1" width="24" height="24" viewBox="0 0 24 24"
                  fill="none">
                  <path
                    d="M5.25 5.25V10.4156C5.25 14.1375 8.23125 17.2219 11.9531 17.25C12.8435 17.2562 13.7263 17.0862 14.5506 16.7497C15.375 16.4133 16.1247 15.917 16.7564 15.2896C17.3882 14.6622 17.8896 13.916 18.2317 13.094C18.5739 12.272 18.75 11.3904 18.75 10.5V5.25C18.75 5.05109 18.671 4.86032 18.5303 4.71967C18.3897 4.57902 18.1989 4.5 18 4.5H6C5.80109 4.5 5.61032 4.57902 5.46967 4.71967C5.32902 4.86032 5.25 5.05109 5.25 5.25Z"
                    stroke="url(#paint0_linear_247_38137)" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M9 21H15" stroke="url(#paint1_linear_247_38137)" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M12 17.25V21" stroke="url(#paint2_linear_247_38137)" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round" />
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
              </v-col>
              <v-col cols="auto" class="pl-0">
                <span class="text-h6 font-weight-bold"><span class="text-gold-gradient">GAME</span></span>
              </v-col>
            </v-row>
          </v-col>
        </v-col>
        <v-col cols="12" sm="6" class="d-lg-none d-md-none">
          <v-row align="center" justify="end">
            <v-col cols="12" sm="auto">
              <v-text-field v-model.trim="searchText" dense filled rounded color="white" clearable hide-details
                placeholder="Search" append-icon="" class="rounded-lg shrink expanding-search expanding-search-text"
                style="background: #2c2c33;" :class="{ closed: searchBoxClosed && !searchText }"
                @focus="searchBoxClosed = false" @blur="searchBoxClosed = true">
                <template v-slot:append>
                  <svg class="font-weight-bold" xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                    viewBox="0 0 1024 1024">
                    <path fill="#b0b0b0"
                      d="m795.904 750.72l124.992 124.928a32 32 0 0 1-45.248 45.248L750.656 795.904a416 416 0 1 1 45.248-45.248zM480 832a352 352 0 1 0 0-704a352 352 0 0 0 0 704" />
                  </svg>
                </template>
              </v-text-field>
            </v-col>
          </v-row>
        </v-col>

      </v-row>
      <v-row>
        <v-col cols="12" sm="11">
          <v-row class="mb-5">
            <v-col v-for="item in list" :key="item.id" cols="12" sm="4">
              <a href="javascript:void(0);" @click="goto_games(item.url)">
                <v-img :src="item.image" :alt="item.name" :title="item.name" class="image-style"></v-img>
              </a>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      <v-row class="">
        <v-col>
          <v-pagination v-model="page" :length="total_page" rounded="circle"></v-pagination>
        </v-col>
      </v-row>
    </v-container>


  </v-container>
</template>

<script>
import { config } from '~/plugins/config'
import { hex2ascii } from '~/plugins/utils'
import AnimatedBackground from '~/components/AnimatedBackground'
import ProvablyFair from '~/components/Games/ProvablyFair'
import GameFeed from '~/components/GameFeed'
import axios from "axios";
import moment from 'moment'
import { mapGetters } from 'vuex'

export default {
  middleware: ['guest', 'email_auth'],
  metaInfo() {
    return { title: this.$t('Games online') }
  },
  data() {
    return {
      list:[],
      meta: [
        { hid: "games online", name: "games online", content: this.description }
      ]
    }
  }, 
  components: { 
    ...mapGetters({
      authenticated: 'auth/check',
      paymentsPackageIsEnabled: 'package-manager/paymentsIsEnabled',
    }),
    GameFeed, AnimatedBackground, ProvablyFair 
  },
  created() {
    console.log('authenticated:' + this.authenticated);
    if (this.authenticated) {

      console.log('auth fetchUser !!!');
      this.$store.dispatch('auth/fetchUser')
    } else {

      console.log('auth failed !!!');
      // this.Check_auth();
    }
  },
  methods: {
      goto_games(url){
        if (this.authenticated) {
          window.open(url);
        }else{
          this.$router.push({ name: 'login' })
        }
      },
      ShowDate(showdate){
        return moment(showdate).format("DD MMM YY");
      },
  },
  async mounted(route, params){
    let result = await axios.get('/api/content/publish/game');
    this.list = result.data.data;
    console.log('list', this.list)
  }
}

</script>
<style scoped>
.expanding-search-text {
  font-family: 'Poppins', sans-serif !important;
  font-weight: 400 !important;
  font-size: 12.6px !important;
  line-height: 18.9px !important;
}

.image-style {
  width: 291px !important;
  height: 282px !important;
  border-radius: 33px !important;
}

@media screen and (max-width: 768px) {
  .image-style {
    width: 211px !important;
    height: 205px !important;
    border-radius: 24px !important;
    margin-left: 29.41px !important;
  }
}
</style>