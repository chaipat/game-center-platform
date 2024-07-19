<template>
  <v-container class="home-page-bonus-cards mt-10">
    <v-row>
      <v-col cols="12" md="6" lg="6" style="backdrop-filter: blur(50px); position: relative"">
        <v-col class=" card2 px-4">
        <v-row align="center" style="min-height: 250px;">
          <v-col cols="12" md="12" lg="7" class="d-mobile-flex">
            <h2 class="font-title refer-friends-style">Refer Friends</h2>
            <div>
              <p class="refer-details-lg">
                Let the whole world know about - people here and earn more! Receive passive income for each player who
                follows your link,
              </p>
              <p class="refer-details-sm">
                Let the whole world know about
              </p> <span class="refer-details-sm"> - people here and earn more! Receive passive income for each
                player who
                follows your link,</span>
              <p class="referral-style">Referral link</p>
              <!-- <v-text-field style="background: #242424; border-radius: 8px !important; margin-bottom: 0px !important;"
                  ref="textField" :value="url" hide-details disabled append-icon="mdi-link" type="" name="" outlined>
                  <template v-slot:append>
                    <v-icon style="color: #FAEC06 !important;" @click="copyText">mdi-link</v-icon>
                  </template>
</v-text-field> -->

              <v-row>
                <v-col style="position: relative !important;">
                  <input type="text" :value="url" class="criptboard-style" ref="textField" disabled>
                  <v-icon class="absolue-icon" @click="copyText">mdi-link</v-icon>
                </v-col>
              </v-row>

              <p href="#"
                style="font-size: 10px; text-align: end; margin-top: 10px !important; text-decoration: underline; cursor: pointer;">
                See more
              </p>
            </div>
          </v-col>
          <v-col cols="12" md="0" lg="5" class="hidden-attr"></v-col>
          <v-img class="image-abs-refer" src="images/17649fbe0d34c2af5cbf96e7ecb0162f.png"></v-img>
        </v-row>
      </v-col>
      </v-col>
      <v-col cols="12" sm="6" md="3" lg="3" style="backdrop-filter: blur(50px);">
        <v-col class="card2 sign-up-card text-center" align="center">
          <v-row>
            <v-col style="width: 280px;height: 250px;">
              <v-row justify="center">
                <v-col cols="10" style="top: -15px; position: relative; height: 11rem; padding-top: 0px;">
                  <v-img src="images/30bc00afe729665d17975af5b5313022.png" height="170"
                    class="scale-down-mobile"></v-img>
                </v-col>
              </v-row>
              <h2 class="text-gold-gradient mt-sm-0 font-title fontSize-title">Sign Up Bonus</h2>
              <p style="color: rgba(111, 111, 111, 1); font-size: 12px; padding: 0px 40px;">Top up your balance with extra free credits on
                a regular basis.
              </p>
            </v-col>
          </v-row>
        </v-col>
      </v-col>
      <v-col cols="12" sm="6" md="3" lg="3" style="backdrop-filter: blur(50px)">
        <v-col class="card2 free-card text-center">
          <v-row>
            <v-col style="width: 280px;height: 250px;">
              <v-row justify="center">
                <v-col cols="10" style="top: -15px; position: relative; height: 11rem; padding-top: 0px;">
                  <v-img src="images/fc4a8260f47c2980d291076a61763f8f.png" height="170"
                    class="scale-down-mobile"></v-img>
                </v-col>
              </v-row>
              <h2 class="text-gold-gradient mt-sm-0 font-title fontSize-title">Free Credits</h2>
              <p style="color: rgba(111, 111, 111, 1); font-size: 12px; padding: 0px 40px;">Top up your balance with extra free credits on
                a regular basis.
              </p>
            </v-col>
          </v-row>
        </v-col>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { config } from "~/plugins/config";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      url: "http://HoneybetJa/23456-gonme/aaalw0poksdxkoldp"
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

  methods: {
    copyText() {
      const inputField = this.$refs.textField;
      inputField.select();
      navigator.clipboard.writeText(inputField.value);
    },
    config,
  },
};
</script>

