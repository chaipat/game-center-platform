<template>
  <v-container class="mt-10">
    <data-table api="/api/transaction" title="Transaction" :filters="['period', 'start-date-time', 'end-date-time']"
      :headers="headers" :search="false">
      <template v-slot:item.actions="{ item }">
        <v-btn icon :to="{
      name: 'admin.players.show',
      params: { id: item.id, name: item.name },
    }">
          <v-icon size="18">mdi-eye-outline</v-icon>
        </v-btn>
      </template>
    </data-table>
  </v-container>
</template>
<script>
import Vue from 'vue'
import axios from "axios";
import { mapGetters } from "vuex";
import DataTable from '~/components/DataTable'

Vue.filter('currencyFormat', function (value) {
  return parseFloat(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
});

new Vue({
  el: '#app',
  data: {
    bet: "33002.00"
  }
});


export default {
  components: { DataTable },
  metaInfo() {
    return {
      title: this.$t("Transaction"),
    };
  },
  data() {
    return {
      username: null,
      status: null,
      balance: null,
      dessertHeaders: [],
      headers: [
        {
          text: 'ID',
          align: 'center',
          sortable: false,
          value: 'id',
        },
        { text: 'Type', value: 'round_id' },
        { text: 'Account Type', value: 'game', align: 'center', },
        { text: 'Amount', value: 'amount', align: 'center', },
        { text: 'Balance', value: 'balance', align: 'center', },
        { text: 'Date', value: 'created_at', align: 'center', },
      ],
      desserts: [],
      data_trans: [],
      itemsPerPage: 10,
      currentPage: 1
    }
  },
  async created() {
    let cname = 'token'
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        this.token = c.substring(name.length, c.length);
      }
    }
    // console.log('token:' + this.token);

    console.log('authenticated:' + this.authenticated);
    if (this.authenticated) {
      // update user balance
      // this.$store.dispatch('auth/fetchUser')
      await this.$store.dispatch('auth/fetchUser')

    }
    // this.fetchData()
  },
  computed: {

    ...mapGetters({ authenticated: "auth/check" }),
    paginatedData() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.data_trans.slice(startIndex, endIndex);
    },
    pages() {
      return Math.ceil(this.data_trans.length / this.itemsPerPage);
    }
  },
  methods: {
    GetTransection() {
      // axios.get('/api/transaction', {
      //   headers: {
      //     'Authorization': 'Bearer ' + this.token,
      //   }
      // }).then((response) => {

      //   console.log('response:' + response);
      //   // console.log('response data:' + response.data);
      //   console.log('total:' + response.data.total);

      //   // if (response.data.code == 200) {
      //   // console.log('code:' + response.data.code);
      //   console.log('GetTransection:' + response.data.data);

      // const mockData = [
      //   {
      //     amount: "100.00",
      //     balance: "0.00",
      //     created_at: "2024-03-17T16:52:02.000000Z",
      //     created_by: 38,
      //     game: "Blackjack",
      //     id: 189,
      //     round_id: 114,
      //     updated_at: "2024-03-17T16:52:02.000000Z",
      //     updated_by: 38
      //   },
      //   {
      //     amount: "100.00",
      //     balance: "0.00",
      //     created_at: "2024-03-17T16:52:02.000000Z",
      //     created_by: 38,
      //     game: "Blackjack",
      //     id: 190,
      //     round_id: 114,
      //     updated_at: "2024-03-17T16:52:02.000000Z",
      //     updated_by: 38
      //   },
      // ]

      // this.desserts = mockData
      // }
      // });
    },
    getDate(datetime) {

      let date = new Date(datetime).toJSON().slice(0, 10).replace(/-/g, '/')
      let time = new Date(datetime).toJSON().slice(12, 16).replace(/-/g, '/')

      if (date == '1970/01/01')
        return ''
      else
        return date + ' ' + time
    },

  }, async mounted() {

    let image_url = 'https://bucket-dev.baanbaan.site'

    console.log('get me!!!');
    let cname = 'token'
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        this.token = c.substring(name.length, c.length);
      }
    }
    // console.log('token:' + this.token);

    if (this.token) {

      await axios.get('/api/auth/me', {
        headers: {
          'Authorization': 'Bearer ' + this.token,
        }
      }).then((response) => {

        console.log('me response:' + response);
        // console.log('response data:' + response.data);
        // console.log('code:' + response.data.code);


        if (response.data.code == 200) {

          this.username = response.data.data.username
          // this.form.name = response.data.data.name
          // this.form.avatar = image_url + response.data.data.avatar
          // this.contry_code = response.data.data.contry_code
          // this.contact = response.data.data.contact
          // this.ref_id = response.data.data.ref_id
          // this.status = response.data.data.status

          console.log('username:' + this.username);
          // console.log('name:' + this.form.name);
          // console.log('avatar:' + this.form.avatar);
          // console.log('status:' + this.status);

          this.$store.dispatch('auth/fetchUser')
          console.log('reload');

          this.GetTransection();

        } else {

          // this.$store.dispatch('message/error', { text: this.$t('Please login!!!') })
          this.$router.push({ name: 'home' })
        }

      }).catch((e) => {

        console.log(e)
        // this.$store.dispatch('message/error', { text: this.$t('Please login!!!') })
        this.$router.push({ name: 'home' })

      })
    }

    // this.fetchData()
  }
};
</script>
<style lang="scss" scoped>
.darken-50 {
  background: rgba(0, 0, 0, 0.5);
}

.elevation-1 {
  box-shadow: none;
}


.container-style {
  max-width: 1185px;
  background: #272727;
  margin-top: 30px;
  padding: 17px 43px !important;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
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

.text-title {
  font-family: 'Orbitron', sans-serif !important;
  font-weight: 600 !important;
  font-size: 20px !important;
  line-height: 30px !important;
  margin: 0px !important;
}

.text-gold-gradient-edit {
  background: linear-gradient(to bottom, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
}
</style>
