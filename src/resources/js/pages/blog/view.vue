<template>
  <v-container fluid style="max-width: 100% !important;">
    <v-row align="center" justify="center" class="darken-50  bg mb-5" style="height: 370px">
      <v-col cols="12" sm="5" md="5" lg="5" align="center" class="text-center" style="max-width: 700px;">
        <div class="d-inline-flex align-center mb-5">
          <div class="text-h5 text-sm-h4 text-gold-gradient font-weight-bold"
            style="font-family: var(--heading-font), sans-serif !important;font-size: 40px !important;line-height: 80px">
            <!-- {{ title }} -->
            How to play BlackJack
            <div>
              For Beginner
            </div>
          </div>
        </div>
        <div class="title font-weight-thin mb-5">
          <v-row class="justify-center">
            <v-col cols="4" lg="5" md="5" sm="5">
              <div class="d-flex" style="gap: 8px;">
                <div class="icon-style">
                  <v-icon class="pb-4 text-gold-gradient"> mdi-account-outline </v-icon>
                </div>
                <span class="text-gold-gradient admin-text-style mr-2">Admin</span>
              </div>
            </v-col>
            <v-col cols="6" lg="5" md="5" sm="5">
              <h5>
                <v-icon class="mr-1 pb-1" style="color: #737373 !important;"> mdi-calendar </v-icon>
                <span class="date__ mr-2 date-text-style " style="color: #737373 !important;">{{ ShowDate(created_at)
                  }}</span>
              </h5>
            </v-col>
          </v-row>
        </div>
      </v-col>
    </v-row>
    <v-container style="max-width: 1185px;">
      <v-row class="">
        <v-col cols="12" md="8" lg="8">
          <!-- <v-row class="mb-5"> -->
            <v-col>
              <v-img class="image-size" :src="display_images(content_image)" style="border-radius: 8px;"></v-img>
            </v-col>
            <v-col class="content__">
              <p class="centent-description" v-html="description"></p>
              <p class="centent-description" v-html="content"></p>
            </v-col>
          <!-- </v-row> -->
        </v-col>
        <v-col cols="12" md="4" lg="4">
          <v-row justify="center" :class="{ 'flex-column-reverse': $vuetify.breakpoint.sm }">
            <v-col cols="12" style="backdrop-filter: blur(50px)">
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
            <v-col cols="12" style="backdrop-filter: blur(50px)">
              <v-card class="card2">
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title class="title__">New posts</v-list-item-title>
                    <hr class="my-3 line__" style="max-width: 10%;">
                    <v-list-item-subtitle v-for="item in list" :key="item.id" class="my-2">
                      <v-row>
                        <v-col cols="auto">
                          <!-- <v-img :src=item.cover_image :alt="item.title" ></v-img> -->
                          <a :href="'/blog/' + item.id" v-on:click="ClickItem(item.id)">
                            <v-img style="border-radius: 5px" :src="display_images(item.cover_image)" class="image__blog"
                              :alt="item.title"></v-img>
                          </a>
                        </v-col>
                        <v-col cols="6">
                          <v-row>
                            <v-col cols="12" class="blog__title pb-0" style="text-wrap: wrap">{{ item.title }}</v-col>
                            <v-col class="date__blog">{{ ShowDateNewPost(item.created_at) }}</v-col>
                          </v-row>
                          <!-- <v-row><v-col class="date__">{{ item.created_at }}</v-col></v-row> -->
                        </v-col>
                      </v-row>
                    </v-list-item-subtitle>
                    <v-btn class="gold-gradient btn__text mt-3" @click="Gotoblog">
                      {{ $t("Load More") }}
                    </v-btn>
                  </v-list-item-content>
                </v-list-item>
              </v-card>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </v-container>
</template>
<script>
import axios from "axios";
import { mapGetters } from "vuex";
import moment from 'moment'

