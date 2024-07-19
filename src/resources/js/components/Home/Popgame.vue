<template>
  <v-container class="home-page-bonus-cards mt-10 fill-height">
    <v-row align="center" class="justify-space-between">
      <v-col cols="auto">
        <v-row dense>
          <v-col cols="auto" class="d-flex align-items-center">
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
            <p class="text-h6 mb-0 font-weight-bold text-gold-gradient-edit">
              POPULAR GAMES
            </p>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="auto">
        <span class="text-body-1 font-weight-thin ">
          <!-- <router-link to="/games" class="see-more-style"><span>SEE MORE</span></router-link> -->
          <a href="/games" class="see-more-style"><span>SEE MORE</span></a>
        </span>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-carousel :show-arrows="false" style="height: 300px; overflow: visible;" class="carousel-style">
          <v-carousel-item>
            <v-row style="flex-wrap: nowrap !important;">
              <v-col v-for="item in list" :key="item.id" cols="3" md="3" lg="3" class="game-box-style">
                <div class="game-box-gradient">
                  <a href="javascript:void(0);" @click="goto_games(item.url)"><img :src="item.image" /></a>
                </div>
              </v-col>
            </v-row>
          </v-carousel-item>
        </v-carousel>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import { config } from '~/plugins/config'
import axios from 'axios'

export default {
  data() {
    return {
      list: [],
    }
  },
  computed: {
    ...mapGetters({
      authenticated: 'auth/check',
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
  created() {

    console.log('mainmenu authenticated:' + this.authenticated);
    if (this.authenticated) {

      console.log('auth fetchUser !!!');
      // this.$store.dispatch('auth/fetchUser')
    } else {

      console.log('auth failed !!!');
    }

  },
  methods: {
    config,
    goto_games(url){
      if (this.authenticated) {
        window.open(url);
      }else{
        this.$router.push({ name: 'login' })
      }
    },
  },
  async mounted() {
    let result = await axios.get('/api/content/publish/game')
    // console.log(result.data.lists)
    this.list = result.data.data.reverse()
    console.log(this.list);
  },
}
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

.game-box-gradient {
  width: 291px;
  height: 282px;
  border-radius: 33px;
  background: black;
  /* border: 3px solid var(--Linear, #faeb06); */
}


.text-gold-gradient-edit {
  background: linear-gradient(to bottom, #FAEC06, #F6B605) !important;
  background-clip: text !important;
  color: transparent !important;
}

.game-box-style {
  max-width: 282px;
  margin-right: 23px;
}

.game-box-gradient img {
  width: 100%;
  height: 100%;
}

::v-deep .v-carousel__controls {
  position: absolute;
  transform: translateY(65%);
}

::v-deep .v-carousel__controls .v-btn--icon.v-size--small {
  height: 0px !important;
  width: 8px !important;
  scale: 0.7;
}

::v-deep .v-carousel__controls button span i {
  color: gray;
}

::v-deep .v-carousel__controls .v-item--active span i {
  background: linear-gradient(to right, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
  opacity: 1 !important;
}

@media screen and (max-width: 768px) {
  ::v-deep .v-carousel__controls {
    position: absolute;
    transform: translateY(65%) !important;
  }

  .game-box-gradient {
    width: 181.46px;
    height: 175.85px;
    border-radius: 33px;
    background: black;
  }

  .game-box-style {
    max-width: 200px;
    margin-right: 6px !important;
  }

  .carousel-style {
    height: 222px !important;
  }
}
</style>
