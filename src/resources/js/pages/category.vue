<template>
  <v-container fluid>
    <v-parallax src="/images/bg-game.webp" height="350" class="home-page-provably-fair">
      <v-row align="center" justify="center" class="darken-50">
        <v-col class="text-center">
          <div class="d-inline-flex align-center mb-5">
            <svg class="mr-3" xmlns="http://www.w3.org/2000/svg" width="43" height="43" viewBox="0 0 256 256">
              <path fill="#F6B605"
                d="M225.86 102.82c-3.77-3.94-7.67-8-9.14-11.57c-1.36-3.27-1.44-8.69-1.52-13.94c-.15-9.76-.31-20.82-8-28.51s-18.75-7.85-28.51-8c-5.25-.08-10.67-.16-13.94-1.52c-3.56-1.47-7.63-5.37-11.57-9.14C146.28 23.51 138.44 16 128 16s-18.27 7.51-25.18 14.14c-3.94 3.77-8 7.67-11.57 9.14c-3.25 1.36-8.69 1.44-13.94 1.52c-9.76.15-20.82.31-28.51 8s-7.8 18.75-8 28.51c-.08 5.25-.16 10.67-1.52 13.94c-1.47 3.56-5.37 7.63-9.14 11.57C23.51 109.72 16 117.56 16 128s7.51 18.27 14.14 25.18c3.77 3.94 7.67 8 9.14 11.57c1.36 3.27 1.44 8.69 1.52 13.94c.15 9.76.31 20.82 8 28.51s18.75 7.85 28.51 8c5.25.08 10.67.16 13.94 1.52c3.56 1.47 7.63 5.37 11.57 9.14c6.9 6.63 14.74 14.14 25.18 14.14s18.27-7.51 25.18-14.14c3.94-3.77 8-7.67 11.57-9.14c3.27-1.36 8.69-1.44 13.94-1.52c9.76-.15 20.82-.31 28.51-8s7.85-18.75 8-28.51c.08-5.25.16-10.67 1.52-13.94c1.47-3.56 5.37-7.63 9.14-11.57c6.63-6.9 14.14-14.74 14.14-25.18s-7.51-18.27-14.14-25.18m-52.2 6.84l-56 56a8 8 0 0 1-11.32 0l-24-24a8 8 0 0 1 11.32-11.32L112 148.69l50.34-50.35a8 8 0 0 1 11.32 11.32" />
            </svg>
            <h3 class="text-h5 text-sm-h4 provably-blog"
              style="font-family: var(--heading-font), sans-serif !important;font-size: 36px !important">
              {{ title }}
            </h3>
          </div>
          <div class="title font-weight-thin mb-5 description-blog">
            {{ $t("All our games are provably fair.") }}
            {{ $t("We do not cheat.") }}
          </div>
        </v-col>
      </v-row>
    </v-parallax>
    <v-container style="max-width: 1185px;">
      <v-row align="center" justify="start" class="my-3" :class="{ 'flex-column-reverse': $vuetify.breakpoint.xs }">
        <v-col cols="12" sm="6">
          <v-col cols="auto">
            <v-row>
              <v-col cols="auto" class="hide-mobile">
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
              <v-col cols="auto" class="pl-0 hide-mobile">
                <span class="text-h6 font-weight-bold"><span class="text-gold-gradient"> {{ title }} </span></span>
              </v-col>
              <v-row class="show-mobile">
                <v-col style="backdrop-filter: blur(50px); padding: 0px;">
                  <v-card class="card2">
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-title class="font-weight-bold">Categories</v-list-item-title>
                        <hr class="my-3 underline-style">

                        <v-list-item-subtitle class="text-subtitle-2 my-2 text-style" v-for="item in cat"
                          :key="item.id">
                          <a active-class="text-gold-gradient" class="font-subtitle" :href="'/blog/' + item.id"
                            v-on:click="ClickItem(item.id)">
                            {{ item.title }}
                          </a>

                        </v-list-item-subtitle>

                      </v-list-item-content>
                    </v-list-item>
                  </v-card>
                </v-col>
              </v-row>
            </v-row>
          </v-col>
        </v-col>
        <v-col cols="12" sm="6">
          <v-row align="center" justify="end">
            <v-col cols="12" sm="auto">
            </v-col>
          </v-row>
        </v-col>

      </v-row>
      <v-row class="">
        <v-col cols="12" md="8" lg="8">
          <v-row class="mb-5">
            <v-col v-for="item in list" :key="item.id" cols="12" md="6" lg="6">
              <v-card class="mx-auto" max-width="344" style="background: #1c180a !important;">
                <a :href="'/blog/' + item.id" v-on:click="ClickItem(item.id)">
                  <v-img :src="display_images(item.cover_image)" :alt="item.title" height="200px"
                    style="border-top-left-radius: 13px; border-top-right-radius: 13px;"></v-img>
                </a>
                <v-card-title class="text-gold-gradient">
                  <a :href="'/blog/' + item.id" v-on:click="ClickItem(item.id)" style="text-decoration: none; ">
                    <h6 class="text-gold-gradient text-title-blog" style="">{{ item.title }}</h6>
                  </a>
                </v-card-title>
                <v-card-subtitle class="pb-1">
                  <p class="text-description-blog">
                    {{ item.description }}
                  </p>
                </v-card-subtitle>
                <v-divider class="mx-4"></v-divider>
                <v-card-actions>
                  <v-list-item class="grow">
                    <v-list-item-avatar color="grey darken-3">
                      <v-img class="elevation-6" alt="Admin" src="/images/icon-user.png"></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title class="text-gold-gradient text-admin">
                        <h5>Admin</h5>
                      </v-list-item-title>
                    </v-list-item-content>
                    <v-row align="center" justify="end" class="text-alter">
                      <h5>
                        <v-icon class="mr-1 text-alter"> mdi-calendar-blank-outline</v-icon>
                        <span class="subheading mr-2">{{ ShowDate(item.created_at) }}</span>
                      </h5>
                    </v-row>
                  </v-list-item>
                </v-card-actions>
                <!-- <v-expand-transition>
                  <div><v-divider></v-divider></div>
                </v-expand-transition> -->
              </v-card>
            </v-col>
            <v-col v-if="total_page == 0" style="text-align: center;">
              <h3 class="text-title-blog" style="font-size: larger;">Content Up Coming Soon ...</h3>
              <v-img src="/images/no-content.png" alt="no content" width="200" style="margin: 50px auto;"></v-img>
            </v-col>
          </v-row>
          <v-row>
            <v-col v-if="total_page > 0">
              <v-pagination class="pagination" v-model="page" :length="total_page" rounded="0"></v-pagination>
            </v-col>
          </v-row>
        </v-col>

        <v-col class="order-1" cols="12" md="4" lg="4">
          <v-row class="hide-mobile">
            <v-col style="backdrop-filter: blur(50px)">
              <v-card class="card2">
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title class="title__">Categories</v-list-item-title>
                    <hr class="my-3 line__" style="max-width: 10%;">
                    <v-list-item-subtitle class="my-2" v-for="item in cat" :key="item.id"
                      v-if="item.status != 'delete'">
                      <a :href="'/category/' + item.id + '/' + item.title" class="text-decoration-none list__">
                        {{ item.title }}
                      </a>
                    </v-list-item-subtitle>

                  </v-list-item-content>
                </v-list-item>
              </v-card>
            </v-col>
          </v-row>
          <v-row>
            <v-col style="backdrop-filter: blur(50px)">
              <v-card class="card2">
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title class="title__">New posts</v-list-item-title>
                    <hr class="my-3 line__" style="max-width: 10%;">
                    <v-list-item-subtitle class="my-2" v-for="item in new_post" :key="item.id">
                      <v-row>
                        <v-col cols="auto">
                          <a :href="'/blog/' + item.id" v-on:click="ClickItem(item.id)">
                            <v-img style="border-radius: 5px" :src="display_images(item.cover_image)"
                              :alt="item.title" class="image__blog"></v-img>
                          </a>
                        </v-col>
                        <v-col cols="6">
                          <v-row align-content="space-between">
                            <v-col cols="12" class="blog__title pb-0" style="text-wrap: wrap">{{ item.title }}</v-col>
                            <v-col class="date__blog font-created_at">{{ ShowDateNewPost(item.created_at) }}</v-col>
                          </v-row>
                        </v-col>
                      </v-row>
                    </v-list-item-subtitle>
                    <v-btn class="gold-gradient mt-3 load-more-style" @click="Gotoblog">
                      {{ $t('Load More') }}
                    </v-btn>

                  </v-list-item-content>
                </v-list-item>
              </v-card>
            </v-col></v-row>
        </v-col>

      </v-row>
    </v-container>
  </v-container>
