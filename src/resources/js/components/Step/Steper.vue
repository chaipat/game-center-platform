<template>
  <v-col>
    <v-row no-gutters justify="center" class="step-row-style">
      <v-col cols="auto">
        <Finish v-if="el > 1" />
        <Active v-else :no="el" />
      </v-col>
      <v-col cols="4" sm="4" md="4" lg="4">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="2" viewBox="0 0 172 2" fill="none">
          <path d="M0 1L172 1" :stroke="el > 1 ? '#FAEC06' : '#D1D5DB'" stroke-width="2" />
        </svg>
      </v-col>
      <v-col cols="auto">
        <Finish v-if="el > 2" />
        <Active v-else-if="el === 2" no="2" />
        <Number v-else no="2" />
      </v-col>
      <v-col cols="4" sm="4" md="4" lg="4">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="2" viewBox="0 0 172 2" fill="none">
          <path d="M0 1L172 1" :stroke="el > 2 ? '#FAEC06' : '#D1D5DB'" stroke-width="2" />
        </svg>
      </v-col>
      <v-col cols="auto">
        <Finish v-if="el > 3" />
        <Active v-else-if="el === 3" no="3" />
        <Number v-else no="3" />
      </v-col>
    </v-row>
    <v-row justify="center" no-gutters>
      <v-col cols="12" sm="12" lg="11">
        <v-row justify="space-between" dense>
          <v-col cols="auto" class="text-left">
            <div :class="el >= 1 ? 'text-gold-gradient' : 'text_disable'" class=" font-Orbitron"
              style="font-size: 16px;font-weight: 500;line-height: 20px;">
              Step 1
            </div>
          </v-col>
          <v-col cols="auto" class="text-center">
            <div :class="`${el >= 2 ? 'text-gold-gradient' : 'text_disable'}`" class=" font-Orbitron"
              style="font-size: 16px;font-weight: 500;line-height: 20px;">
              Step 2
            </div>
          </v-col>
          <v-col cols="auto" class="text-right">
            <div :class="`${el === 3 ? 'text-gold-gradient' : 'text_disable'}`" class=" font-Orbitron"
              style="font-size: 16px;font-weight: 500;line-height: 20px;">
              Step 3
            </div>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-col>
</template>

<script>

import Number from '~/components/Step/Number'
import Active from '~/components/Step/Active'
import Finish from '~/components/Step/Finish'

export default {
  components: { Number, Active, Finish },
  props: ['el'],
}
</script>

<style scoped>
.text_disable {
  color: #6B7280;
}

::v-deep .step-row-style text {
  font-family: 'Orbitron', sans-serif !important;
  font-variant-numeric: normal !important;
  font-weight: 500 !important;
  font-size: 13px !important;
  line-height: 20px !important;
  letter-spacing: 0.25px;
}
</style>