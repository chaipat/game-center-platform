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
        { text: 'All', value: null },
        { text: 'Edit balance', value: 'Edit balance' },
        { text: 'Edit profile', value: 'Edit profile' },
        { text: 'Add new user', value: 'Add new user' },
        { text: 'News', value: 'News' },
        { text: 'Login', value: 'Login' },
        { text: 'logout', value: 'logout' },
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