<style scoped>
.image-box {
  position: absolute;
}

.criptboard-style {
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
  background: #242424;
  border-radius: 8px;
  margin-bottom: 0px;
  width: 100%;
  height: 44px;
  color: #FAEC06;
  padding: 20px 110px 20px 20px;
}

.absolue-icon {
  color: #FAEC06;
  cursor: pointer !important;
  position: absolute;
  right: 26px;
  top: 22px;
}

::v-deep .v-text-field input,
::v-deep .v-text-field i {
  background: #FAEC06 !important;
  background-clip: text !important;
  color: transparent !important;
  font-size: 16px;
  line-height: 24px;
}

::v-deep .v-text-field i {
  font-size: 24px;
  line-height: 24px;
}

.refer-details-lg {
  color: rgba(111, 111, 111, 1);
  font-size: 12px;
  padding: 0px 35px 0px 0px;
}

.refer-details-sm {
  display: none;
}

.fontSize-title {
  font-size: 20px !important;
  line-height: 25.08px !important;
  font-weight: 700 !important;
  letter-spacing: 0.3px !important;
  align-items: center !important;
  margin-bottom: 8px !important;
}

.card {
  position: relative;
  border-radius: 10px;
  border: 1px solid rgba(242, 228, 95, 0.41);
  /* background: linear-gradient(
    134deg,
    rgba(116, 96, 45, 0.39) 0%,
    rgba(0, 0, 0, 0) 97.89%
  ); */
  backdrop-filter: blur(50px);
}

.card2 {
  position: relative;
  border: 5px solid transparent;
  background: linear-gradient(135deg, #292211 1%, #000000 100%);
  background-clip: padding-box;
  border-radius: 15px;
}

.card2::after {
  content: "";
  position: absolute;
  top: -1.5px;
  bottom: -0.5px;
  left: -1.5px;
  right: -1.5px;
  background: linear-gradient(135deg, #7f7432 1%, #000000 100%);
  z-index: -1;
  border-radius: 10px;
}

.image-abs-refer {
  position: absolute;
  right: -53px;
  width: 371px;
}

.font-title {
  font-family: "Orbitron", sans-serif;
  background: linear-gradient(to bottom, #FAEC06, #F6B605) !important;
  background-clip: text !important;
  color: transparent !important;
}

.d-mobile-flex {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding: 27px;
}

.refer-friends-style {
  font-family: 'Orbitron', sans-serif !important;
  font-weight: 600 !important;
  font-size: 24px !important;
  line-height: 30.1px !important;
}

.referral-style {
  font-size: 10px;
  margin-bottom: 4px;
}

@media screen and (max-width: 768px) {
  .image-abs-refer {
    position: absolute;
    right: -30px;
    top: -75px;
    width: 217px;
  }

  .font-title {
    margin-top: 0rem;
  }

  .d-mobile-flex {
    display: flex;
    flex-direction: column;
    gap: 3rem;

  }

  .hidden-attr {
    display: none;
  }

  .sign-up-card {
    width: 88%;
    margin: 0 auto;
  }

  .free-card {
    width: 88%;
    margin: 0 auto;
  }

  .scale-down-mobile {
    scale: 0.9;
    height: 180px !important;
  }

  .refer-details-lg {
    display: none;
  }

  .refer-details-sm {
    display: block;
    color: rgba(111, 111, 111, 1);
    font-size: 12px;
    padding: 0px 15px 0px 0px;
    margin-bottom: 0px !important;
  }

  .refer-details-sm span {
    margin-bottom: 11px !important;
  }

  .referral-style {
    margin-top: 11px;
  }

  .refer-friends-style {
    font-family: 'Orbitron', sans-serif !important;
    font-weight: 600 !important;
    font-size: 20px !important;
    line-height: 25px !important;
    margin-top: 15px;
  }

}
</style>
