<template>
  <v-container class="home-page-features mt-10">
    <v-divider class="secondary my-10" />
    <v-row class="my-10 show-lg">
      <v-col cols="6" sm="6" md="6" lg="3">
        <div class="d-flex align-center justify-center justify-md-start">
          <v-icon color="secondary lighten-3" size="50" class="mr-5 icon-style">
            mdi-percent
          </v-icon>
          <h5 class="text-h6 text-lg-h5 text-uppercase text--secondary text--lighten-3 style-text-sm">
            {{ $t('Low house edge') }}
          </h5>
        </div>
      </v-col>
      <v-col cols="6" xs="6" sm="6" md="6" lg="3">
        <div class="d-flex align-center justify-center justify-md-start">
          <v-icon color="secondary lighten-3" size="50" class="mr-5 icon-style">
            mdi-shield-check-outline
          </v-icon>
          <h5 class="text-h6 text-lg-h5 text-uppercase text--secondary text--lighten-3 style-text-sm">
            {{ $t('Secure payments') }}
          </h5>
        </div>
      </v-col>
      <v-col cols="6" xs="6" sm="6" md="6" lg="3">
        <div class="d-flex align-center justify-center justify-md-start">
          <v-icon color="secondary lighten-3" size="50" class="mr-5 icon-style">
            mdi-bike-fast
          </v-icon>
          <h5 class="text-h6 text-lg-h5 text-uppercase text--secondary text--lighten-3 style-text-sm">
            {{ $t('Fast payouts') }}
          </h5>
        </div>
      </v-col>
      <v-col cols="6" xs="6" sm="6" md="6" lg="3">
        <div class="d-flex align-center justify-center justify-md-start">
          <!-- <v-icon color="secondary lighten-3" size="50" class="mr-5">
            mdi-face-agent
          </v-icon> -->
          <svg size="50" class="mr-5 icon-style text--secondary text--lighten-3" xmlns="http://www.w3.org/2000/svg"
            width="53" height="52" viewBox="0 0 53 52" fill="none">
            <path
              d="M45.8422 26.2625C45.8422 14.4638 36.687 6.44751 26.5001 6.44751C16.4207 6.44751 7.15792 14.2918 7.15792 26.3914C5.86844 27.1221 5.00879 28.4976 5.00879 30.0879V34.3862C5.00879 36.7502 6.94301 38.6844 9.30705 38.6844H11.4562V25.5748C11.4562 17.2576 18.183 10.5309 26.5001 10.5309C34.8172 10.5309 41.544 17.2576 41.544 25.5748V40.8336H24.351V45.1318H41.544C43.908 45.1318 45.8422 43.1976 45.8422 40.8336V38.2116C47.1102 37.5454 47.9914 36.2344 47.9914 34.6871V29.7441C47.9914 28.2397 47.1102 26.9287 45.8422 26.2625Z"
              fill="#8b8b8b" />
            <path
              d="M20.0524 30.0878C21.2394 30.0878 22.2016 29.1256 22.2016 27.9387C22.2016 26.7517 21.2394 25.7896 20.0524 25.7896C18.8655 25.7896 17.9033 26.7517 17.9033 27.9387C17.9033 29.1256 18.8655 30.0878 20.0524 30.0878Z"
              fill="#8b8b8b" />
            <path
              d="M32.9475 30.0878C34.1344 30.0878 35.0966 29.1256 35.0966 27.9387C35.0966 26.7517 34.1344 25.7896 32.9475 25.7896C31.7605 25.7896 30.7983 26.7517 30.7983 27.9387C30.7983 29.1256 31.7605 30.0878 32.9475 30.0878Z"
              fill="#8b8b8b" />
            <path
              d="M39.3961 23.7049C38.8837 20.6835 37.3188 17.9409 34.9785 15.9624C32.6381 13.9839 29.6733 12.8973 26.6088 12.8948C20.0969 12.8948 13.0908 18.2891 13.6495 26.7567C16.2997 25.6722 18.6403 23.9488 20.4628 21.7401C22.2852 19.5315 23.5328 16.9062 24.0943 14.0983C26.9097 19.7505 32.6908 23.6404 39.3961 23.7049Z"
              fill="#8b8b8b" />
          </svg>
          <!-- Support 24 / 7 -->
          <h5 class="text-h6 text-lg-h5 text-uppercase text--secondary text--lighten-3 style-text-sm">
            {{ $t('Support 24 hr') }}
          </h5>
        </div>
      </v-col>
    </v-row>
    <v-row class="my-10 show-sm">
      <v-col cols="6" sm="6" md="6" lg="3">
        <div class="d-flex align-center justify-center justify-md-start flex-column gap-2">
          <v-icon color="secondary lighten-3" size="50" class="mr-5 icon-style">
            mdi-percent
          </v-icon>
          <h5 class="text-h6 text-lg-h5 text-uppercase text--secondary text--lighten-3 style-text-sm">
            {{ $t('Low house edge') }}
          </h5>
        </div>
      </v-col>
      <v-col cols="6" xs="6" sm="6" md="6" lg="3">
        <div class="d-flex align-center justify-center justify-md-start flex-column gap-2">
          <v-icon color="secondary lighten-3" size="50" class="mr-5 icon-style">
            mdi-bike-fast
          </v-icon>
          <h5 class="text-h6 text-lg-h5 text-uppercase text--secondary text--lighten-3 style-text-sm-fast">
            {{ $t('Fast payouts') }}
          </h5>
        </div>
      </v-col>
      <v-col cols="6" xs="6" sm="6" md="6" lg="3">
        <div class="d-flex align-center justify-center justify-md-start flex-column gap-2">
          <v-icon color="secondary lighten-3" size="50" class="mr-5 icon-style">
            mdi-shield-check-outline
          </v-icon>
          <h5 class="text-h6 text-lg-h5 text-uppercase text--secondary text--lighten-3 style-text-sm">
            {{ $t('Secure payments') }}
          </h5>
        </div>
      </v-col>

      <v-col cols="6" xs="6" sm="6" md="6" lg="3">
        <div class="d-flex align-center justify-center justify-md-start flex-column gap-2">
          <!-- <v-icon color="secondary lighten-3" size="50" class="mr-5">
            mdi-face-agent
          </v-icon> -->
          <svg size="50" class="mr-5 icon-style text--secondary text--lighten-3" xmlns="http://www.w3.org/2000/svg"
            width="53" height="52" viewBox="0 0 53 52" fill="none">
            <path
              d="M45.8422 26.2625C45.8422 14.4638 36.687 6.44751 26.5001 6.44751C16.4207 6.44751 7.15792 14.2918 7.15792 26.3914C5.86844 27.1221 5.00879 28.4976 5.00879 30.0879V34.3862C5.00879 36.7502 6.94301 38.6844 9.30705 38.6844H11.4562V25.5748C11.4562 17.2576 18.183 10.5309 26.5001 10.5309C34.8172 10.5309 41.544 17.2576 41.544 25.5748V40.8336H24.351V45.1318H41.544C43.908 45.1318 45.8422 43.1976 45.8422 40.8336V38.2116C47.1102 37.5454 47.9914 36.2344 47.9914 34.6871V29.7441C47.9914 28.2397 47.1102 26.9287 45.8422 26.2625Z"
              fill="#8b8b8b" />
            <path
              d="M20.0524 30.0878C21.2394 30.0878 22.2016 29.1256 22.2016 27.9387C22.2016 26.7517 21.2394 25.7896 20.0524 25.7896C18.8655 25.7896 17.9033 26.7517 17.9033 27.9387C17.9033 29.1256 18.8655 30.0878 20.0524 30.0878Z"
              fill="#8b8b8b" />
            <path
              d="M32.9475 30.0878C34.1344 30.0878 35.0966 29.1256 35.0966 27.9387C35.0966 26.7517 34.1344 25.7896 32.9475 25.7896C31.7605 25.7896 30.7983 26.7517 30.7983 27.9387C30.7983 29.1256 31.7605 30.0878 32.9475 30.0878Z"
              fill="#8b8b8b" />
            <path
              d="M39.3961 23.7049C38.8837 20.6835 37.3188 17.9409 34.9785 15.9624C32.6381 13.9839 29.6733 12.8973 26.6088 12.8948C20.0969 12.8948 13.0908 18.2891 13.6495 26.7567C16.2997 25.6722 18.6403 23.9488 20.4628 21.7401C22.2852 19.5315 23.5328 16.9062 24.0943 14.0983C26.9097 19.7505 32.6908 23.6404 39.3961 23.7049Z"
              fill="#8b8b8b" />
          </svg>
          <!-- Support 24 / 7 -->
          <h5 class="text-h6 text-lg-h5 text-uppercase text--secondary text--lighten-3 style-text-sm">
            {{ $t('Support 24 hr') }}
          </h5>
        </div>
      </v-col>
    </v-row>
    <v-divider class="secondary my-10" />
  </v-container>
</template>
<style scoped>
.show-sm {
  display: none;
}

.show-lg {
  display: flex;
}

@media screen and (max-width: 768px) {
  .show-sm {
    display: flex;
  }

  .show-lg {
    display: none;
  }

  .style-text-sm-fast {
    /* padding-left: 1rem !important; */
    font-size: 1.15rem !important;
    font-weight: 400 !important;
    line-height: 2rem;
    letter-spacing: 0.0125em !important;
    font-family: "Orbitron", sans-serif !important;
  }

  .style-text-sm {
    padding: 0px 1.5rem !important;
    font-size: 1.15rem !important;
    font-weight: 400 !important;
    line-height: 2rem;
    letter-spacing: 0.0125em !important;
    font-family: "Orbitron", sans-serif !important;
  }

  .icon-style {
    margin: 0px !important;
  }
}
</style>