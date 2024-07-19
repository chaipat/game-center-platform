<template>
  <v-app :class="navbarVisible ? 'permanent-navbar' : 'temporary-navbar'" :style="style">
    <system-bar v-if="
      !(isMobile && (isGamePage || isPredictionPage || isProviderGamePage)) &&
      systemBarEnabled &&
      authenticated
    " />

    <v-navigation-drawer v-model="navigationDrawer" app :permanent="navbarVisible" :temporary="!navbarVisible"
      color="#18181C">
      <main-menu />
    </v-navigation-drawer>

    <chat v-if="authenticated && chatEnabled" v-model="chatDrawer" @message="setUnreadChatMessagesCount" />

    <template v-if="isMobile && (isGamePage || isPredictionPage || isProviderGamePage)">
      <v-speed-dial fixed top left>
        <template #activator>
          <v-btn small outlined icon @click.stop="navigationDrawer = !navigationDrawer">
            <v-icon small> mdi-menu </v-icon>
          </v-btn>
        </template>
      </v-speed-dial>
      <v-speed-dial fixed top right>
        <template #activator>
          <v-btn v-show="!isProviderGamePage" small outlined :to="{ name: 'user.account.transactions' }" exact>
            <v-icon small>
              {{ creditsIcon }}
            </v-icon>
            <animated-number v-if="account" :number="account.balance" />
          </v-btn>
        </template>
      </v-speed-dial>
    </template>
    <v-app-bar v-else app :clipped-left="!navbarVisible" color="#18181C">
      <v-app-bar-nav-icon v-if="!navbarVisible" @click.stop="navigationDrawer = !navigationDrawer" />

      <v-toolbar-title class="header-logo d-flex align-center">
        <router-link :to="{ name: 'home' }">
          <!-- <v-avatar size="200" tile> -->
          <v-img v-if="isMobile" :src="appLogoUrl" :alt="appName" />
          <v-img v-else :src="appFullLogoUrl" :alt="appName" />
          <!-- </v-avatar> -->
        </router-link>
        <!-- <div class="ml-3 d-none d-sm-block text-h5">
          {{ appName }}
        </div> -->
        <div v-if="!isMobile" class="ml-5 text-subtitle-2">
          <v-row no-gutters align="center">
            <v-col align-self="center" cols="auto">
              <router-link :to="{ name: 'home' }" style="text-decoration: none; color: white">
                <!-- <v-btn >
        <v-icon small>
        mdi-home
      </v-icon>
      
      
        </v-btn> -->
                <v-col cols="auto">
                  <v-row align="center">
                    <v-img class="my-2 mx-1" src="images/icons/home.png" />
                    <span class="mt-1" style="text-transform: none !important">Home</span>
                  </v-row>
                </v-col>
              </router-link>
            </v-col>
          </v-row>
        </div>
      </v-toolbar-title>

      <v-spacer />

      <template v-if="!token && !authenticated">
        <v-btn :to="{ name: 'login' }" class="btn-border font-weight-bold" outlined>
          <span class="text-gold-gradient">LOG IN</span>
        </v-btn>
        <v-btn :to="{ name: 'register' }" class="font-weight-bold gold-gradient ml-2" style="letter-spacing: 0px;">
          SIGN UP
        </v-btn>
      </template>
      <template v-else-if="authenticated">
        <account-menu />
        <settings-menu />
        <user-menu />

        <v-btn v-if="chatEnabled" icon @click="chatDrawer = !chatDrawer">
          <v-badge :content="unreadChatMessagesCount" :value="unreadChatMessagesCount" overlap>
            <v-icon>{{
              chatDrawer ? 'mdi-message' : 'mdi-message-outline'
            }}</v-icon>
          </v-badge>
        </v-btn>
      </template>
      <preloader :active="loading" />
    </v-app-bar>

    <v-main>
      <message />
      <router-view id="content" />
    </v-main>

    <!-- <component :is="footerComponent" v-if="!(isMobile && (isGamePage || isPredictionPage || isProviderGamePage))" :inset="navbarVisible" /> -->
  </v-app>
