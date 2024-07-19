<template>
  <v-list dense class="app-menu-list">
    <v-list-item class="item-home" :to="{ name: 'home' }" link exact>
      <v-list-item-action class="icon-home">
        <v-icon>mdi-home-outline</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <div class="text-home">{{ $t('Home') }}</div>
      </v-list-item-content>
    </v-list-item>

    <v-divider class="mx-4 my-4" />

    <v-list-item @click="goto_backject" link exact class="main-menu-history">
      <v-list-item-action class="mr-2">
        <v-img :aspect-ratio="1" src="/images/menu/cards.svg" width="22" cover></v-img>
      </v-list-item-action>
      <v-list-item-content>
        <div class="text-list"> Blackjack </div>
      </v-list-item-content>
    </v-list-item>

    <v-list-item @click="goto_rocket" link exact class="main-menu-history">
      <v-list-item-action class="mr-2">
        <v-img :aspect-ratio="1" src="/images/menu/casino.svg" width="22" cover></v-img>
      </v-list-item-action>
      <v-list-item-content>
        <div class="text-list"> Rocket </div>
      </v-list-item-content>
    </v-list-item>

    <v-list-item :to="{ name: 'history' }" link exact disabled class="main-menu-history d-none">
      <v-list-item-action class="mr-2">
        <v-img :aspect-ratio="1" src="/images/menu/dice.svg" width="22" cover></v-img>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>
          Dice
          <span class="text-coming">(coming soon)</span>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>

    <v-list-item :to="{ name: 'history' }" link exact disabled class="main-menu-history d-none">
      <v-list-item-action class="mr-2">
        <v-img :aspect-ratio="1" src="/images/menu/bingo.svg" width="22" cover></v-img>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>
          Bingo
          <span class="text-coming">(coming soon)</span>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>

    <v-list-item :to="{ name: 'history' }" link exact disabled class="main-menu-history d-none">
      <v-list-item-action class="mr-2">
        <v-img :aspect-ratio="1" src="/images/menu/casino.svg" width="22" cover></v-img>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>
          Vegas Wheel
          <span class="text-coming">(coming soon)</span>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>

    <v-divider class="mx-4 my-4" />

    <v-list-item :to="{ name: 'history' }" link exact class="main-menu-history">
      <v-list-item-action class="mr-2">
        <v-icon>mdi-history</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <div class="text-list">{{ $t('History') }}</div>
      </v-list-item-content>
    </v-list-item>
    <v-list-item :to="{ name: 'history' }" link exact class="main-menu-history">
      <v-list-item-action class="mr-2">
        <v-icon>mdi-trophy-outline</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <div class="text-list"> Leader board</div>
      </v-list-item-content>
    </v-list-item>
    <v-list-item v-if="authenticated" @click="logout" link exact class="main-menu-history">
      <v-list-item-action class="mr-2">
        <v-icon>mdi-logout</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <div class="text-list"> log out</div>
      </v-list-item-content>
    </v-list-item>
    <!-- <template v-if="authenticated">
      <v-list-group
        v-if="originalGames.length"
        prepend-icon="mdi-fire"
        no-action
        class="main-menu-original-games"
      >
        <template #activator>
          <v-list-item-title>{{ $t('Original games') }}</v-list-item-title>
        </template>
