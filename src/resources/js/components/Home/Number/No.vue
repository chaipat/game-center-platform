<template>
  <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 22 22" fill="none">
    <circle opacity="0.3" cx="11.2025" cy="10.7504" r="9.99775" fill="#A6B7CB" stroke="#CFE6FF"
      stroke-width="1.17621" />
    <text x="50%" y="50%" text-anchor="middle" stroke="#ffffff" stroke-width="1px" dy=".3em" class="text-style">
      {{ no }}
    </text>
  </svg>
</template>

<script>
export default {
  props: ['no']
}
</script>

<style scoped>
.text-style {
  font-family: 'Gilroy-Bold', sans-serif !important;
  font-size: 10px !important;
  font-weight: 400 !important;
  line-height: 12.38px !important;
  color: #fff;
}
</style>