export default {
  middleware: ['guest', 'email_auth'],
  data() {
    return {
      list: [],
      cat: [],
      blog_id: 0,
      title: '',
      description: '',
      content: '',
      cover_image: '',
      content_image: '',
      created_at: ''
    }
  },
  computed: {
    ...mapGetters({ authenticated: 'auth/check' }),
    appLogoUrl() {
      return config('app.logo')
    }
  },
  created() {
    this.blog_id = this.$route.params.id
    // console.log('id:' + this.blog_id)
    console.log('authenticated:' + this.authenticated);
    if (this.authenticated) {
      console.log('auth fetchUser !!!');
      this.$store.dispatch('auth/fetchUser')
    } else {
      console.log('auth failed !!!');
    }
  },
  metaInfo() {
    return {
      title: this.title,
      meta: [
        { hid: "description", name: "description", content: this.description }
      ]
    };
  },

  // computed: {
  //   ...mapGetters({ authenticated: "auth/check" }),
  // },
  methods: {
    searchBoxClosed(v) {
      console.log('searchBoxClosed', v)
    },
    display_cover(url) {
      let show_images;

      // console.log('in:',url)
      if (url) {
        show_images = 'https://bucket-dev.baanbaan.site/' + url
      } else {
        show_images = '/images/9c83225dd97da2427de0b36b95bc131b.png';
      }
      // console.log('show_images:', show_images)

      return show_images;
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
    ClickItem(id) {
      console.log('click:' + id)
      // return this.$router.push('/blog/' + id)
      // ${this.$route.params.id}
    },
    ShowDate(showdate) {
      return moment(showdate).format("DD MMM. YYYY");
    },
    ShowDateNewPost(showdate) {
      return moment(showdate).format("DD MMM YYYY");
    },
    Gotoblog() {
      return this.$router.push('/blog')
    },
    async GetCategory() {

      await axios.get('/api/content/publish/category').then((response) => {

        // console.log('cat:' + response.data.data)
        this.cat = response.data.data

      }).catch((error) => {

        console.log('error:', error);

        let err_message = JSON.parse(error.request.response)

        // if (err_message.message)
        //   this.$store.dispatch('message/error', { text: this.$t(err_message.message + '!!!') })
        // else
        //   this.$store.dispatch('message/error', { text: this.$t(error.message + '!!!') })
      });

    },
    async GetNewPost() {

      await axios.get('/api/content/publish/blog').then((response) => {

        // console.log(response.data.data)
        this.list = response.data.data

      }).catch((error) => {

        console.log('error:', error);

        let err_message = JSON.parse(error.request.response)

        // if (err_message.message)
        //   this.$store.dispatch('message/error', { text: this.$t(err_message.message + '!!!') })
        // else
        //   this.$store.dispatch('message/error', { text: this.$t(error.message + '!!!') })
      });

    }
  },
  async mounted(route, params) {

    console.log('Get Detail')

    let result = await axios.get('/api/content/publish/blog/' + this.$route.params.id);
    // console.log(result.data.data)
    // this.list = result.data.data

    if (result) {

      this.title = result.data.data.title
      this.description = result.data.data.description
      this.content = result.data.data.content
      // document.getElementById("article_content").innerHTML = result.data.data.content

      this.cover_image = result.data.data.cover_image
      this.content_image = result.data.data.content_image
      this.created_at = moment(result.data.data.created_at).format("DD MMM YY")
    }

    this.GetCategory();
    this.GetNewPost();

    //*********** Check Auth ************/
    const today = new Date();
    const date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    const dateTime = date + ' ' + time;
    // console.log('currentDate:' + dateTime);

    this.token = localStorage.getItem('token')

    if (!this.authenticated) {

      this.authenticated = true
      this.$store.dispatch('auth/fetchUser')
    }

    await axios.get('/api/auth/me', {
      headers: {
        'Authorization': 'Bearer ' + this.token,
        'Accept': 'application/json'
      }
    }).then((response) => {

      if (response.data.code == 200) {

        this.uid = response.data.data.id
        this.username = response.data.data.username
        this.name = response.data.data.name
      }
    })

  }
};
</script>
<style lang="scss" scoped>
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

.border-card {
  // padding: 35px;
  border-radius: 10px;
  border: 1px solid rgba(242, 228, 95, 0.41);
  background: linear-gradient(134deg,
      rgba(116, 96, 45, 0.39) 0%,
      rgba(0, 0, 0, 0) 97.89%);
  backdrop-filter: blur(50px);
}

.bg {
  border-radius: 6.224px;
  background: linear-gradient(134deg,
      rgba(116, 96, 45, 0.39) 0%,
      rgba(125, 106, 55, 0.04) 97.89%);
  backdrop-filter: blur(31.11821937561035px);
}

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

.image-size {
  height: 31.5rem !important;
}

.icon-style {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: #000;
}

.admin-text-style {
  font-size: 20px !important;
  font-weight: 400 !important;
  line-height: 27px !important;
  letter-spacing: 0.1px !important;
  font-family: "Gilroy-Medium", sans-serif !important;
}

.date-text-style {
  font-size: 20px !important;
  font-weight: 400 !important;
  line-height: 13.97px !important;
  letter-spacing: 0.1px !important;
  font-family: "Gilroy-Medium", sans-serif !important;
  color: rgba(115, 115, 115, 1);

}

@media screen and (max-width: 768px) {
  .image-size {
    height: 16rem !important;
  }
}
</style>