<template>
  <v-menu v-model="menu" :close-on-content-click="false" offset-y>
    <template #activator="{ on }">
      <v-btn class="group-deposit" icon v-on="on">
        <v-avatar size="40">
          <v-img class="mx-2" :src="avatar" max-height="40" max-width="37" min-height="40" min-width="37" />
        </v-avatar>
      </v-btn>
    </template>

    <v-card width="254">
      <v-list>
        <v-list-item>
          <v-list-item-avatar>
            <v-avatar size="40">
              <v-img class="mx-2" :src="avatar" max-height="40" max-width="37" min-height="40" min-width="37" />
            </v-avatar>
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title class="font-weight-bold">
              {{ name }}
            </v-list-item-title>
            <!-- <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle> -->
          </v-list-item-content>

          <!-- <v-list-item-action class="flex-row">
            <v-tooltip bottom>
              <template #activator="{ on }">
                <v-btn
                  icon
                  :to="{ name: 'profile' }"
                  @click="userMenu = false"
                  v-on="on"
                >
                  <v-icon>mdi-account</v-icon>
                </v-btn>
              </template>
              <span>{{ $t('Profile') }}</span>
            </v-tooltip>
            <v-tooltip bottom>
              <template #activator="{ on }">
                <v-btn icon @click="HideUserMenu('/password/change')" v-on="on">
                  <v-icon> mdi-square-edit-outline </v-icon>
                </v-btn>
              </template>
              <span>{{ $t('Change Password') }}</span>
            </v-tooltip>
            <v-tooltip bottom>
              <template #activator="{ on }">
                <v-btn
                  icon
                  :to="{ name: 'user.security' }"
                  @click="userMenu = false"
                  v-on="on"
                >
                  <v-icon>mdi-shield-lock</v-icon>
                </v-btn>
              </template>
              <span>{{ $t('Security') }}</span>
            </v-tooltip>
            <v-tooltip bottom>
              <template #activator="{ on }">
                <v-btn
                  icon
                  :to="{ name: 'user.affiliate' }"
                  @click="userMenu = false"
                  v-on="on"
                >
                  <v-icon>mdi-link</v-icon>
                </v-btn>
              </template>
              <span>{{ $t('Affiliate program') }}</span>
            </v-tooltip>
          </v-list-item-action> -->
        </v-list-item>
      </v-list>

      <v-card-actions>
        <v-list>
          <v-list-item href="/profile">
            <v-list-item-icon class="mr-2">
              <v-icon>mdi-account-circle-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Profile</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item href="/password/change">
            <v-list-item-icon class="mr-2">
              <v-icon> mdi-shield-check-light</v-icon>
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 256 256">
                <path fill="#fff"
                  d="M208 40H48a16 16 0 0 0-16 16v58.78c0 89.61 75.82 119.34 91 124.39a15.53 15.53 0 0 0 10 0c15.2-5.05 91-34.78 91-124.39V56a16 16 0 0 0-16-16m0 74.79c0 78.42-66.35 104.62-80 109.18c-13.53-4.51-80-30.69-80-109.18V56h160ZM82.34 141.66a8 8 0 0 1 11.32-11.32L112 148.68l50.34-50.34a8 8 0 0 1 11.32 11.32l-56 56a8 8 0 0 1-11.32 0Z" />
              </svg>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Change password</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item @click="go({ name: 'admin.users.show', params: { id } })">
            <v-list-item-icon class="mr-2">
              <v-img :aspect-ratio="1" src="/images/menu/network-people.svg" width="25" cover></v-img>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Refer friend</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item href="/transection">
            <v-list-item-icon class="mr-2">
              <v-icon>mdi-format-list-bulleted</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Transactions</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item @click="logout">
            <v-list-item-icon class="mr-2">
              <v-icon>mdi-logout</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ $t('Log out') }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-card-actions>
    </v-card>
  </v-menu>
</template>

<script>
import { mapState } from 'vuex'
import { config } from '~/plugins/config'

export default {
  data() {
    return {
      name: null,
      username: null,
      avatar: '/images/icon-user.png',
      menu: false,
      token: null,
    }
  },
  computed: {
    ...mapState('auth', ['user', 'account', 'token']),
    authenticated: 'auth/check',
  },
  created() {

    let HostImages = 'https://bucket-dev.baanbaan.site/';

    let cname = 'token'
    let name = cname + '='
    let decodedCookie = decodeURIComponent(document.cookie)
    let ca = decodedCookie.split(';')
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i]
      while (c.charAt(0) == ' ') {
        c = c.substring(1)
      }
      if (c.indexOf(name) == 0) {
        this.token = c.substring(name.length, c.length)
      }
    }
    this.name = localStorage.name;
    this.username = localStorage.username;

    if (localStorage.avatar !== '/' && localStorage.avatar !== HostImages) {
      this.avatar = localStorage.avatar
    } else if (localStorage.avatar === '/' || localStorage.avatar === undefined || localStorage.avatar === HostImages) {
      this.avatar = '/images/icon-user.png'
    }
    // }

    console.log('avatar>>>', this.avatar);

    // console.log('usermenu token:' + this.token);
    // this.$router.push({ name: 'password.change' })
  },
  methods: {
    go(path) {
      this.$router.push(path)
    },
    async logout() {
      // Log out
      await this.$store.dispatch('auth/logout')

      // Redirect to home page
      if (this.$route.name !== 'home') {
        this.$router.push({ name: 'home' })
      }
    },
    HideUserMenu(menulink) {
      this.userMenu = false
      // this.$router.push({ name: menulink })
      window.location = menulink
    },
    GotoChgPass() {
      this.$router.push({
        name: 'password.change',
        params: { token: this.token },
      })
    },
  }
}
</script>
<style scoped>
.group-deposit {
  margin-left: 23px;
}

@media screen and (max-width: 768px) {
  .group-deposit {
    margin-left: 6px;
  }
}
</style>