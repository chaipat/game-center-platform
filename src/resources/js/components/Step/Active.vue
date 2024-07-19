<template>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="26"
        height="25"
        viewBox="0 0 26 25"
        fill="none"
      >
        <path
          d="M24.2063 12.7647C24.2063 18.8544 19.1321 23.8353 12.8178 23.8353C6.50336 23.8353 1.4292 18.8544 1.4292 12.7647C1.4292 6.67491 6.50336 1.69409 12.8178 1.69409C19.1321 1.69409 24.2063 6.67491 24.2063 12.7647Z"
          stroke="url(#paint0_linear_426_5691)"
          stroke-width="2"
        />
        <g filter="url(#filter0_d_250_38194)">
          <text
            x="50%"
            y="50%"
            text-anchor="middle"
            stroke="#FAEC06"
            stroke-width="1px"
            dy=".3em"
          >
            {{ no }}
          </text>
        </g>
        <defs>
          <linearGradient
            id="paint0_linear_426_5691"
            x1="12.8178"
            y1="0.694092"
            x2="12.8178"
            y2="24.8353"
            gradientUnits="userSpaceOnUse"
          >
            <stop stop-color="#FAEC06" />
            <stop offset="0.97" stop-color="#F6B605" />
          </linearGradient>
        </defs>
      </svg>
</template>

<script>
export default {
  props: ['no']
}
</script>