<template v-for="(game, i) in originalGames">
          <v-list-item :key="i" :to="game.route" link exact>
            <v-list-item-content>
              <v-list-item-title>
                {{ game.name }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
</v-list-group>
<template v-if="gameProvidersPackageIsEnabled">
        <v-list-group
          v-for="(category, i) in featuredCategoryGames"
          :key="i"
          :prepend-icon="category.icon || 'mdi-cards-playing-outline'"
          no-action
          class="main-menu-provider-games"
        >
          <template #activator>
            <v-list-item-title>{{ category.title }}</v-list-item-title>
          </template>
<template v-for="(game, k) in category.games">
            <v-list-item :key="k" :to="game.route" link exact>
              <v-list-item-content>
                <v-list-item-title>
                  {{ game.name }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
</v-list-group>
</template>
<v-list-group v-if="Object.keys(predictions).length" prepend-icon="mdi-trending-up" no-action
  class="main-menu-predictions">
  <template #activator>
          <v-list-item-title>{{ $t('Markets') }}</v-list-item-title>
        </template>
  <template v-for="(pkg, id) in predictions">
          <v-list-item
            :key="id"
            :to="{ name: 'prediction', params: { packageId: id } }"
            link
            exact
          >
            <v-list-item-content>
              <v-list-item-title>{{ pkg.name }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
</v-list-group>
<v-list-item v-if="rafflePackageIsEnabled" :to="{ name: 'raffles' }" link exact class="main-menu-raffles">
  <v-list-item-action class="mr-2">
    <v-icon>mdi-ticket</v-icon>
  </v-list-item-action>
  <v-list-item-content>
    <v-list-item-title>{{ $t('Raffles') }}</v-list-item-title>
  </v-list-item-content>
</v-list-item>
<v-list-item v-if="paymentsPackageIsEnabled" :to="{ name: 'user.account.deposits.index' }" link exact
  class="main-menu-deposits">
  <v-list-item-action class="mr-2">
    <v-icon>mdi-cash-plus</v-icon>
  </v-list-item-action>
  <v-list-item-content>
    <v-list-item-title>{{ $t('Deposits') }}</v-list-item-title>
  </v-list-item-content>
</v-list-item>
<v-list-item v-if="paymentsPackageIsEnabled" :to="{ name: 'user.account.withdrawals.index' }" link exact
  class="main-menu-withdrawals">
  <v-list-item-action>
    <v-icon>mdi-cash-minus</v-icon>
  </v-list-item-action>
  <v-list-item-content>
    <v-list-item-title>{{ $t('Withdrawals') }}</v-list-item-title>
  </v-list-item-content>
</v-list-item>
<v-list-item v-if="leaderboardPageEnabled" :to="{ name: 'leaderboard' }" link exact class="main-menu-leaderboard">
  <v-list-item-action>
    <v-icon>mdi-star</v-icon>
  </v-list-item-action>
  <v-list-item-content>
    <v-list-item-title>{{ $t('Leaderboard') }}</v-list-item-title>
  </v-list-item-content>
</v-list-item>
</template> -->
  </v-list>
</template>

<script>
import { mapGetters } from 'vuex'
import { config } from '~/plugins/config'
import cloneDeep from 'clone-deep'

export default {
  data() {
    return {
      featuredCategories: config(
        'settings.content.home.provider_games.featured_categories'
      ),
    }
  },

  computed: {
    ...mapGetters({
      authenticated: 'auth/check',
      originalGames: 'package-manager/getOriginalGames',
      getProviderGamesByCategories:
        'package-manager/getProviderGamesByCategories',
      gameProvidersPackageIsEnabled: 'package-manager/gameProvidersIsEnabled',
      paymentsPackageIsEnabled: 'package-manager/paymentsIsEnabled',
      rafflePackageIsEnabled: 'package-manager/raffleIsEnabled',
    }),
    featuredCategoryGames() {
      return cloneDeep(this.featuredCategories).map((item) => {
        item.games = this.getProviderGamesByCategories(item.categories)
        return item
      })
    },
    leaderboardPageEnabled() {
      return config('settings.content.leaderboard.enabled')
    },
    predictions() {
      return this.$store.getters['package-manager/getByType']('prediction')
    },
  },

  methods: {
    goto_backject() {
      if (this.authenticated) {
        window.open(localStorage.backject);
      } else {
        this.$router.push({ name: 'login' })
      }
    },
    goto_rocket() {
      if (this.authenticated) {
        window.open(localStorage.rocket);
      } else {
        this.$router.push({ name: 'login' })
      }
    },
    async logout() {
      // Log out
      await this.$store.dispatch('auth/logout')

      // Redirect to home page
      if (this.$route.name !== 'home') {
        this.$router.push({ name: 'home' })
      }
    },
  },
}
</script>
<style scoped>
.text-coming {
  font-size: 12px;
  font-weight: 400;
  line-height: 15px;
  letter-spacing: 0em;
  text-align: left;
  margin-left: 10px;
}

.item-home {
  display: flex;
  flex-direction: row;
  justify-content: start;
  align-items: center;
  gap: 10px;
}

.item-home .icon-home {
  margin: 0;
}

.text-home {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-weight: 400 !important;
  font-size: 16px !important;
  line-height: 19.4px !important;
  margin-top: 2px !important;
}

.text-list {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-weight: 400 !important;
  font-size: 16px !important;
  line-height: 19.4px !important;
  margin-top: 2px !important;
}
</style>
