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
