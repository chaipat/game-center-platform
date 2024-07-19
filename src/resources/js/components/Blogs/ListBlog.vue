<template>
    <div>
        <v-col cols="12" md="8" lg="8">
          <v-row class="mb-5">
            <v-col v-for="item in list" :key="item.id" cols="12" md="6" lg="6">
              <v-card class="mx-auto" max-width="344">
                <v-img src="images/image-news4.png" height="200px"></v-img>

                <v-card-title class="text-gold-gradient">
                  <h6>Lorem Ipsum is simply dummy text</h6>
                </v-card-title>

                <v-card-subtitle>
                  <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text ever
                    since the 1500sx
                  </p>
                </v-card-subtitle>
                <v-divider class="mx-4"></v-divider>
                <v-card-actions>
                  <v-list-item class="grow">
                    <v-list-item-avatar color="grey darken-3">
                      <v-img
                        class="elevation-6"
                        alt=""
                        src="/images/icon-user.png"
                      ></v-img>
                    </v-list-item-avatar>

                    <v-list-item-content>
                      <v-list-item-title class="text-gold-gradient"
                        ><h5>Admin</h5></v-list-item-title
                      >
                    </v-list-item-content>

                    <v-row
                      align="center"
                      justify="end"
                      class="text--secondary text--lighten-3"
                    >
                      <h5>
                        <v-icon class="mr-1"> mdi-calendar </v-icon>
                        <span class="subheading mr-2">12 Oct. 66</span>
                      </h5>
                    </v-row>
                  </v-list-item>
                </v-card-actions>

                <v-expand-transition>
                  <div>
                    <v-divider></v-divider>
                  </div>
                </v-expand-transition>
              </v-card>
            </v-col>
            
          </v-row>
          <v-row>
            <v-col>
              <v-pagination :length="7"></v-pagination>
            </v-col>
          </v-row>
        </v-col>
    </div>
    
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
  