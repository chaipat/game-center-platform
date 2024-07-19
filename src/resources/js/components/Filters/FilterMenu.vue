<template>
  <v-menu v-model="menu" :close-on-content-click="false" left offset-x :nudge-width="300">
    <template v-slot:activator="{ on }">
      <v-btn icon :disabled="disabled" v-on="on">
        <v-icon :color="Object.keys(values).length ? 'primary' : undefined">
          mdi-filter-outline
        </v-icon>
      </v-btn>
    </template>
    <v-card outlined>
      <v-card-title>
        {{ $t('Filter') }}
      </v-card-title>
      <v-divider />
      <v-card-text class="pt-5 pb-0">
        <component v-for="filter in filters" :key="`${filter}-${key}`" :is="`${filter}-filter`" :class="!filters.includes('period')
    ? ''
    : ['start-date-time', 'end-date-time'].includes(filter) &&
      isPeriodCustom &&
      filters.includes('period')
      ? 'd-flex'
      : ['start-date-time', 'end-date-time'].includes(filter) &&
        !isPeriodCustom &&
        filters.includes('period')
        ? 'd-none'
        : ''
    " @change="change($event)" />
      </v-card-text>
      <v-card-text class="pt-0">
        <v-select v-model="tyep" :items="options" label="Type" :solo="solo" :hide-details="hideDetails" outlined
          @change="change" />
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <v-btn class="btn-cancel-style text-uppercase pr-0" color="white" text :disabled="disabled" @click="reset">
          {{ $t('Reset') }}
        </v-btn>
        <v-btn class="btn-apply-style text-uppercase" color="warning" text :disabled="disabled" @click="apply">
          {{ $t('Apply') }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-menu>
</template>

<script>
import PeriodFilter from './PeriodFilter'
import TypeFilter from './TypeFilter'
import ComparisonPeriodFilter from './ComparisonPeriodFilter'
import UserRoleFilter from './UserRoleFilter'
import UserStatusFilter from './UserStatusFilter'
import GameFilter from './GameFilter'
import GameResultFilter from './GameResultFilter'
import DepositWithdrawalStatusFilter from './DepositWithdrawalStatusFilter'
import DepositWithdrawalMethodStatusFilter from './DepositWithdrawalMethodStatusFilter'
import AffiliateCommissionTypeFilter from './AffiliateCommissionTypeFilter'
import AffiliateCommissionStatusFilter from './AffiliateCommissionStatusFilter'
import StaffHistoryByUserTypeFilter from './StaffHistoryByUserTypeFilter'
import StaffHistoryListTypeFilter from './StaffHistoryListTypeFilter'
import BalanceTypeFilter from './BalanceTypeFilter'
import StartDateTimeFilter from './StartDateTimeFilter'
import EndDateTimeFilter from './EndDateTimeFilter'
import DataTypeFilter from './DataTypeFilter'
import PlayerTransactionTypeFilter from './PlayerTransactionTypeFilter'
import StaffTypeFilter from './StaffTypeFilter'

export default {
  components: {
    PeriodFilter,
    TypeFilter,
    ComparisonPeriodFilter,
    UserRoleFilter,
    UserStatusFilter,
    GameFilter,
    GameResultFilter,
    DepositWithdrawalStatusFilter,
    DepositWithdrawalMethodStatusFilter,
    AffiliateCommissionTypeFilter,
    AffiliateCommissionStatusFilter,
    StaffHistoryByUserTypeFilter,
    StaffHistoryListTypeFilter,
    BalanceTypeFilter,
    StartDateTimeFilter,
    EndDateTimeFilter,
    DataTypeFilter,
    PlayerTransactionTypeFilter,
    StaffTypeFilter,
  },

  props: {
    filters: {
      type: Array,
      required: true,
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false,
    },
  },

  data() {
    return {
      menu: false,
      values: {},
      key: 1,
      isPeriodCustom: false,
      tyep: null,
      options: [
        { text: 'All', value: '00' },
        { text: 'type01', value: '01' },
        { text: 'type02', value: '02' },]
    }
  },
  created() {
    console.log('filters----', filters);

  },

  methods: {
    change(object) {
      this.values = { ...this.values, ...object }
      let vals = this.values
      this.isPeriodCustom =
        vals.period && vals.period == 'custom' ? true : false
    },
    reset() {
      // force filter filters re-load and reset all values to defaults by incrementing the key
      this.key++
      this.values = {}
      this.apply()
    },
    apply() {
      this.menu = false // close menu
      this.$emit('apply', this.values)
    },
  },
}
</script>
<style>
.v-menu__content {
  contain: none !important;
  overflow-x: visible !important;
  overflow-y: visible !important;
}

.btn-cancel-style {
  font-family: 'Play', sans-serif !important;
  font-weight: 400 !important;
  font-size: 14px !important;
  line-height: 16.2px !important;
  letter-spacing: 1.25px !important;
  color: white !important;
}

.btn-apply-style{
  font-family: 'Play', sans-serif !important;
  font-weight: 400 !important;
  font-size: 14px !important;
  line-height: 16.2px !important;
  letter-spacing: 1.25px !important;
  color: #F6B605 !important;
}
</style>
