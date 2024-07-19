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
        { text: 'Staff', value: 'staff' },
        { text: 'Super admin', value: 'super_admin' },
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
