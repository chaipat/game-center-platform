<template>
  <v-card :color="backgrounds" class="fill-height height-full" flat tile>
    <v-row align="center" justify="center">
      <v-col style="max-width: 1920px" class="pb-0">
        <v-toolbar class="policy-title-bar shadow-none pl-md-9">
          <a href="/" :to="{ name: 'home' }" link>
            <v-icon x-large class="text-gold-gradient mr-2 mr-md-8">
              mdi-keyboard-backspace
            </v-icon>
          </a>
          <v-toolbar-title class="fill-height d-flex align-center text-gold-gradient big-title">
            Privacy policy
          </v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text class="policy-text-content py-6">
          <v-container class="fill-height" fluid>
            <v-row align="center" justify="center">
              <v-col cols="12" sm="11" class="py-0 px-0 px-md-16 poem">
                <p class="policy-content">
                  Welcome to our website. If you continue to browse and use this
                  website, you are agreeing to comply with and be bound by the
                  following terms and conditions of use, which together with our
                  privacy policy govern our relationship with you in relation to
                  this website. If you disagree with any part of these terms and
                  conditions, please do not use our website.
                </p>
                <p>
                  The term 'us' or 'we' refers to the owner of the website. The
                  term 'you' refers to the user or viewer of our website.
                </p>

                <h3 class="text-gold-gradient policy-subtitle">
                  The use of this website is subject to the following terms of
                  use:
                </h3>
                <div class="pl-6 pt-4 pt-md-7">
                  <p class="policy-content">
                    The content of the pages of this website is for your general
                    information and use only. It is subject to change without
                    notice. This website uses cookies to monitor browsing
                    preferences. If you do allow cookies to be used, the
                    following personal information may be stored by us for use
                    by third parties. Neither we nor any third parties provide
                    any warranty or guarantee as to the accuracy, timeliness,
                    performance, completeness or suitability of the information
                    and materials found or offered on this website for any
                    particular purpose. You acknowledge that such information
                    and materials may contain inaccuracies or errors and we
                    expressly exclude liability for any such inaccuracies or
                    errors to the fullest extent permitted by law. Your use of
                    any information or materials on this website is entirely at
                    your own risk, for which we shall not be liable. It shall be
                    your own responsibility to ensure that any products,
                    services or information available through this website meet
                    your specific requirements. This website contains material
                    which is owned by or licensed to us. This material includes,
                    but is not limited to, the design, layout, look, appearance
                    and graphics. Reproduction is prohibited other than in
                    accordance with the copyright notice, which forms part of
                    these terms and conditions. All trade marks reproduced in
                    this website which are not the property of, or licensed to,
                    the operator are acknowledged on the website. Unauthorised
                    use of this website may give rise to a claim for damages
                    and/or be a criminal offence. From time to time this website
                    may also include links to other websites. These links are
                    provided for your convenience to provide further
                    information. They do not signify that we endorse the
                    website(s). We have no responsibility for the content of the
                    linked website(s).
                  </p>
                  <p class="policy-content">
                    The content of the pages of this website is for your general
                    information and use only. It is subject to change without
                    notice. This website uses cookies to monitor browsing
                    preferences. If you do allow cookies to be used, the
                    following personal information may be stored by us for use
                    by third parties. Neither we nor any third parties provide
                    any warranty or guarantee as to the accuracy, timeliness,
                    performance, completeness or suitability of the information
                    and materials found or offered on this website for any
                    particular purpose. You acknowledge that such information
                    and materials may contain inaccuracies or errors and we
                    expressly exclude liability for any such inaccuracies or
                    errors to the fullest extent permitted by law. Your use of
                    any information or materials on this website is entirely at
                    your own risk, for which we shall not be liable. It shall be
                    your own responsibility to ensure that any products,
                    services or information available through this website meet
                    your specific requirements. This website contains material
                    which is owned by or licensed to us. This material includes,
                    but is not limited to, the design, layout, look, appearance
                    and graphics. Reproduction is prohibited other than in
                    accordance with the copyright notice, which forms part of
                    these terms and conditions. All trade marks reproduced in
                    this website which are not the property of, or licensed to,
                    the operator are acknowledged on the website. Unauthorised
                    use of this website may give rise to a claim for damages
                    and/or be a criminal offence. From time to time this website
                    may also include links to other websites. These links are
                    provided for your convenience to provide further
                    information. They do not signify that we endorse the
                    website(s). We have no responsibility for the content of the
                    linked website(s).
                  </p>
                  <p class="policy-content">
                    The content of the pages of this website is for your general
                    information and use only. It is subject to change without
                    notice. This website uses cookies to monitor browsing
                    preferences. If you do allow cookies to be used, the
                    following personal information may be stored by us for use
                    by third parties. Neither we nor any third parties provide
                    any warranty or guarantee as to the accuracy, timeliness,
                    performance, completeness or suitability of the information
                    and materials found or offered on this website for any
                    particular purpose. You acknowledge that such information
                    and materials may contain inaccuracies or errors and we
                    expressly exclude liability for any such inaccuracies or
                    errors to the fullest extent permitted by law. Your use of
                    any information or materials on this website is entirely at
                    your own risk, for which we shall not be liable. It shall be
                    your own responsibility to ensure that any products,
                    services or information available through this website meet
                    your specific requirements. This website contains material
                    which is owned by or licensed to us. This material includes,
                    but is not limited to, the design, layout, look, appearance
                    and graphics. Reproduction is prohibited other than in
                    accordance with the copyright notice, which forms part of
                    these terms and conditions. All trade marks reproduced in
                    this website which are not the property of, or licensed to,
                    the operator are acknowledged on the website. Unauthorised
                    use of this website may give rise to a claim for damages
                    and/or be a criminal offence. From time to time this website
                    may also include links to other websites. These links are
                    provided for your convenience to provide further
                    information. They do not signify that we endorse the
                    website(s). We have no responsibility for the content of the
                    linked website(s).
                  </p>
                </div>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
      </v-col>
    </v-row>
  </v-card>
