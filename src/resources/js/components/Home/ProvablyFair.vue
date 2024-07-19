<template>
  <v-container fluid class="provably-fair-bg" style="margin: 40px 0px 0px 0px; max-width: 100% !important;">
    <v-row align="center" justify="center" class="darken-50" style="height: 350px;">
      <v-col class="text-center">
        <div class="d-inline-flex align-center mb-5 font-weight-bold">
          <svg class="mr-5" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 256 256">
            <path fill="#F6B605"
              d="M225.86 102.82c-3.77-3.94-7.67-8-9.14-11.57c-1.36-3.27-1.44-8.69-1.52-13.94c-.15-9.76-.31-20.82-8-28.51s-18.75-7.85-28.51-8c-5.25-.08-10.67-.16-13.94-1.52c-3.56-1.47-7.63-5.37-11.57-9.14C146.28 23.51 138.44 16 128 16s-18.27 7.51-25.18 14.14c-3.94 3.77-8 7.67-11.57 9.14c-3.25 1.36-8.69 1.44-13.94 1.52c-9.76.15-20.82.31-28.51 8s-7.8 18.75-8 28.51c-.08 5.25-.16 10.67-1.52 13.94c-1.47 3.56-5.37 7.63-9.14 11.57C23.51 109.72 16 117.56 16 128s7.51 18.27 14.14 25.18c3.77 3.94 7.67 8 9.14 11.57c1.36 3.27 1.44 8.69 1.52 13.94c.15 9.76.31 20.82 8 28.51s18.75 7.85 28.51 8c5.25.08 10.67.16 13.94 1.52c3.56 1.47 7.63 5.37 11.57 9.14c6.9 6.63 14.74 14.14 25.18 14.14s18.27-7.51 25.18-14.14c3.94-3.77 8-7.67 11.57-9.14c3.27-1.36 8.69-1.44 13.94-1.52c9.76-.15 20.82-.31 28.51-8s7.85-18.75 8-28.51c.08-5.25.16-10.67 1.52-13.94c1.47-3.56 5.37-7.63 9.14-11.57c6.63-6.9 14.14-14.74 14.14-25.18s-7.51-18.27-14.14-25.18m-52.2 6.84l-56 56a8 8 0 0 1-11.32 0l-24-24a8 8 0 0 1 11.32-11.32L112 148.69l50.34-50.35a8 8 0 0 1 11.32 11.32" />
          </svg>
          <h3 class="text-h5 text-sm-h4 " style="font-family: var(--heading-font), sans-serif !important;">
            <div class="provably-fair">
              {{ $t('Provably fair') }}
            </div>
          </h3>
        </div>
        <div class="title font-weight-thin mb-5 description-fair">
          {{ $t('All our games are provably fair.') }}
          {{ $t('We do not cheat.') }}
        </div>
        <div class="text-center ">
          <v-btn :to="{ name: 'page', params: { id: 'provably-fair' } }" class="btn-border" outlined>
            <span class="text-gold-gradient-to-bottom v-btn-learnmore text-uppercase">{{ $t('Learn more') }}</span>
          </v-btn>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<style lang="scss" scoped>
.darken-50 {
  background: rgba(0, 0, 0, 0.5);
}

.provably-fair-bg {
  background-image: url('/images/home/provably-fair.webp') !important;
  background-size: cover;
  background-position: center center !important;
}

.provably-fair {
  font-size: 36px;
  line-height: 40px;
  letter-spacing: 0.25px;
  font-weight: 700;
}

.description-fair {
  font-size: 19px;
  line-height: 32px;
  letter-spacing: 0.25px;
}

.v-btn:before {
  background-color: transparent !important;
}

.btn-border {
  padding: 0.5rem;
  border: double 1px transparent;
  border-radius: 6px;
  background-image: linear-gradient(#1e1e1e, #1e1e1e),
    linear-gradient(16deg, #faeb06, #f5b105);
  background-origin: border-box;
  background-clip: padding-box, border-box;
}

.v-btn-learnmore {
  font-family: 'Gilroy-Bold', sans-serif !important;
  font-size: 14px !important;
  font-weight: 600 !important;
  line-height: 20px !important;
  letter-spacing: 0.1px !important;

}

.text-gold-gradient-to-bottom {
  background: linear-gradient(to bottom, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
}

@media screen and (max-width: 768px) {
  .provably-fair {
    font-size: 30px !important;
    line-height: 40px !important;
    letter-spacing: 0.25px !important;
  }

  .description-fair {
    font-size: 14px !important;
    line-height: 28px !important;
    letter-spacing: 0.25px !important;
    width: 59%;
    margin: 0 auto;
  }

  .provably-fair-bg {
    background-size: 345%;
    background-position: 52% 52% !important;
  }
}
</style>
