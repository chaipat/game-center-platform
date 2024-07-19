<template>
  <v-footer id="primary-footer" :app="inset" :inset="inset" style="background: #18181C;"
    class="d-block mt-10 px-5 py-10 text--secondary text--darken-3">
    <v-row>
      <v-col class="text-center">
        <div class="footer-logo d-flex align-center justify-center">
          <router-link :to="{ name: 'home' }">
            <v-img :src="appFullLogoUrl" width="300" />
          </router-link>
        </div>
      </v-col>
    </v-row>

    <v-row class="my-5" dense justify="center">
      <v-col cols="12" md="provably-fair" class="pages-list text-center d-flex-mb">
        <v-btn :to="{ name: 'page', params: { id: pages[0].id } }" small text outlined rounded
          active-class="primary grey--text text--lighten-5" class="mx-2 my-2 my-lg-2 text-uppercase text-btn">
          {{ pages[0].title }}
        </v-btn>
        <v-btn :to="{ name: 'policy', params: { id: pages[1].id } }" small text outlined rounded
          active-class="primary grey--text text--lighten-5" class="mx-2 my-2 my-lg-2 text-uppercase text-btn">
          {{ pages[1].title }}
        </v-btn>
        <v-btn :to="{ name: 'terms', params: { id: pages[2].id } }" small text outlined rounded
          active-class="primary grey--text text--lighten-5" class="mx-2 my-2 my-lg-2 text-uppercase text-btn">
          {{ pages[2].title }}
        </v-btn>
        <!-- <v-btn :key="i" :to="{ name: 'page', params: { id: page.id } }" small text outlined rounded
          active-class="primary grey--text text--lighten-5" class="mx-2 my-4 my-lg-2 text-uppercase text-btn">
          {{ page.title }}
        </v-btn> -->
      </v-col>
    </v-row>
    <v-divider class="my-8 secondary lighten-1" />
    <v-row v-if="links.length">
      <v-col class="social-icons social-icons-flex text-center">
        <v-hover v-for="(link, i) in links" :key="i" v-slot="{ hover }">
          <v-btn class="mx-2 my-4 my-lg-0" fab x-small :color="hover ? link.color : 'secondary lighten-1'"
            :href="link.url" target="_blank" style="background: none !important;">
            <v-icon color="grey lighten-5">
              {{ link.icon }}
            </v-icon>
          </v-btn>
        </v-hover>
      </v-col>
    </v-row>
  </v-footer>
</template>

<script>
import CountryFlag from 'vue-country-flag'
import { config } from '~/plugins/config'
import { mapGetters, mapState } from 'vuex'
import LanguageSearchModal from '~/components/LanguageSearchModal'
import GameSearchModal from '~/components/GameSearchModal'

export default {
  components: { CountryFlag, LanguageSearchModal, GameSearchModal },

  props: {
    inset: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  data() {
    return {
      pages: config('settings.content.footer.menu')
    }
  },

  computed: {
    ...mapState('lang', ['locale']),
    ...mapGetters({
      games: 'package-manager/getOriginalGames',
      flag: 'lang/flag'
    }),
    appName() {
      return config('app.name')
    },
    appFullLogoUrl() {
      return config('app.full_logo')
    },
    background() {
      return config('settings.theme.backgrounds.footer')
    },
    links() {
      return config('settings.content.social')
    }
  }
}
</script>
<style lang="scss" scoped>
#primary-footer {
  a {
    &.text-decoration-none {
      &:hover {
        text-decoration: underline !important;
      }
    }
  }

  .v-avatar {
    transition: all ease 0.5s;

    &.grayscale {
      filter: grayscale(100%);
    }
  }

  .banner {
    height: 50px;

    &:hover {
      path {
        fill: var(--v-primary-base);
      }
    }

    path {
      fill: var(--v-secondary-lighten2);
    }
  }

  .social-icons-flex {
    display: flex !important;
    flex-direction: row !important;
    justify-content: center !important;
    gap: 1rem !important;
  }

  .text-btn {
    font-family: 'Play', sans-serif !important;
    font-weight: 400 !important;
    font-size: 12px !important;
    line-height: 13.88px !important;
    letter-spacing: 1.07px;
    height: 36px !important;
    width: fit-content;
  }

  @media screen and (max-width: 768px) {
    .social-icons-flex {
      gap: 1.5rem !important;
    }

    .d-flex-mb {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;;
    }

  //   .text-btn {
  //   width: 120px !important;
  // }

    ;
  }
}
</style>
