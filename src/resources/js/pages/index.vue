<template>
  <div>
    <dynamic-template
      :template="html"
      :components="{
        Landing,
        Slider,
        Jackpot,
        GamesList,
        ProviderGamesList,
        ProvidersList,
        Predictions,
        PrimaryFooter,
        ProvablyFair,
        Game,
        Popgame,
        Refer,
        Features,
        News,
        Raffles,
        BiggestWin,
        RecentGames,
        Search,
        Social,
        Top5,
      }"
    />
  </div>
</template>
<script>
import axios from 'axios'
import DynamicTemplate from '~/components/DynamicTemplate'
import Slider from '~/components/Home/Slider'
import GamesList from '~/components/Home/GamesList'
import ProviderGamesList from '~/components/Home/ProviderGamesList'
import ProvidersList from '~/components/Home/ProvidersList'
import Predictions from '~/components/Home/Predictions'
import PrimaryFooter from '~/components/Home/PrimaryFooter'
import ProvablyFair from '~/components/Home/ProvablyFair'
import Game from '~/components/Home/Game'
import Popgame from '~/components/Home/Popgame'
import Refer from '~/components/Home/Refer'
import Features from '~/components/Home/Features'
import News from '~/components/Home/News'
import Raffles from '~/components/Home/Raffles'
import BiggestWin from '~/components/Home/BiggestWin'
import RecentGames from '~/components/Home/RecentGames'
import Search from '~/components/Home/Search'
import Social from '~/components/Home/Social'
import Footer from '~/components/Home/Footer'
import Jackpot from '~/components/Home/Jackpot'
import Landing from '~/components/Home/Landing'
import Top5 from '~/components/Home/Top5'
import { mapGetters } from 'vuex'

export default {
  components: { DynamicTemplate },

  metaInfo() {
    return {
      title: this.$t('Fair online casino games'),
    }
  },

  data() {
    return {
      Landing,
      Slider,
      Jackpot, //winner
      GamesList,
      ProviderGamesList,
      ProvidersList,
      Predictions,
      PrimaryFooter,
      ProvablyFair,
      Game, //Games List
      Popgame, //Popular
      Refer,
      Features,
      News, //Blog
      Raffles,
      BiggestWin,
      RecentGames,
      Search,
      Social,
      Footer,
      html: '',
      Top5,
    }
  },

  computed: {
    ...mapGetters({ authenticated: 'auth/check' }),
  },
  async created() {
    // const { data: { html } } = await axios.get('/api/pages/home')
    // this.html = `<div>${html}</div>`
    this.html = `<div> <Landing/> <Jackpot/> <Game/> <Popgame/> <Top5/> <Refer/> <Slider/> <Features/> <News/> <Raffles/> <ProvablyFair/> <Social/> </div>`
    // <Slider/>
    console.log('authenticated:' + this.authenticated)

    if (this.authenticated) {
      // update user balance
      this.$store.dispatch('auth/fetchUser')
    }
  },
  async mounted() {

    
    if (!this.authenticated) {

      console.log('Check auth!!!');

      // let cname = 'token'
      // let name = cname + "=";
      // let decodedCookie = decodeURIComponent(document.cookie);
      // let ca = decodedCookie.split(';');
      // for (let i = 0; i < ca.length; i++) {
      //   let c = ca[i];
      //   while (c.charAt(0) == ' ') {
      //     c = c.substring(1);
      //   }
      //   if (c.indexOf(name) == 0) {
      //     this.token = c.substring(name.length, c.length);
      //   }
      // }
      this.token = localStorage.token
      // console.log('token:' + this.token);
      
      if (this.token) {

        await axios.get('/api/auth/me', {
          headers: {
            'Authorization': 'Bearer ' + this.token,
          }
        }).then((response) => {

          // console.log('response:' + response);
          if (response.data.code == 200) {

            this.name = response.data.data.name
            this.username = response.data.data.username
            this.avatar = response.data.data.avatar

            console.log('name:' + this.name);
            this.authenticated = true

            console.log('reload');
            this.$store.dispatch('auth/fetchUser')
  
          // } else {
            // this.$store.dispatch('message/error', { text: this.$t('Please login!!!') })
            // this.$router.push({ name: 'login' })
          }

        }).catch((e) => {

          console.log(e)
          // this.$store.dispatch('message/error', { text: this.$t('Please login!!!') })
          // this.$router.push({ name: 'login' })

        })

      }
      
    }
    

  }
}
</script>