</template>
<script>
import axios from "axios";
// import ListBlog from '~/components/Blogs/ListBlog2'
// import FeatureBlog from '~/components/Blogs/FeatureBlog'
import { mapGetters } from "vuex";
import moment from 'moment'

export default {

  data() {
    return {
      list: [],
      cat: [],
      new_post: [],
      title: null,
      catid: null,
      page: null,
      per_page: null,
      total: null,
      next_page_url: null,
      prev_page_url: null,
      total_page: null,
      html: ''
    }
  },
  metaInfo() {
    return {
      title: this.$t("Category Fair online casino games"),
    };
  },
  computed: {
    ...mapGetters({ authenticated: 'auth/check' }),
    appLogoUrl() {
      return config('app.logo')
    }
  },
  created() {
    console.log('authenticated:' + this.authenticated);
    if (this.authenticated) {
      console.log('auth fetchUser !!!');
      this.$store.dispatch('auth/fetchUser')
    } else {
      console.log('auth failed !!!');
    }
  },
  methods: {
    searchBoxClosed(v) {
      console.log('searchBoxClosed', v)
    },
    // searchText(v){
    //   console.log('searchText', v)
    // },
    handlePageChange(pagination) {
      console.log('update:pagination', pagination)
      // console.log('page', this.page)
      this.GetList(pagination)
    },
    Show_title() {

      if (!this.title) {
        this.title = 'Category';
      }
      return this.title
    },
    display_images(url) {
      let show_images;

      // console.log('in:',url)
      if (url) {
        show_images = 'https://bucket-dev.baanbaan.site/' + url
      } else {
        show_images = '/images/image-news1.png';
      }
      // console.log('show_images:', show_images)

      return show_images;
    },
    ClickItem(url) {
      console.log(url)
    },
    ShowDate(showdate) {
      return moment(showdate).format("DD MMM. YYYY");
    },  ShowDateNewPost(showdate) {
      return moment(showdate).format("DD MMM YYYY");
    },
    Gotoblog() {
      return this.$router.push('/blog')
    },
    async GetList(page) {

      const url = '/api/content/publish/blog/category/' + this.catid

      await axios.get(url + '?page=' + page).then((response) => {

        // console.log(response.data.data)
        this.list = response.data.data
        this.per_page = response.data.per_page
        this.total = response.data.total
        this.next_page_url = response.data.next_page_url
        this.prev_page_url = response.data.prev_page_url

        this.total_page = Math.ceil(this.total / this.per_page);
        console.log(this.total_page)

      }).catch((error) => {

        console.log('error:', error);

        let err_message = JSON.parse(error.request.response)

        if (err_message.message)
          this.$store.dispatch('message/error', { text: this.$t(err_message.message + '!!!') })
        else
          this.$store.dispatch('message/error', { text: this.$t(error.message + '!!!') })
      });

    },
    async GetCategory() {

      await axios.get('/api/content/publish/category').then((response) => {

        // console.log('cat:' + response.data.data)
        this.cat = response.data.data

      }).catch((error) => {

        console.log('error:', error);

        let err_message = JSON.parse(error.request.response)

        if (err_message.message)
          this.$store.dispatch('message/error', { text: this.$t(err_message.message + '!!!') })
        else
          this.$store.dispatch('message/error', { text: this.$t(error.message + '!!!') })
      });

    },
    async GetNewPost() {

      await axios.get('/api/content/publish/blog').then((response) => {

        // console.log(response.data.data)
        this.new_post = response.data.data

      }).catch((error) => {

        console.log('error:', error);

        let err_message = JSON.parse(error.request.response)

        if (err_message.message)
          this.$store.dispatch('message/error', { text: this.$t(err_message.message + '!!!') })
        else
          this.$store.dispatch('message/error', { text: this.$t(error.message + '!!!') })
      });

    }
  },
  async mounted() {

    this.catid = this.$route.params.id
    this.title = this.$route.params.title
    // console.log('catid:' + this.catid)

    // console.log('authenticated:' + this.authenticated);
    if (this.authenticated) {
      console.log('auth fetchUser !!!');
      this.$store.dispatch('auth/fetchUser')
    } else {
      console.log('auth failed !!!');
    }

    this.GetList(1);
    this.GetCategory();
    this.GetNewPost();

    this.token = localStorage.getItem('token')

    if (!this.authenticated) {
      console.log('authenticated...')

      if (this.token) {
        console.log('get authenticated...')

        await axios.get('/api/auth/me', {
          headers: {
            'Authorization': 'Bearer ' + this.token,
            'Accept': 'application/json'
          }
        }).then((response) => {

          if (response.data.code == 200) {

            this.authenticated = true;
            // this.uid = response.data.data.id
            // this.username = response.data.data.username
            // this.name = response.data.data.name
            console.log('auth fetchUser !!!');
            this.$store.dispatch('auth/fetchUser')
          }
        })
      }
    }

  }
};
</script>
<style lang="scss" scoped>
.card2 {
  position: relative;
  border: 5px solid transparent;
  background: linear-gradient(135deg, #292211 1%, #000000 100%);
  background-clip: padding-box;
  border-radius: 15px;
  padding: 10px;
}

.card2 a {
  color: white;
}

.expanding-search-text {
  font-family: 'Poppins', sans-serif !important;
  font-weight: 400 !important;
  font-size: 12.6px !important;
  line-height: 18.9px !important;
}

.font-subtitle {
  font-family: 'Roboto', sans-serif !important;
  text-wrap: wrap;
  font-size: 14.37px;
  font-weight: 400;
  line-height: 20px;
  color: white;
  text-decoration: none;
}

.font-created_at {
  font-family: 'Roboto', sans-serif !important;
  font-size: 12.31px;
  font-weight: 400;
  line-height: 17.24px;
  color: grey;
}

.load-more-style {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-size: 14.37px;
  font-weight: 400;
  line-height: 18.68px !important;
  letter-spacing: 0em;
}

.underline-style {
  max-width: 10%;
  border: double 1px transparent;
  background-image: linear-gradient(#1e1e1e, #1e1e1e),
    linear-gradient(16deg, #faeb06, #f5b105);
  background-origin: border-box;
  background-clip: padding-box, border-box;
}

.card2::after {
  content: "";
  position: absolute;
  top: -0.5px;
  bottom: -0.5px;
  left: -0.5px;
  right: -0.5px;
  background: linear-gradient(135deg, #7f7432 1%, #000000 100%);
  z-index: -1;
  border-radius: 10px;
}

.blog__title {
  width: 163.16px;
  height: 41px;
  box-sizing: unset;
  color: #FFFFFF;
  font-size: 14px;
  font-weight: 400;
  line-height: 20px;
  letter-spacing: 0em;
  text-align: left;
  font-family: "Roboto", sans-serif !important;
}

.date__blog {
  font-size: 12px;
  font-weight: 400;
  line-height: 17px;
  letter-spacing: 0em;
  text-align: left;
}

.date__ {
  font-size: 20px;
  font-weight: 400;
  line-height: 14px;
  letter-spacing: 0em;
  text-align: center;
}

.image__blog {
  width: 112.88px;
  height: 76.96px;
  border-radius: 5.13px;
}

.line__ {
  border: #FAEC06 1px solid;
  // border-image-source: linear-gradient(180deg, #FAEC06 0%, #F6B605 97%);
}

.title__ {
  font-size: 16.42px;
  font-weight: 400;
  line-height: 19.54px;
  letter-spacing: 0em;
  text-align: left;
  font-family: "Gilroy-Medium", sans-serif !important;
}

.list__ {
  font-size: 14.37px;
  font-weight: 400;
  line-height: 20.11px;
  letter-spacing: 0em;
  text-align: left;
  color: #FFFFFF;
  // font-family: "Gilroy-Light", sans-serif !important;
}

.content__ {
  font-size: 20px;
  font-weight: 400;
  line-height: 32px;
  letter-spacing: 0.25px;
  display: flex;
  flex-direction: column;
  margin-top: 32px;
  gap: 56px;
}

.content__ .centent-description {
  margin-bottom: 0px !important;
  text-align: left;
}

.content__ .centent-description ::v-deep p {
  margin-bottom: 0px !important;
  text-align: left;
}

.btn__text {
  font-size: 14.37px;
  font-weight: 400;
  line-height: 18.68px;
  letter-spacing: 0em;
  text-align: center;
  font-family: "Gilroy-Medium", sans-serif !important;
}

.darken-50 {
  background: rgba(0, 0, 0, 0.5);
}

.text-title-blog {
  font-family: 'Gilroy-SemiBold', sans-serif !important;
  margin-bottom: 8px;
  font-size: 14px;
  font-weight: 400;
  line-height: 16px;
}

.text-description-blog {
  font-family: 'Gilroy-SemiBold', sans-serif !important;
  font-size: 12px;
  font-weight: 400;
  line-height: 15px;
}

.text-alter {
  color: grey;
  font-size: 12px;
  line-height: 14px;
  font-weight: 400;
  font-family: "Gilroy-Medium", sans-serif;
}

.text-admin {
  font-size: 14px;
  line-height: 21px;
  font-weight: 400;
}

.border-card {
  // padding: 35px;
  border-radius: 10px;
  border: 1px solid rgba(242, 228, 95, 0.41);
  background: linear-gradient(134deg,
      rgba(116, 96, 45, 0.39) 0%,
      rgba(0, 0, 0, 0) 97.89%);
  backdrop-filter: blur(50px);
}

.provably-blog {
  font-size: 36px;
  line-height: 40px;
  letter-spacing: 0.25px;
  font-weight: 700;
}

.description-blog {
  font-size: 19px;
  line-height: 32px;
  letter-spacing: 0.25px;
}

.show-mobile {
  display: none;
}

.hide-mobile {
  display: flex;
}

::v-deep .v-pagination .v-pagination__item--active {
  background: linear-gradient(90deg, #FAEB06 0%, #F6B705 84.1%, #F5B105 100%) !important;
  color: black !important;
}

::v-deep .v-pagination .v-pagination__item {
  background: transparent;
}

::v-deep .v-pagination .v-pagination__navigation {
  background: transparent;
}

@media screen and (max-width: 768px) {
  .provably-blog {
    font-size: 30px !important;
    line-height: 40px !important;
    letter-spacing: 0.25px !important;
  }

  .description-blog {
    font-size: 14px !important;
    line-height: 28px !important;
    letter-spacing: 0.25px !important;
    width: 59%;
    margin: 0 auto;
  }

  .show-mobile {
    display: flex;
  }

  .hide-mobile {
    display: none;
  }
}
</style>
