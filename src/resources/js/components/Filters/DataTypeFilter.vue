<template>
  <v-select
    v-model="value"
    :items="options"
    label="Data type"
    :disabled="disabled"
    :solo="solo"
    :hide-details="hideDetails"
    outlined
    @change="change"
  />
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
        { text: 'Transactions', value: 'Transactions' },
        { text: 'Lead', value: 'Lead' },
      ],
    }
  },

  methods: {
    change() {
      this.$emit('change', { dataType: this.value })
    },
  },
}
</script>
