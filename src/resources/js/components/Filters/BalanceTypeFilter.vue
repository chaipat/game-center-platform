<template>
  <v-select
    v-model="value"
    :items="options"
    label="Type"
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
        { text: 'Pop up', value: 'Pop up' },
        { text: 'Withdraw', value: 'Withdraw' },
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
