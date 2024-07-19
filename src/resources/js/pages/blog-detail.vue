<template>
  <v-container fluid style="max-width: 100% !important;">
    <v-row align="center" justify="center" class="darken-50  bg mb-5" style="height: 370px">
      <v-col cols="12" sm="5" md="5" lg="5" align="center" class="text-center"
        style="max-width: 700px; height: 100% !important; padding: 50px 0px 50px 00px;">
        <div class="d-inline-flex align-center mb-5">
          <div class="text-h5 text-sm-h4 text-gold-gradient font-weight-bold"
            style="font-family: var(--heading-font), sans-serif !important;font-size: 40px !important;line-height: 80px">
            <!-- {{ title }} -->
            How to play BlackJack
            For Beginner
          </div>
        </div>
        <div class="title font-weight-thin mt-lg-15">
          <v-row>
            <v-col>
              <div class="d-flex flex-row justify-center align-center" style="gap: 8px;">
                <div style="background: black !important; width: 1.6rem; height: 1.6rem; border-radius: 50%;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <path fill="#FAEC06"
                      d="M12 4a4 4 0 1 0 0 8a4 4 0 0 0 0-8M6 8a6 6 0 1 1 12 0A6 6 0 0 1 6 8m2 10a3 3 0 0 0-3 3a1 1 0 1 1-2 0a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5a1 1 0 1 1-2 0a3 3 0 0 0-3-3z" />
                  </svg>
                </div>
                <span class="text-gold-gradient font-admin">Admin</span>
              </div>
            </v-col>
            <v-col>
              <div class="d-flex flex-row justify-center align-center" style="gap: 8px; padding-top: 3px;">
                <v-icon class="text-alter icon-create"> mdi-calendar-blank-outline</v-icon>
                <span class="date__create">12 Oct. 66</span>
              </div>
            </v-col>
          </v-row>
        </div>
      </v-col>
    </v-row>
    <v-container style="max-width: 1185px;">
      <v-row class="">
        <v-col cols="12" md="8" lg="8">
          <v-row class="mb-5">
            <v-col>
              <v-img src="https://platform-dev.baanbaan.site/images/9c83225dd97da2427de0b36b95bc131b.png"
                style="border-radius: 8px;"></v-img>
            </v-col>
            <v-col class="content__">
              <p>
                {{ description }}
              </p>
              <p>
                {{ content }}
              </p>
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12" md="4" lg="4">
          <v-row justify="center" :class="{ 'flex-column-reverse': $vuetify.breakpoint.sm }">
            <v-col cols="12" style="backdrop-filter: blur(50px)">
              <v-card class="card2">
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title class="title__">Categories</v-list-item-title>
                    <hr class="my-3 line__ underline-style" style="max-width: 10%;">
                    <v-list-item-subtitle class="my-2" v-for="item in cat" :key="item.id">
                      <a href="" class="text-decoration-none list__">
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
                    <hr class="my-3 line__ underline-style" style="max-width: 10%;">
                    <v-list-item-subtitle class="my-2" v-for="item in list" :key="item.id">
                      <v-row>
                        <v-col cols="auto">
                          <!-- <v-img :src=item.cover_image :alt="item.title" ></v-img> -->
                          <a :href="'/blog/' + item.id" v-on:click="ClickItem(item.id)">
                            <v-img src="/images/image-news1.png" class="image__blog" :alt="item.title"></v-img>
                          </a>
                        </v-col>
                        <v-col cols="6">
                          <v-row>
                            <v-col cols="12" class="blog__title" style="text-wrap: wrap">{{ item.title }}</v-col>
                            <v-col class="date__blog">{{ ShowDate(item.created_at) }}</v-col>
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
  metaInfo() {
    return {
      title: this.$t("Fair online casino games"),
    };
  },
  data() {
    return {
      list: [
        { id: 1, title: "How To Teach Your Kid Easily", created_at: "30 Jun 2021" },
        { id: 2, title: "Better Relationship Between Friends", created_at: "30 Jun 2021" },
        { id: 3, title: "Become a Straight-A Student", created_at: "30 Jun 2021" },
        { id: 4, title: "Better Relationship Between Friends", created_at: "30 Jun 2021" },
        { id: 5, title: "Better ", created_at: "30 Jun 2021" }
      ],
      cat: [{ id: 1, title: "Announcements" }, { id: 2, title: "Articles" }, { id: 3, title: "Events" }, { id: 4, title: "News" }],
      blog_id: 0,
      title: '',
      description: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
      content: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.",
      cover_image: '',
      content_image: '',
      created_at: ''
    }
  },
  methods: {
    ShowDate(showdate) {
      return moment(showdate).format("DD MMM. YY");
    },
  },
  computed: {
    ...mapGetters({ authenticated: "auth/check" }),
  },
};
</script>
<style lang="scss" scoped>
.blog__title {
  font-family: 'Roboto', sans-serif !important;
  text-wrap: wrap;
  font-size: 14.37px;
  font-weight: 400;
  line-height: 20px;
  width: 163.16px;
  padding-left: 0 !important;
  height: 41px;
  box-sizing: unset;
  color: #FFFFFF;
  text-align: left;
}

.date__blog {
  padding-left: 0 !important;
  font-family: 'Roboto', sans-serif !important;
  text-align: left;
  font-size: 12.31px;
  font-weight: 400;
  line-height: 17.24px;
  color: grey;
}

.date__ {
  font-size: 20px;
  font-weight: 400;
  line-height: 14px;
  letter-spacing: 0em;
  text-align: center;
}

.underline-style {
  max-width: 10%;
  border: double 1px transparent;
  background-image: linear-gradient(#1e1e1e, #1e1e1e),
    linear-gradient(16deg, #faeb06, #f5b105);
  background-origin: border-box;
  background-clip: padding-box, border-box;
}

.date__create {
  font-family: 'Gilroy-Bold', sans-serif !important;
  font-weight: 400 !important;
  font-size: 20px !important;
  line-height: 21px !important;
  color: #737373;
}

.icon-create {
  width: 23.39px;
  height: 23.39px;
  line-height: 21px !important;
  color: #737373;
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
  font-size: 16px;
  font-weight: 400;
  line-height: 20px;
  letter-spacing: 0em;
  text-align: left;

}

.font-admin {
  font-family: 'Gilroy-Bold', sans-serif !important;
  font-weight: 400 !important;
  font-size: 20px !important;
  line-height: 21px !important;
  letter-spacing: 0.1px !important;
}

.list__ {
  font-size: 14px;
  font-weight: 400;
  line-height: 20px;
  letter-spacing: 0em;
  text-align: left;
  color: #FFFFFF;
}

.content__ {
  font-size: 20px;
  font-weight: 400;
  line-height: 32px;
  letter-spacing: 0.25px;
  text-align: left;
}

.btn__text {
  font-size: 14px;
  font-weight: 500;
  line-height: 19px;
  letter-spacing: 0em;
  text-align: center;

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
</style>