</template>

<script>
import { config } from '~/plugins/config'
import { mapState, mapGetters } from 'vuex'
import DeviceMixin from '~/mixins/Device'
import Message from '~/components/Message'
import Chat from '~/components/Chat'
import Preloader from '~/components/Preloader'
import SecondaryFooter from '~/components/SecondaryFooter'
import AdminFooter from '~/components/Admin/Footer'
import AnimatedNumber from '~/components/AnimatedNumber'
import SystemBar from '~/components/SystemBar'
import AdminMainMenu from '~/components/Admin/MainMenu'
import MainMenu from '~/components/MainMenu'
import AccountMenu from '~/components/AccountMenu'
import SettingsMenu from '~/components/SettingsMenu'
import UserMenu from '~/components/UserMenu'

export default {
  name: 'AuthLayout',

  components: {
    UserMenu,
    AccountMenu,
    MainMenu,
    AdminMainMenu,
    SystemBar,
    Message,
    Chat,
    Preloader,
    SecondaryFooter,
    AdminFooter,
    AnimatedNumber,
  },

  mixins: [DeviceMixin],

  data() {
    return {
      navigationDrawer: this.navbarVisible,
      chatDrawer: false,
      unreadChatMessagesCount: 0,
    }
  },

  computed: {
    ...mapState('auth', ['user', 'account', 'token']),
    ...mapState('progress', ['loading']),
    ...mapGetters({
      authenticated: 'auth/check',
    }),
    appName() {
      return config('app.name')
    },
    appLogoUrl() {
      return config('app.logo')
    },
    appFullLogoUrl() {
      return config('app.full_logo')
    },
    appBarBackground() {
      return config('settings.theme.backgrounds.app_bar')
    },
    creditsIcon() {
      return config('settings.interface.credits_icon')
    },
    navbarVisible() {
      return config('settings.interface.navbar.visible') && !this.isMobile
    },
    isGamePage() {
      return this.$route.name === 'game'
    },
    isProviderGamePage() {
      return this.$route.name === 'provider.game'
    },
    isPredictionPage() {
      return this.$route.name === 'prediction'
    },
    systemBarEnabled() {
      return config('settings.interface.system_bar.enabled')
    },
    chatEnabled() {
      return config('settings.interface.chat.enabled')
    },
    style() {
      return {
        background: config('settings.theme.backgrounds.page'),
      }
    },
    footerComponent() {
      if (!this.$route.name || this.$route.name === 'home') {
        return false
      }

      return this.$route.name.indexOf('admin.') > -1
        ? 'AdminFooter'
        : 'SecondaryFooter'
    },
  },

  created() {
    this.$store.dispatch('package-manager/fetchOriginalGames')
    this.$store.dispatch('package-manager/fetchProviderGames')
  },

  methods: {
    config,
    setUnreadChatMessagesCount(count) {
      this.unreadChatMessagesCount = count
    },
  },
}
</script>

<style scoped>
.v-btn:before {
  background-color: transparent !important;
}

.btn-border {
  letter-spacing: 0px;
  padding: 0.5rem;
  border: double 1px transparent;
  border-radius: 6px;
  background-image: linear-gradient(#1e1e1e, #1e1e1e),
    linear-gradient(16deg, #faeb06, #f5b105);
  background-origin: border-box;
  background-clip: padding-box, border-box;
}

.v-main {
  position: relative;
  overflow: hidden;
}

.v-main::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 120%;
  height: 100%;
  background-image: url('/images/bg-game.webp') !important;
  background-size: cover;
  background-position: 0px;
  filter: blur(3px);
  /* z-index: -1; */
}

@media screen and (max-width: 1440px) {
  .v-main::before {
    width: 125%;
  }
}

@media screen and (max-width: 768px) {
  .v-main::before {
    width: 100%;
    background-position: center center;
  }
}
</style>
