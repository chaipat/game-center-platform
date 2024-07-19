<template>
  <v-select v-model="value" :items="options" label="Period" :disabled="disabled" :solo="solo"
    :hide-details="hideDetails" outlined @change="change" />
</template>

<script>
export default {
  props: {
    disabled: {
      type: Boolean,
      required: false,
      default: false,
    },
    hideDetails: {
      type: Boolean,
      required: false,
      default: false,
    },
    solo: {
      type: Boolean,
      required: false,
      default: false,
    },
  },

  data() {
    return {
      value: null,
      options: [
        { text: 'All time', value: null },
        { text: 'Custom', value: 'custom' },
        // { text: 'Last 24 hours', value: 'last24' },
        // { text: 'This week', value: 'week' },
        // { text: 'Previous week', value: 'prev_week' },
        // { text: 'This month', value: 'month' },
        // { text: 'Previous month', value: 'prev_month' },
        // { text: 'This year', value: 'year' },
        // { text: 'Previous year', value: 'prev_year' }
      ],
    }
  },

  methods: {
    change() {
      this.$emit('change', { period: this.value })
    },
  },
}
</script>
<style>
label {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-weight: 400 !important;
  font-size: 12px !important;
  line-height: 20px !important;
  color: gray !important;
  background: transparent !important;
}

.v-select__selection {
  font-family: 'Play', sans-serif !important;
  font-weight: 400 !important;
  font-size: 15px !important;
  line-height: 18px !important;
}

::v-deep .v-application .primary--text {
  color: gray !important;
  background: transparent !important;
}
</style>