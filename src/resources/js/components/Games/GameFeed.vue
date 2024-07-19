<template>
  <v-container>
    <v-row align="center" justify="space-between">
      <v-col cols="auto">
        <h2 class="text-gold-gradient font-weight-thin">
          {{ $t("GAMES") }}
        </h2>
      </v-col>
      <v-col cols="auto">
        <v-text-field
        v-model.trim="searchText"
        dense
        filled
        rounded
        clearable
        placeholder="Search"
        prepend-inner-icon="mdi-magnify"
        class="pt-6 shrink expanding-search"
        :class="{ closed: searchBoxClosed && !searchText }"
        @focus="searchBoxClosed = false"
        @blur="searchBoxClosed = true"
    ></v-text-field>
      </v-col>
    </v-row>
    <v-row class="mb-5">
      <v-col v-for="item in list" :key="item.id" cols="3">
        <a :href="item.url" v-on:click="ClickItem(item.url)"><v-img src="images/Rectangle 1491.png" alt="item.name" title="item.name"></v-img></a>
      </v-col>
    </v-row>
    <v-row class="">
      <v-col>
        <v-pagination 
        v-model="page"
        :length="total_page"
        rounded="circle"></v-pagination>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import CountryFlag from "vue-country-flag";
import { config } from "~/plugins/config";
import { mapGetters, mapState } from "vuex";
import LanguageSearchModal from "~/components/LanguageSearchModal";
import GameSearchModal from "~/components/GameSearchModal";
import  axios  from "axios";

export default {
  components: { CountryFlag, LanguageSearchModal, GameSearchModal },

  props: {
    inset: {
      type: Boolean,
      required: false,
      default: false,
    },
  },

  data() {
    return {
      list:[],
      per_page:null,
      total:null,
      next_page_url:null,
      prev_page_url:null,
      total_page:null,
      pages: config("settings.content.footer.menu"),
    };
  },

  computed: {
    ...mapState("lang", ["locale"]),
    ...mapGetters({
      games: "package-manager/getOriginalGames",
      flag: "lang/flag",
    }),
    appName() {
      return config("app.name");
    },
    appFullLogoUrl() {
      return config("app.full_logo");
    },
    background() {
      return config("settings.theme.backgrounds.footer");
    },
    links() {
      return config("settings.content.social");
    },
  },
  methods: {
    ClickItem (url){
      console.log(url)

    }
  },
  async mounted(){
    let result = await axios.get('/api/content/publish/game');
    console.log(result.data.data)
    this.list = result.data.data
    this.per_page = result.data.per_page
    this.total = result.data.total
    this.next_page_url = result.data.next_page_url
    this.prev_page_url = result.data.prev_page_url

    this.total_page = Math.ceil(this.total/this.per_page);
    console.log(this.total_page)

  }
};
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
}
</style>
