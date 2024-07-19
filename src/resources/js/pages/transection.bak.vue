<template>
  <v-container fluid>
    <v-container>
      <!-- <v-toolbar flat>
            <v-toolbar-title class="text-gold-gradient">Transection</v-toolbar-title>
            <v-spacer></v-spacer>
              <v-btn icon>
              <v-icon text color="darken-2" style="transform: rotate(60deg);"> mdi-autorenew </v-icon>
            </v-btn>
            <v-btn icon>
              <v-icon text color=" darken-2"> mdi-filter </v-icon>
            </v-btn>
            
          </v-toolbar>
      <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">
            ID
          </th>
          <th class="text-left">
            Type
          </th>
          <th class="text-left">
            Amount
          </th>
          <th class="text-left">
            Balance
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in desserts"
          :key="item.name"
        >
          <td>{{ item.id }}</td>
          <td class="text-gold-gradient">{{ item.type }}</td>
          <td>{{ item.amount }}</td>
          <td>{{ item.balance }}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table> -->

      <v-data-table
        :mobile-breakpoint="0"
        :headers="dessertHeaders"
        :items="desserts"
        item-key="name"
        item-class="text-gold-gradient"
        class="elevation-1 rounded"
      >
        <template v-slot:top>
          <v-toolbar flat class="rounded">
            <v-toolbar-title class="text-gold-gradient font-Orbitron">Transection</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon>
              <v-icon text color="darken-2" style="transform: rotate(60deg);"> mdi-autorenew </v-icon>
            </v-btn>
            <v-btn icon>
              <v-icon text color=" darken-2"> mdi-filter </v-icon>
            </v-btn>
          </v-toolbar>
        </template>
        <template v-slot:item="{ item }">
    <tr>
      <td class="text-center" style="font-weight: 600;font-size: 14px !important;">{{ item.id }}</td>
      <td class="text-center" style="font-weight: 600;font-size: 14px !important;">{{ item.round_id }}</td>
      <td class="text-center" style="font-weight: 600;font-size: 14px !important;">{{ item.accountType }}</td>
      <td class="text-center" style="font-weight: 600;font-size: 14px !important;">{{ item.amount }}</td>
      <td class="text-center" style="font-weight: 600;font-size: 14px !important;">{{ item.balance }}</td>
      <td class="text-center" style="font-weight: 600;font-size: 14px !important;">{{ item.date }}</td>
    </tr>
  </template>
      </v-data-table>
    </v-container>
  </v-container>
</template>
<script>
import axios from "axios";
import { mapGetters } from "vuex";

export default {
  metaInfo() {
    return {
      title: this.$t("Fair online casino games"),
    };
  },
  data () {
      return {
        username:null,
        status:null,
        balance:null,
        dessertHeaders: [],
        desserts: [],
        data_trans: [],
      }
  },
  created() {

        this.dessertHeaders= [
          {
            text: 'ID',
            align: 'center',
            sortable: false,
            value: 'id',
          },
          { text: 'Type', value: 'round_id',align: 'center', },
          { text: 'Account Type', value: 'accountType',align: 'center', },
          { text: 'Amount', value: 'amount',align: 'center', },
          { text: 'Balance', value: 'balance',align: 'center', },
          { text: 'Date', value: 'date', align: 'center', },
        ]
        this.desserts = [
          {
            id:1,
            round_id: 'topup',
            accountType: "Staff Edit balance",
            amount: 6.0,
            balance: 24,
            date: "2023-10-09 14:54:35"
          },
          {
            id:2,
            round_id: 'topup',
            accountType: "Payment gateway",
            amount: 9.0,
            balance: 37,
            date: "2023-10-09 14:54:35"
          },
          {
            id:3,
            round_id: 'topup',
            accountType: "Wallet",
            amount: 16.0,
            balance: 23,
            date: "2023-10-09 14:54:35"
          },
          {
            id:4,
            round_id: 'topup',
            accountType: "Rocket Bet : 100",
            amount: 3.7,
            balance: 67,
            date: "2023-10-09 14:54:35"
          },
          {
            id:5,
            round_id: 'topup',
            accountType: "Rocket Bet : 100",
            amount: 16.0,
            balance: 49,
            date: "2023-10-09 14:54:35"
          },
          {
            id:6,
            round_id: 'Withdraw',
            accountType: "Rocket Bet : 100",
            amount: 0.0,
            balance: 94,
            date: "2023-10-09 14:54:35"
          },
          {
            id:7,
            round_id: 'Withdraw',
            accountType: "Rocket Bet : 100",
            amount: 0.2,
            balance: 98,
            date: "2023-10-09 14:54:35"
          },
          {
            id:8,
            round_id: 'Game History',
            accountType: "Rocket Bet : 100",
            amount: 3.2,
            balance: 87,
            date: "2023-10-09 14:54:35"
          },
          {
            id:9,
            round_id: 'Game History',
            accountType: "Rocket Bet : 100",
            amount: 25.0,
            balance: 51,
            date: "2023-10-09 14:54:35"
          },
          {
            id:10,
            round_id: 'Game History',
            accountType: "Rocket Bet : 100",
            amount: 26.0,
            balance: 65,
            date: "2023-10-09 14:54:35"
          },
        ]

        console.log('get me!!!');
        let cname = 'token'
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            this.token = c.substring(name.length, c.length);
          }
        }
        // console.log('token:' + this.token);

        /*const { data_list }  = axios.get('/api/transaction', {
            headers: {
              'Authorization': 'Bearer ' + this.token,
              'Accept' : 'application/json'
            }
        })

        if(data_list){
          console.log('data trans:' + data_list);
          if(data_list.code == 200){

            console.log('list item:' + data_list.data);
            this.desserts = data_list.data
          }
        }*/

        console.log('authenticated:' + this.authenticated);

        if (this.authenticated) {
          // update user balance
          this.$store.dispatch('auth/fetchUser')
        }

  },
  computed: {
    ...mapGetters({ authenticated: "auth/check" }),
  },async mounted(){

      /*const { data } = await axios.get('/api/auth/me', {
          headers: {
            'Authorization': 'Bearer ' + this.token,
            'Accept' : 'application/json'
          }
      })
      if(data){
        if(data.code == 200){
          await this.$store.dispatch('auth/fetchUser')
        }
      }*/

      // const { data } = await axios.get('/api/auth/me')
      /*data = await axios.get('/api/transaction', {
          headers: {
            'Authorization': 'Bearer ' + this.token,
            'Accept' : 'application/json'
          }
      })

      if(data){
        console.log('obj:' + data);
        if(data.code == 200){

          console.log('list item:' + data.data);
          this.desserts = data.data

        }else{

          this.$store.dispatch('message/error', { text: this.$t('Please login!!!') })
          // this.$router.push({ name: 'home' })
        }
      }*/
  }
};
</script>
<style lang="scss" scoped>
.darken-50 {
  background: rgba(0, 0, 0, 0.5);
}
.border-card {
  // padding: 35px;
  border-radius: 10px;
  border: 1px solid rgba(242, 228, 95, 0.41);
  background: linear-gradient(
    134deg,
    rgba(116, 96, 45, 0.39) 0%,
    rgba(0, 0, 0, 0) 97.89%
  );
  backdrop-filter: blur(50px);
}
</style>
