<template>
  <v-container class="my-10">
    <v-row class="justify-center">
      <v-col v-for="item in list" :key="item.id" cols="12" md="6" lg="6" class="mb-5 mb-md-10"
        style="backdrop-filter: blur(50px)">
        <div class="card2">
          <div class="card2-content">
            <div class="d-flex flex-column d-gap">
              <h2 class="card2-title">{{ item.name }}</h2>
              <p class="card2-temp-text criptboard-style">
                {{
                  item.desc
                    ? item.desc
                    : 'Blackjack is a fun and enjoyable casino card game...'
                }}
              </p>
            </div>
            <div class="text-stert ">
              <v-btn @click="goto_games(item.url)" class="btn-border" outlined>
                <span class="text-gold-gradient-edit v-btn-learnmore text-uppercase">{{ $t('PLAY NOWss') }}</span>
              </v-btn>
            </div>
          </div>
          <div class="game-box-gradient">
            <img :src="item.image" />
          </div>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { config } from '~/plugins/config'
import { mapGetters } from 'vuex'
import axios from 'axios'
import DeviceMixin from '~/mixins/Device'

export default {
  mixins: [DeviceMixin],
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
    ClickItem(url) {
      console.log(url)
    },
    goto_games(url) {
      if (this.authenticated) {
        window.open(url);
      } else {
        this.$router.push({ name: 'login' })
      }
    },
  },
  async mounted() {
    let i;
    let result = await axios.get('/api/content/publish/game')
    // console.log(result.data.lists)
    this.list = result.data.data

    for (i in this.list) {
      // console.log('item:', this.list[i].name + ' ' + this.list[i].url);
      // localStorage.setItem(this.list[i].name) = this.list[i].url;

      if (this.list[i].name == "Blackjack") {
        localStorage.backject = this.list[i].url;
      } else if (this.list[i].name == "Rocket") {
        localStorage.rocket = this.list[i].url;
      }

    }
  },
}
</script>
<style lang="scss" scoped>
.criptboard-style {
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: normal;
  margin-bottom: 0px;
  width: 100%;
  max-height: 60px;
}

.card2 {
  display: flex;
  position: relative;
  border: 0px solid transparent;
  background: linear-gradient(135deg, #292211 1%, #000000 100%);
  background-clip: padding-box;
  border-radius: 10px;
  padding: 30px 39px !important;
  width: 100%;
  height: 143px;
}

.card2 .card2-content {
  display: flex !important;
  flex-direction: column !important;
  justify-content: space-between !important;
  height: 100%;

}

.card2::after {
  content: '';
  position: absolute;
  top: -1.5px;
  bottom: -0.5px;
  left: -0.6px;
  right: -0.5px;
  background: linear-gradient(135deg, #7f7432 1%, #000000 100%);
  z-index: -1;
  border-radius: 10px;
}


.text-gold-gradient-edit {
  background: linear-gradient(to bottom, #FAEC06, #F6B605) !important;
  background-clip: text !important;
  color: transparent !important;
}

.game-box-gradient {
  position: absolute;
  right: 16px;
  top: -18px;
  width: 172.25px;
  height: 167.36px;
  border-radius: 33px;
  background: black;
  // border: 3px solid var(--Linear, #faeb06);
}

.game-box-gradient img {
  width: 100%;
  height: 100%;
}

.bonus-card {
  transition: all 0.5s;
  min-height: 220px;

  &.hover {
    border-color: var(--v-primary-base) !important;
  }
}

.card2-content {
  place-self: center;
  width: 45%;
}

.card2-title {
  font-family: var(--heading-font);
  font-size: 16px;
  font-weight: 700;
  line-height: 20px;
  letter-spacing: 0em;
  text-align: left;
}

.card2-temp-text {
  font-family: 'Poppins', sans-serif !important;
  font-size: 16.2px;
  font-weight: 500;
  line-height: 19.28px;
  text-align: left;
  color: rgba(111, 111, 111, 1);
  padding-right: 80px;
  margin: 0px !important;
}

.text-btn {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-weight: 400;
  font-size: 14px;
  line-height: 20px;
  letter-spacing: 0.1px;
}

@media only screen and (min-width: 960px) {
  .card2 {
    padding: 34px 40px;
    height: 230px;
    // width: 588px;
  }

  .game-box-gradient {
    right: 0px;
    top: -30px;
    width: 289px;
    height: 279px;
  }

  .card2-title {
    font-size: 31px;
    line-height: 38px;
  }

  .card2-temp-text {
    font-size: 16px;
    line-height: 19px;
  }
}

.v-btn:before {
  background-color: transparent !important;
}

.btn-border {
  padding: 0.5rem;
  border: double 1px transparent;
  border-radius: 6px;
  background-image: linear-gradient(#211b0e, #211b0e),
    linear-gradient(to bottom, #FAEC06, #F6B605);
  background-origin: border-box;
  background-clip: padding-box, border-box;
}

.v-btn-learnmore {
  font-family: 'Gilroy-Bold', sans-serif !important;
  font-size: 14px !important;
  font-weight: 400 !important;
  line-height: 20px !important;
  letter-spacing: 0.3px !important;
}

.d-gap {
  gap: 17px;
}

@media screen and (max-width: 768px) {
  .text-btn {
    font-family: 'Gilroy-Medium', sans-serif !important;
    font-weight: 400 !important;
    font-size: 8.71px !important;
    line-height: 12.45px !important;
    letter-spacing: 0.1px;
  }

  .d-gap {
    gap: 10.58px;
  }

  .card2 {
    padding: 17px 24px !important;
    height: 131.07px;
  }

  .card2-title {
    font-size: 16px;
    line-height: 20px;
  }

  .card2-temp-text {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 500 !important;
    font-size: 10.08px !important;
    line-height: 12px !important;
    padding-right: 0px !important;
  }

  .btn-border {
    height: 25px !important;
    min-width: 69px !important;
  }

  .v-btn-learnmore {
    font-family: 'Gilroy-Bold', sans-serif !important;
    font-size: 8.71px !important;
    font-weight: 400 !important;
    line-height: 12.45px !important;
    letter-spacing: 0.3px !important;
  }
}
</style>
