<template>
  <v-select
    v-model="value"
    :items="options"
    label="Type"
    :disabled="disabled"
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
  },

  data() {
    return {
      value: null,
      options: [
        { text: 'All', value: null },
        { text: 'Top up', value: 'topup' },
        { text: 'Withdraw', value: 'Withdraw' },
        { text: 'Game History', value: 'Game History' },
        { text: 'Refer friend', value: 'Refer friend' },
        { text: 'Sign up bonus', value: 'Sign up bonus' },
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
