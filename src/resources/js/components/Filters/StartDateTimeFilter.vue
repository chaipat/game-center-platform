<template>
  <vue-ctk-date-time-picker style="color: rgb(255, 51, 0) !important;" v-model="value" label="Start Date/Time" dark
    no-header no-button-now color="#F6B605" button-color="#F6B605" @input="change">
  </vue-ctk-date-time-picker>
</template>

<script>
import moment from 'moment'
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css'
export default {
  components: {
    'vue-ctk-date-time-picker': () => import('vue-ctk-date-time-picker'),
  },
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
    }
  },

  methods: {
    change() {
      this.value = this.value.replace("ก่อนเที่ยง", "AM");
      this.value = this.value.replace("หลังเที่ยง", "PM");
      let dateObj = new Date(this.value)
      let dateValue = moment(dateObj).format('YYYY-MM-DD HH:MM:SS')
      this.$emit('change', { startDate: dateValue })
    },
  },
}
</script>
<style>
.field.has-value .field-label[data-v-5b500588] {
  color: gray !important;
  background: transparent !important;
}
</style>