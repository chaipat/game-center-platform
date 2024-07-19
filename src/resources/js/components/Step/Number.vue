<template>
  <svg
        xmlns="http://www.w3.org/2000/svg"
        width="26"
        height="25"
        viewBox="0 0 26 25"
        fill="none"
      >
        <path
          d="M24.4817 12.7647C24.4817 18.8544 19.4075 23.8353 13.0931 23.8353C6.77875 23.8353 1.70459 18.8544 1.70459 12.7647C1.70459 6.67491 6.77875 1.69409 13.0931 1.69409C19.4075 1.69409 24.4817 6.67491 24.4817 12.7647Z"
          stroke="#D1D5DB"
          stroke-width="2"
        />
        <g filter="url(#filter0_d_250_38194)">
          <text
            x="50%"
            y="50%"
            text-anchor="middle"
            stroke="#D1D5DB"
            stroke-width="1px"
            dy=".3em"
          >
            {{ no }}
          </text>
        </g>
      </svg>
</template>

<script>
export default {
  props: ['no']
}
</script>