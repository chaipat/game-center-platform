<template>
  <v-select v-model="value" :items="options" label="Tyep" :disabled="disabled" :solo="solo" :hide-details="hideDetails"
    outlined @change="change" />
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
        { text: 'All', value: '00' },
        { text: 'type01', value: '01' },
        { text: 'type02', value: '02' },
      ],
    }
  },

  methods: {
    change() {
      this.$emit('change', { type: this.value })
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