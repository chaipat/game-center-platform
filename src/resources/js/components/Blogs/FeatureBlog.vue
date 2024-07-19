<template>
        <v-col class="order-1" cols="12" md="4" lg="4">
          <v-row>
            <v-col>
              <v-card class="border-card">
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>Categories</v-list-item-title>
                    <v-list-item-subtitle>Announcements</v-list-item-subtitle>

                    <v-list-item-subtitle>Articles</v-list-item-subtitle>

                    <v-list-item-subtitle>Events</v-list-item-subtitle>

                    <v-list-item-subtitle>News</v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </v-card>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-card class="border-card">
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title class="mb-3">New posts</v-list-item-title>
                    <v-list-item-subtitle class="mb-3" v-for="index in 4" :key="index">
                        <v-row>
                          <v-col cols="6">
                          <v-img src="/images/image-news4.png" ></v-img
                          ></v-col>
                          <v-col cols="6">
                            <v-row><v-col style="text-wrap: wrap;">How To Teach Your Kid Easily</v-col></v-row>
                            <v-row><v-col>30 Jun 2021</v-col></v-row>
                          </v-col>
                        </v-row>
                    </v-list-item-subtitle>
                    <v-btn  class="gold-gradient mt-3">
          {{ $t('Load More') }}
        </v-btn>
                    
                  </v-list-item-content>
                </v-list-item>
              </v-card>
            </v-col></v-row>
        </v-col>
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
        option:[],
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
      let result = await axios.get('/api/content/publish/blog');
      console.log(result.data.lists)
      this.list = result.data.lists
      this.option = result.data.option
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
  