</template>

<script>
import axios from 'axios'
import { config } from '~/plugins/config'
import Form from 'vform'
import DeviceMixin from '~/mixins/Device'
import FormMixin from '~/mixins/Form'
import Oauth from '~/components/Oauth'
import Web3Auth from '~/components/Web3Auth'
import { mapState } from 'vuex'
import VueRecaptcha from 'vue-recaptcha'

export default {
  components: { Web3Auth, Oauth, VueRecaptcha },

  mixins: [FormMixin, DeviceMixin],
  middleware: 'guest',

  metaInfo() {
    return { title: this.$t('Authentication') }
  },

  data() {
    return {
      loading: false,
      csrfCookieRetrieved: false,
      showPassword: false,
      form: new Form({
        email: null,
        password: null,
        remember: '', // it's important to pass empty string as false value so $request->filled('remember') returns false,
        recaptcha: null,
      }),
    }
  },

  computed: {
    backgrounds() {
      return config('settings.theme.colors.dark')
    },
  },

  methods: {},
}
</script>
<style scoped>
.height-full {
  background-color: rgb(39, 39, 39) !important;
  min-height: calc(100vh - 52px);
}

.policy-content {
  line-height: 1.5;
  word-wrap: break-word;
}

.big-title {
  font-family: var(--heading-font);
  font-size: 23px;
  font-weight: 400;
  line-height: 32px;
  letter-spacing: 0em;
}

.policy-title-bar {
  display: flex;
  align-items: center;
  height: 78px;
}

.policy-title-bar,
.policy-text-content {
  background-color: #272727;
}

.v-sheet.v-toolbar:not(.v-sheet--outlined) {
  box-shadow: none !important;
}

.policy-subtitle {
  font-family: var(--heading-font);
  font-size: 16px;
  font-weight: 400;
  line-height: 24px;
  letter-spacing: 0em;
  max-width: 454px;
  word-wrap: break-word;
}

@media (min-width: 768px) {
  .v-sheet.v-toolbar:not(.v-sheet--outlined) {
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.2) !important;
  }

  .policy-title-bar {
    height: 110px !important;
  }

  .big-title {
    font-size: 48px;
    line-height: 57px;
    height: 57px;
    letter-spacing: -0.01em;
  }

  .poem {
    max-height: calc(100vh - 300px);
    overflow: auto;
  }

  /* width */
  .poem::-webkit-scrollbar {
    width: 5px;
  }

  /* Track */
  .poem::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px black;
    border-radius: 10px;
  }

  /* Handle */
  .poem::-webkit-scrollbar-thumb {
    background: linear-gradient(90deg, #faeb06 0%, #f6b705 84%, #f5b105 100%);
    border-radius: 10px;
  }

  /* Handle on hover */
  .poem::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(90deg, #f3e745 0%, #facb4b 84%, #fac84a 100%);
  }
}
</style>
