<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center" style="overflow: auto;">
      <v-col cols="12" sm="8" md="6" lg="5" class="config-display-size">
        <v-card class="elevation-12">
          <v-toolbar class="">
            <!-- <router-link :to="{ name: 'home' }">
              <v-avatar size="40" tile>
                <v-img :src="appLogoUrl" />
              </v-avatar>
            </router-link> -->
            <!-- <v-spacer /> -->
            <v-toolbar-title class="ml-2 v-toolbar-title">
              {{ $t("Top up Credit") }}
            </v-toolbar-title>
            <!-- <v-spacer /> -->
          </v-toolbar>
          <v-card-text class="card-text-style">
            <v-form v-if="emailAuth" v-model="formIsValid" @submit.prevent="topup">
              <v-row>
                <v-col cols="12" sm="10">
                  <v-row>
                    <v-col>
                      <div class="text-subtitle-style-linear mt-3">
                        Amount
                      </div>
                      <v-text-field hide-details height="61" class="text-field-amount" color="yellow"
                        v-model="form.amount" type="text" name="amount" id="amount" :value="form.amount"
                        :rules="[validationRequired]" :error="form.errors.has('amount')"
                        :error-messages="form.errors.get('amount')" outlined @keydown="clearFormErrors"
                        @keypress="isNumber($event)" />
                      <p v-if="(form.amount === null || form.amount === '' || !form.amount) && isErrorMessage"
                        class="alert-style mb-2">Please require Amount
                        <v-icon>mdi-alert-circle</v-icon>
                      </p>
                      <v-row dense class="row-amount-style">
                        <v-col cols="auto" class="col-amount-style">
                          <v-btn outlined class="btn-v" @click="SetAmount(10)">10</v-btn>
                        </v-col>
                        <v-col cols="auto" class="col-amount-style">
                          <v-btn outlined class="btn-v" @click="SetAmount(50)">50</v-btn>
                        </v-col>
                        <v-col cols="auto" class="col-amount-style">
                          <v-btn outlined class="btn-v" @click="SetAmount(100)">100</v-btn>
                        </v-col>
                        <v-col cols="auto" class="col-amount-style">
                          <v-btn outlined class="btn-v" @click="SetAmount(500)">500</v-btn>
                        </v-col>
                        <v-col cols="auto" class="col-amount-style">
                          <v-btn outlined class="btn-v" @click="SetAmount(1000)">1000</v-btn>
                        </v-col>
                        <v-col cols="auto" class="col-amount-style">
                          <v-btn outlined class="btn-v" @click="SetAmount(2500)">2500</v-btn>
                        </v-col>
                        <v-col cols="auto" class="col-amount-style">
                          <v-btn outlined class="btn-v" @click="SetAmount(5000)">5000</v-btn>
                        </v-col>
                      </v-row>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="10">
                  <v-row>
                    <v-col class="pt-7">
                      <div class="text-subtitle-style-linear">
                        Credit Card information
                      </div>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col class="pb-0">
                      <div class="text-subtitle-style" style="opacity: 0.5;">Name on Card</div>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col class="pt-0">
                      <v-text-field height="61" color="yellow" class="text-field-Name" v-model="form.card_name"
                        :label="$t('')" name="card_name" maxlength="150" outlined @keydown="clearFormErrors" />
                      <p v-if="(form.card_name === null || form.card_name === '' || !form.card_name) && isErrorMessage"
                        class="alert-style mb-2">Please require Name on card
                        <v-icon>mdi-alert-circle</v-icon>
                      </p>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12">
                  <v-row>
                    <v-col>
                      <v-row>
                        <v-col cols="9" sm="9" md="9" lg="9" class="py-0">
                          <div class="text-subtitle-style text-medium-emphasis mb-0" style="opacity: 0.5;">Card Number
                          </div>
                        </v-col>
                        <v-col cols="3" sm="3" md="3" lg="3" class="py-0 pl-0 show-mobile-size">
                          <div class="text-subtitle-style text-medium-emphasis mb-0" style="opacity: 0.5;">CVC</div>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="9" sm="9" md="7" lg="7">
                          <v-text-field height="61" color="yellow" mask="###.###.###-##" class="text-field-card mb-0"
                            name="card_number" maxlength="16" v-model="form.card_number"
                            placeholder="XXXX - XXXX - XXXX - XXXX" :label="$t('')" outlined @keydown="clearFormErrors"
                            @keypress="isNumber($event)" />
                          <p v-if="(form.card_number === null || form.card_number === '' || form.card_number.toString().length !== 16 || !form.card_number) && isErrorMessage"
                            class="alert-style my-2">Please require Card number
                            <v-icon>mdi-alert-circle</v-icon>
                          </p>
                          
                        </v-col>
                        <v-col cols="3" sm="3" md="3" lg="3" class="show-mobile-size pl-0">
                          <v-text-field height="61" v-model="form.cvc" color="yellow" outlined placeholder="XXX"
                            class="text-center mb-0" maxlength="3" @keydown="clearFormErrors"
                            @keypress="isNumber($event)" />
                            <p v-if="(form.cvc === null || form.cvc === '' || !form.cvc || form.cvc.toString().length !== 3) && isErrorMessage"
                            class="alert-style my-2 show-mobile-size" style="position: relative !important;">
                            <span>Please</span>
                            <span>require CVC</span>
                            <v-icon class="icon-style">mdi-alert-circle</v-icon>
                          </p>
                        </v-col>
                        <v-col cols="1" sm="1" md="1" lg="1" class="svg-mr pt-5 pr-0">
                          <svg class="ml-2" xmlns="http://www.w3.org/2000/svg" width="55" height="21"
                            viewBox="0 0 55 19" fill="none" @click="SetCardType('Master')">
                            <path
                              d="M50.7156 17.9467L50.2044 15.3791H44.4666L43.5537 17.9284L38.9548 17.9376C41.9104 10.8327 44.106 5.57192 45.537 2.15071C45.9113 1.25604 46.5755 0.799571 47.5546 0.806417C48.3032 0.813264 49.5242 0.813263 51.22 0.808699L54.7759 17.9399L50.7156 17.9467ZM45.7584 11.862H49.4558L48.075 5.42585L45.7584 11.862ZM16.1132 0.804134L20.7372 0.808699L13.589 17.949L8.90793 17.9444C7.73082 13.417 6.56835 8.8858 5.42053 4.35087C5.1923 3.44707 4.7404 2.81487 3.87083 2.51588C2.58664 2.08546 1.29623 1.67383 0 1.28114L0 0.808699H7.3879C8.666 0.808699 9.41232 1.42721 9.65197 2.69619C9.89389 3.96744 10.501 7.20607 11.4778 12.4052L16.1132 0.804134ZM27.0912 0.808699L23.4372 17.9467L19.0346 17.9399L22.6863 0.804134L27.0912 0.808699ZM36.0151 0.491455C37.332 0.491455 38.9913 0.902274 39.9453 1.28114L39.1739 4.83244C38.3112 4.48553 36.8915 4.01765 35.6979 4.03363C33.9633 4.0633 32.8906 4.79136 32.8906 5.48976C32.8906 6.62636 34.753 7.19922 36.6702 8.4408C38.8566 9.85585 39.1465 11.1271 39.1191 12.5102C39.0894 15.3745 36.6702 18.2023 31.5669 18.2023C29.2389 18.1681 28.399 17.9741 26.5001 17.2985L27.3035 13.592C29.2366 14.4 30.056 14.6579 31.7084 14.6579C33.2216 14.6579 34.5202 14.0462 34.5316 12.9804C34.5408 12.2226 34.0752 11.846 32.3771 10.9103C30.6791 9.97225 28.2963 8.67588 28.3283 6.06718C28.3671 2.73042 31.5281 0.491455 36.0151 0.491455Z"
                              fill="white" />
                          </svg>
                        </v-col>
                        <v-col cols="4" sm="4" md="4" lg="4" class="pt-4 pl-9">
                          <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="42" height="30"
                            viewBox="0 0 44 29" fill="none" @click="SetCardType('Visa')">
                            <g clip-path="url(#clip0_472_48107)">
                              <path
                                d="M40.2739 28.5556H3.70735C2.96134 28.5556 2.24589 28.2593 1.71839 27.7318C1.19088 27.2043 0.894531 26.4888 0.894531 25.7428L0.894531 3.24031C0.894531 2.4943 1.19088 1.77885 1.71839 1.25134C2.24589 0.72384 2.96134 0.42749 3.70735 0.42749L40.2739 0.42749C41.0199 0.42749 41.7354 0.72384 42.2629 1.25134C42.7904 1.77885 43.0868 2.4943 43.0868 3.24031V25.7428C43.0868 26.4888 42.7904 27.2043 42.2629 27.7318C41.7354 28.2593 41.0199 28.5556 40.2739 28.5556ZM34.278 23.5383H34.2616C34.1012 23.5381 33.9426 23.5713 33.7957 23.6356C33.6488 23.7 33.5169 23.7942 33.4083 23.9122L33.4072 23.9133C33.1762 24.1662 33.0483 24.4964 33.0485 24.8389C33.0487 25.1813 33.1771 25.5113 33.4083 25.7639L33.4072 25.7628C33.6205 25.9936 33.924 26.1378 34.2616 26.1378H34.278C34.429 26.1482 34.5791 26.1203 34.7165 26.0568C34.854 25.9933 34.9732 25.8962 35.0632 25.7745L35.0644 25.7721V26.0839H35.5953V22.6042H35.0644V23.9051C34.9779 23.7909 34.8661 23.6982 34.7378 23.6343C34.6095 23.5705 34.4682 23.5372 34.3248 23.5371L34.2756 23.5383H34.278ZM29.2969 23.5383H29.27C28.9313 23.5383 28.6254 23.6789 28.4086 23.9051C28.1773 24.1616 28.0494 24.4947 28.0496 24.84C28.0498 25.1853 28.1781 25.5183 28.4097 25.7745L28.4086 25.7733C28.6265 25.9995 28.9324 26.1401 29.2711 26.1401H29.2993L29.3508 26.1413C29.4903 26.1414 29.6278 26.1083 29.7519 26.0447C29.876 25.9812 29.9832 25.8889 30.0646 25.7756L30.0669 25.7733V26.0851H30.6178V23.6121H30.0681V23.9051C29.9794 23.7856 29.8626 23.6897 29.7282 23.6257C29.5937 23.5617 29.4457 23.5317 29.2969 23.5383ZM26.8967 23.5383L26.8474 23.5371C26.5024 23.5371 26.1715 23.6742 25.9275 23.9181C25.6836 24.1621 25.5465 24.493 25.5465 24.838C25.5465 25.1831 25.6836 25.514 25.9275 25.7579C26.1715 26.0019 26.5024 26.139 26.8474 26.139L26.899 26.1378H26.8967L26.9447 26.139C27.2612 26.139 27.5506 26.0288 27.7792 25.8436L27.7768 25.846L27.5202 25.4065C27.3507 25.5406 27.1431 25.6177 26.9271 25.6268H26.9248C26.8171 25.6337 26.7091 25.6176 26.6081 25.5796C26.5071 25.5416 26.4153 25.4826 26.3388 25.4065C26.2026 25.2486 26.1278 25.0469 26.128 24.8384C26.1282 24.6299 26.2035 24.4284 26.34 24.2708L26.3388 24.272C26.4056 24.2022 26.4858 24.1468 26.5747 24.1089C26.6635 24.071 26.7591 24.0515 26.8556 24.0516H26.8803H26.8791C27.1122 24.0522 27.3385 24.1301 27.5225 24.2731L27.5202 24.2708L27.7768 23.8313C27.5346 23.6399 27.2347 23.5362 26.926 23.5371L26.8967 23.5383ZM22.1149 23.5383H22.0856C21.9264 23.538 21.7688 23.5704 21.6227 23.6335C21.4765 23.6966 21.3448 23.7891 21.2359 23.9051C21.119 24.0313 21.028 24.1792 20.9683 24.3405C20.9086 24.5017 20.8812 24.6732 20.8878 24.8451V24.8427L20.8866 24.8966C20.8866 25.2424 21.0237 25.5565 21.2453 25.7862C21.4679 26.0077 21.775 26.1437 22.1137 26.1437L22.1536 26.1425H22.1512L22.1993 26.1437C22.5661 26.1437 22.9013 26.0112 23.1615 25.7921L23.1591 25.7944L22.9025 25.3924C22.7058 25.5667 22.4527 25.6641 22.1899 25.6666C22.0115 25.6821 21.8329 25.6282 21.6932 25.5163C21.5536 25.4043 21.4624 25.2428 21.4386 25.0654V25.0619H23.2881V24.8427C23.3045 24.4967 23.1855 24.1579 22.9564 23.8981L22.9576 23.8993C22.8546 23.7851 22.7287 23.6939 22.5882 23.6315C22.4477 23.5691 22.2956 23.5369 22.1418 23.5371H22.1161L22.1149 23.5383ZM18.5086 23.6121V24.1067H19.0208V25.2248C19.0208 25.8319 19.3103 26.1401 19.881 26.1401H19.901C20.1377 26.1401 20.3569 26.0698 20.5409 25.9503L20.5362 25.9526L20.3885 25.4944C20.2431 25.5764 20.0796 25.6207 19.9127 25.6233C19.6806 25.6233 19.5623 25.4885 19.5623 25.2213V24.1079H20.4413V23.6133H19.5623V22.8632H19.0126V23.6133L18.5086 23.6121ZM16.2033 25.4053L15.9654 25.8272C16.2548 26.0229 16.6111 26.139 16.9944 26.139H17.0295H17.0272L17.1046 26.1413C17.3847 26.1413 17.646 26.0581 17.8652 25.9151L17.8593 25.9186C17.9524 25.8553 18.0286 25.7702 18.0813 25.6707C18.1339 25.5713 18.1616 25.4604 18.1617 25.3479V25.3315C18.1617 24.9189 17.8722 24.6763 17.3014 24.6001L17.046 24.5626C16.7647 24.5146 16.624 24.429 16.624 24.3071C16.624 24.1243 16.7776 24.0329 17.0823 24.0329H17.0881C17.3753 24.0329 17.6448 24.1079 17.8781 24.2391L17.8699 24.2345L18.0902 23.795C17.785 23.6134 17.4336 23.5242 17.0788 23.5383H17.0823L17.019 23.5371C16.771 23.5367 16.5293 23.6151 16.3287 23.761L16.3322 23.7586C16.2466 23.8253 16.1774 23.9106 16.1299 24.0081C16.0824 24.1056 16.0577 24.2127 16.0579 24.3212V24.3458V24.3446C16.0579 24.7454 16.3474 24.9857 16.9182 25.0584L17.1561 25.0959C17.4479 25.1451 17.5956 25.2307 17.5956 25.3526C17.5956 25.5588 17.4081 25.6643 17.0272 25.6643H17.0167C16.7235 25.6649 16.4375 25.574 16.1986 25.4041L16.2033 25.4076V25.4053ZM14.1148 23.5371H14.0855C13.9264 23.5368 13.7691 23.5693 13.6231 23.6324C13.4771 23.6955 13.3457 23.7879 13.2369 23.9039C13.0113 24.1633 12.8871 24.4956 12.8873 24.8394C12.8875 25.1832 13.0121 25.5154 13.2381 25.7745L13.2369 25.7733C13.3459 25.8894 13.4775 25.9818 13.6237 26.0449C13.7699 26.108 13.9274 26.1404 14.0866 26.1401H14.1171C14.2681 26.1481 14.4177 26.1191 14.5549 26.0556C14.6922 25.9921 14.8119 25.896 14.9035 25.7756L14.9047 25.7733V26.0851H15.4356V23.6121H14.9047V23.9051C14.8116 23.7904 14.6941 23.6979 14.5606 23.6344C14.4272 23.571 14.2813 23.5381 14.1335 23.5383L14.1148 23.5371ZM31.3292 23.6109V26.0839H31.8601V24.6927C31.8601 24.2684 32.0383 24.0528 32.391 24.0528H32.4028C32.5188 24.0528 32.6289 24.0798 32.7262 24.1278L32.7215 24.1255L32.8856 23.6121C32.7758 23.563 32.6567 23.5378 32.5364 23.5383L32.4989 23.5395H32.5012H32.4813C32.3551 23.5394 32.2312 23.573 32.1224 23.6369C32.0136 23.7008 31.9239 23.7926 31.8625 23.9028L31.8601 23.9063V23.6133L31.3292 23.6109ZM23.8401 23.6109V26.0839H24.3897V24.6927C24.3897 24.2684 24.5679 24.0528 24.9207 24.0528H24.9324C25.0484 24.0528 25.1586 24.0798 25.2559 24.1278L25.2512 24.1255L25.4164 23.6121C25.3016 23.563 25.178 23.5378 25.0531 23.5383H25.0308H25.0109C24.8849 23.5382 24.7611 23.5718 24.6525 23.6357C24.5439 23.6996 24.4544 23.7914 24.3933 23.9016L24.3909 23.9051V23.6121L23.8401 23.6109ZM11.3137 24.0505C11.6782 24.0505 11.8633 24.272 11.8633 24.7068V26.0804H12.413V24.5239L12.4142 24.4853C12.4144 24.2379 12.3186 24.0001 12.147 23.8219C11.9535 23.6408 11.6982 23.5402 11.4332 23.5406H11.4227C11.2537 23.5298 11.085 23.5645 10.934 23.6412C10.7831 23.7179 10.6556 23.8337 10.5648 23.9766L10.5624 23.9801C10.4795 23.837 10.3582 23.7199 10.2121 23.6422C10.0661 23.5645 9.90119 23.5293 9.73615 23.5406H9.73849H9.72794C9.59028 23.5407 9.45465 23.5738 9.33248 23.6373C9.21031 23.7007 9.10516 23.7926 9.02591 23.9051L9.02357 23.9075V23.6145H8.47624V26.0874H9.02591V24.7115C9.02591 24.2743 9.22984 24.0551 9.63067 24.0551C9.99516 24.0551 10.1803 24.2766 10.1803 24.7115V26.0851H10.7113V24.7115C10.7113 24.2731 10.9152 24.0551 11.3148 24.0551L11.3137 24.0505ZM27.7405 2.7715H27.7018C25.8691 2.76856 24.078 3.31833 22.5626 4.34902L22.5942 4.3291C24.1244 5.5695 25.2498 7.23805 25.8266 9.12143L25.8454 9.19175C26.122 10.0649 26.2802 11.0681 26.2802 12.1101C26.2802 13.1402 26.1243 14.1329 25.836 15.0682L25.8548 14.9979C25.2921 16.8998 24.1609 18.584 22.613 19.8242L22.5942 19.8394C24.1139 20.8589 25.9036 21.4009 27.7335 21.3959C29.0461 21.3959 30.2943 21.1228 31.4253 20.6305L31.3655 20.654C33.5823 19.7254 35.3507 17.9705 36.2962 15.7608L36.3184 15.7011C36.7872 14.6346 37.0603 13.3911 37.0603 12.0843C37.0603 10.7775 36.7872 9.53398 36.295 8.40885L36.3184 8.46745C35.3888 6.24869 33.6298 4.48044 31.4159 3.53917L31.3561 3.5169C30.2189 3.02357 28.9919 2.77098 27.7522 2.77502H27.7393L27.7405 2.7715ZM16.2408 2.7715H16.2279C14.9673 2.76998 13.7202 3.03019 12.5654 3.53565L12.624 3.51221C10.4018 4.43644 8.6287 6.19232 7.68279 8.40534L7.66052 8.46511C7.19172 9.53164 6.91864 10.7751 6.91864 12.0819C6.91864 13.3887 7.19172 14.6322 7.68396 15.7573L7.66052 15.6987C8.58912 17.9155 10.344 19.6839 12.5537 20.6294L12.6134 20.6516C13.6846 21.1204 14.934 21.3935 16.2455 21.3935C18.0884 21.3967 19.89 20.8472 21.4175 19.816L21.3847 19.8371C19.8464 18.6024 18.7165 16.9321 18.1429 15.0448L18.1254 14.9756C17.8417 14.0414 17.6991 13.07 17.7023 12.0936C17.7008 10.6103 18.029 9.14521 18.663 7.80422C19.297 6.46322 20.221 5.27985 21.3683 4.33965L21.3859 4.32558C19.8784 3.3064 18.0992 2.76411 16.2795 2.76916H16.2373H16.2396L16.2408 2.7715ZM21.9906 4.76743C20.5097 5.91199 19.4162 7.48383 18.8579 9.27028L18.8403 9.33474C18.5578 10.229 18.4155 11.1617 18.4184 12.0995C18.4184 13.077 18.5696 14.0181 18.8497 14.9029L18.8321 14.8373C19.3787 16.6426 20.4756 18.232 21.9696 19.3835L21.9906 19.3988C23.4785 18.2613 24.5764 16.69 25.1328 14.9018L25.1504 14.8385C25.4276 13.952 25.5672 13.0283 25.5641 12.0995C25.5641 11.1115 25.4094 10.161 25.1246 9.26793L25.1422 9.33357C24.5925 7.53026 23.4997 5.94055 22.0129 4.78149L21.9918 4.76626L21.9906 4.76743ZM34.3506 25.6256H34.3307C34.233 25.6257 34.1364 25.6054 34.047 25.566C33.9576 25.5267 33.8774 25.4691 33.8115 25.3971C33.6749 25.2426 33.5996 25.0434 33.5998 24.8372C33.6 24.631 33.6758 24.432 33.8127 24.2778L33.8115 24.279C33.8814 24.2062 33.9653 24.1482 34.0581 24.1087C34.151 24.0691 34.2509 24.0487 34.3518 24.0487C34.4527 24.0487 34.5526 24.0691 34.6455 24.1087C34.7383 24.1482 34.8222 24.2062 34.8921 24.279C35.0283 24.4351 35.1032 24.6352 35.103 24.8424C35.1028 25.0495 35.0274 25.2495 34.8909 25.4053L34.8921 25.4041C34.8249 25.4743 34.7441 25.5302 34.6546 25.5682C34.5652 25.6063 34.4689 25.6258 34.3717 25.6256H34.3506ZM29.352 25.6256H29.3262C29.2315 25.6256 29.1378 25.6062 29.0509 25.5685C28.964 25.5308 28.8858 25.4756 28.8211 25.4065C28.6896 25.2461 28.6179 25.0452 28.6181 24.8378C28.6183 24.6305 28.6905 24.4297 28.8223 24.2696L28.8211 24.2708C28.8856 24.2012 28.9637 24.1457 29.0506 24.1078C29.1376 24.0699 29.2314 24.0504 29.3262 24.0505H29.3532H29.3731C29.5782 24.0505 29.7634 24.1384 29.8911 24.279C30.0224 24.4208 30.1021 24.6107 30.1021 24.8193V24.8427V24.8416L30.1033 24.8732C30.1036 25.0713 30.0315 25.2626 29.9005 25.4111L29.9017 25.41C29.8354 25.4784 29.7559 25.5328 29.6682 25.5698C29.5804 25.6069 29.486 25.6259 29.3907 25.6256L29.3508 25.6245H29.3532L29.352 25.6256ZM14.1886 25.6256L14.1546 25.6268C14.0584 25.627 13.9631 25.6076 13.8746 25.5697C13.7861 25.5318 13.7063 25.4763 13.6401 25.4065C13.5087 25.2461 13.4369 25.0452 13.4371 24.8378C13.4373 24.6305 13.5095 24.4297 13.6413 24.2696L13.6401 24.2708C13.7109 24.1966 13.7969 24.1387 13.8921 24.1008C13.9874 24.063 14.0897 24.0462 14.1921 24.0516H14.2179C14.3134 24.0515 14.4077 24.0718 14.4947 24.1113C14.5816 24.1507 14.6591 24.2083 14.7219 24.2802L14.723 24.2813C14.8532 24.4402 14.9243 24.6393 14.9241 24.8447C14.9239 25.0501 14.8524 25.2491 14.7219 25.4076L14.723 25.4065C14.6582 25.4761 14.5796 25.5317 14.4923 25.5696C14.405 25.6075 14.3108 25.627 14.2156 25.6268H14.1898H14.1909L14.1886 25.6256ZM22.7407 24.6177H21.4597C21.4761 24.4592 21.5505 24.3124 21.6687 24.2056C21.7869 24.0987 21.9404 24.0394 22.0998 24.0392C22.2591 24.0389 22.4129 24.0976 22.5314 24.204C22.65 24.3104 22.725 24.4569 22.7419 24.6154V24.6177H22.7407Z"
                                fill="white" />
                            </g>
                            <defs>
                              <clipPath id="clip0_472_48107">
                                <rect width="42.1922" height="28.1282" fill="white"
                                  transform="translate(0.894531 0.42749)" />
                              </clipPath>
                            </defs>
                          </svg>
                        </v-col>
                      </v-row>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="8">
                  <v-row>
                    <v-col>
                      <div class="text-subtitle-style text-medium-emphasis" style="opacity: 0.5;">
                        Expiration Date
                      </div>
                      <v-row dense class="row-exp-date">
                        <v-col>
                          <v-select class="select-date" height="61" v-model="form.month" :items="month" :label="$t('Month')"
                            outlined @change="SetExpiredateMonth"></v-select>
                          <p v-if="(form.month === null || !form.month) && isErrorMessage"
                            class="alert-style  my-2">Please require month
                            <v-icon>mdi-alert-circle</v-icon>
                          </p>
                        </v-col>
                        <v-col>
                          <v-select class="select-date" height="61" v-model="form.year" :items="year" :label="$t('Year')"
                            outlined @change="SetExpiredateYear"></v-select>
                          <p v-if="(form.year === null || !form.year) && isErrorMessage"
                            class="alert-style  my-2">
                            Please require year
                            <v-icon>mdi-alert-circle</v-icon>
                          </p>
                        </v-col>
                      </v-row>
                    </v-col>
                  </v-row>
                </v-col>
                <v-col cols="4" class="hide-mobile-size">
                  <v-row>
                    <v-col>
                      <div class="text-subtitle-style text-medium-emphasis" style="opacity: 0.5;">CVC</div>
                      <v-row dense>
                        <v-col>
                          <v-text-field class="mb-1" height="61" v-model="form.cvc" color="yellow" outlined
                            placeholder="XXX" maxlength="3" @keydown="clearFormErrors" @keypress="isNumber($event)" />
                          <p v-if="(form.cvc === null || form.cvc === '' || !form.cvc || form.cvc.toString().length !== 3) && isErrorMessage"
                            class="alert-style mb-2">Please require CVC
                            <v-icon>mdi-alert-circle</v-icon>
                          </p>
                        </v-col>
                      </v-row>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>

              <v-row align="center">
                <v-col class="text-end text-md-right">
                  <router-link class="text-gold-gradient mr-3 cancle-btm-style" :to="{ name: 'register' }">
                    {{ $t("Cancel") }}
                  </router-link>
                  <v-btn type="submit" color="primary" class="gold-gradient text-black confirm-btm-style"
                    :loading="loading">
                    {{ $t("Confirm") }}
                  </v-btn>
                </v-col>
                <!-- 
                <v-col class="d-flex flex-column text-end text-md-right">
                  <router-link class="text-gold-gradient " :to="{ name: 'register' }">
                    {{ $t('Not signed up?') }}
                  </router-link>
                  <router-link :to="{ name: 'password.email' }">
                    {{ $t('Forgot password?') }}
                  </router-link>
                </v-col> -->
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from "axios";
import { config } from "~/plugins/config";
import Form from "vform";
import FormMixin from "~/mixins/Form";
import Oauth from "~/components/Oauth";
import Web3Auth from "~/components/Web3Auth";
import { mapState } from "vuex";
import VueRecaptcha from "vue-recaptcha";
import { mapGetters } from 'vuex'

export default {
  // components: { Web3Auth, Oauth, VueRecaptcha },
  mixins: [FormMixin],
  // middleware: "guest",
  metaInfo() {
    return {
      title: this.$t("Topup"),
    };
  },

  data() {
    return {
      year: [],
      month: [],
      loading: false,
      csrfCookieRetrieved: false,
      token: null,
      username: null,
      status: null,
      balance: null,
      isErrorMessage: false,
      form: new Form({
        amount: null,
        card_name: null,
        card_number: '',
        month: null,
        year: null,
        expiration_date: null,
        type: 'Master',
        cvc: null,
        balance: null,
        status: 'topup'
      }),
    };
  },
  created() {

    this.year = ['2024', '2025', '2026', '2027', '2028', '2029', '2030']
    this.month = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]

    console.log('topup');
    console.log('authenticated:' + this.authenticated);

    if (this.authenticated) {
      // update user balance
      this.$store.dispatch('auth/fetchUser')
    }

  },
  computed: {
    ...mapGetters({ authenticated: 'auth/check' }),
    ...mapState("auth", ["user"]),
    appLogoUrl() {
      return config("app.logo");
    },
    emailAuth() {
      return config("settings.users.email_auth");
    },
    recaptchaPublicKey() {
      return config("services.recaptcha.public_key");
    },
  },

  methods: {
    async topup() {

      this.loading = true;

      // if (!this.csrfCookieRetrieved) {
      //   await axios.get("/sanctum/csrf-cookie");
      //   this.csrfCookieRetrieved = true;
      // }
     
      console.log('year', this.form.year);
      console.log('month', this.form.month);
      if (this.form.amount > 0 && this.form.card_name && this.form.card_number && this.form.expiration_date && this.form.cvc && this.form.type && this.form.year && this.form.month && this.form.card_number.toString().length === 16 && this.form.cvc.toString().length === 3 ) {
        this.isErrorMessage = false
        const { data } = await this.form.post("/api/topup", {
          headers: {
            'Authorization': 'Bearer ' + this.token,
          }
        }).catch(() => {
          if (this.recaptchaPublicKey) {
            this.form.recaptcha = null;
            this.$refs.recaptcha.reset();
            this.loading = false;
          }
          return {};
        });

        // in case of any error data will be undefined
        if (data) {

          console.log('res:' + data);

          // this.$store.dispatch('message/success', { text: this.$t('Topup successfully!') })

          // this.$router.reload()
          this.$router.go(this.$router.currentRoute)
          // this.$router.push({ name: 'topup' })

          // Store the user
          // this.$store.dispatch("auth/updateUser", data);

        } else {

          // this.$store.dispatch('message/error', { text: data.errorMessages })
          // this.loading = false;
        }
      } else {
        this.isErrorMessage = true
        // this.$store.dispatch('message/error', { text: this.$t('Please enter all field!!!') })
      }
      this.loading = false;

    }, SetAmount(value) {

      this.form.amount = value
      this.form.balance = Number(this.balance) + value
    }, SetExpiredateMonth(e) {
      this.form.month = e
      this.form.expiration_date = this.form.year + ' ' + this.form.month
    },SetExpiredateYear(e) {
      this.form.year = e
      this.form.expiration_date = this.form.year + ' ' + this.form.month
    }, SetCardType(val) {

      this.form.type = val
      console.log('CardType:' + this.form.type);
    }, isNumber: function (evt) {
      evt = evt ? evt : window.event
      var charCode = evt.which ? evt.which : evt.keyCode

      if (charCode === 43) {
        // หยุดการทำงานของฟังก์ชันนี้และไม่ป้องกันการเกิดอีเวนต์
        return true;
      }

      if (
        charCode > 31 &&
        (charCode < 48 || charCode > 57) &&
        charCode !== 46
      ) {
        evt.preventDefault()
      } else {
        return true
      }
    },
  }, async mounted() {

    let image_url = 'https://bucket-dev.baanbaan.site'

    console.log('get me!!!');
    let cname = 'token'
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        this.token = c.substring(name.length, c.length);
      }
    }
    // console.log('token:' + this.token);

    if (this.token) {

      await axios.get('/api/auth/me', {
        headers: {
          'Authorization': 'Bearer ' + this.token,
        }
      }).then((response) => {

        // console.log('response:' + response);
        // console.log('response data:' + response.data);
        // console.log('code:' + response.data.code);

        if (response.data.code == 200) {

          this.username = response.data.data.username
          // this.form.name = response.data.data.name
          // this.form.avatar = image_url + response.data.data.avatar
          // this.contry_code = response.data.data.contry_code
          // this.contact = response.data.data.contact
          // this.ref_id = response.data.data.ref_id
          // this.status = response.data.data.status

          console.log('username:' + this.username);
          // console.log('name:' + this.form.name);
          // console.log('avatar:' + this.form.avatar);
          // console.log('status:' + this.status);

          this.$store.dispatch('auth/fetchUser')
          console.log('reload');

        } else {

          // this.$store.dispatch('message/error', { text: this.$t('Please login!!!') })
          this.$router.push({ name: 'home' })
        }

      }).catch((e) => {

        console.log(e)
        // this.$store.dispatch('message/error', { text: this.$t('Please login!!!') })
        this.$router.push({ name: 'home' })

      })

    }

  }
};
</script>
<style scoped>
/* ::v-deep .v-text-field .v-input__control {
  border: 1px solid;
  color: #c32b1f !important;
} */

.config-display-size {
  min-width: 647px;
  padding: 0px;
}

.btn-v {
  color: rgba(255, 255, 255, 0.24);
  height: 58px !important;
  min-width: 62.9296px !important;
  padding: 0px !important;
  opacity: 0.5;
}

.cancle-btm-style {
  font-family: 'Gilroy-SemiBold', sans-serif !important;
  font-size: 14px !important;
  line-height: 20px !important;
  font-weight: 400 !important;
  letter-spacing: 0.3px !important;
  align-items: center !important;
}

.confirm-btm-style {
  font-family: 'Gilroy-SemiBold', sans-serif !important;
  font-size: 14px !important;
  line-height: 20px !important;
  font-weight: 400 !important;
  font-style: normal;
  letter-spacing: 0.3px !important;
  align-items: center !important;
}

.text-subtitle-style {
  color: #FFF !important;
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-size: 16px !important;
  font-style: normal !important;
  font-weight: 400 !important;
  line-height: 18px !important;
  margin-bottom: 9px;
}

.text-subtitle-style-linear {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-size: 16px !important;
  line-height: 18px !important;
  font-weight: 400 !important;
  margin-bottom: 9px;
  background: linear-gradient(180deg, #FAEC06 0%, #F6B605 97%) !important;
  background-clip: text !important;
  color: transparent !important;
}

.v-toolbar-title {
  font-family: 'Orbitron', sans-serif !important;
  font-size: 20px !important;
  line-height: 30px !important;
  font-weight: 400 !important;
  background: linear-gradient(180deg, #FAEC06 0%, #F6B605 97%) !important;
  background-clip: text !important;
  color: transparent !important;
}

.row-amount-style {
  width: 505px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  gap: 8px;
}

.col-amount-style {
  width: 64.69px;
  height: 58.9px;
}

.col-amount-style ::v-deep .v-btn--outlined {
  border: 1.5px solid #4f4f529e;
}

.col-amount-style ::v-deep .v-btn--outlined span {
  color: white;
}

::v-deep .v-label {
  background: none;
  color: gray !important;
}

::v-deep .select-date {
  margin-bottom: 0px !important;
}

.text-field-amount {
  min-width: 505px;
  margin-bottom: 7px !important;
}

.text-field-Name {
  min-width: 505px;
  margin-bottom: 7px !important;
}

.text-field-card {
  max-width: 333px;
}

.show-mobile-size {
  display: none;
}

.hide-mobile-size {
  display: flex;
}

.alert-style {
  font-family: 'Gilroy-Medium', sans-serif !important;
  font-weight: 400 !important;
  font-size: 12px !important;
  line-height: 20px !important;
  color: #c32b1f;
}

.alert-style i {
  color: #c32b1f;
  font-size: 18px;
  padding-bottom: 0px;
}

.card-text-style {
  padding: 22px 22px 18px 22px;
}

.icon-style {
  position: absolute !important;
  right: -5px !important;
  top: 10px !important;
}

@media screen and (max-width: 768px) {
  .config-display-size {
    min-width: 390px  !important;
    max-width: 390px  !important;
    height: 765px;
    margin-top: 3rem;
  }

  .card-text-style {
    padding: 22px 14px 18px 14px;
  }

  .text-field-amount {
    min-width: 100% !important;
  }

  .text-field-Name {
    min-width: 100% !important;
  }

  .text-field-card {
    min-width: 100% !important;
  }

  .row-amount-style {
    width: 100% !important;
    flex-direction: row;
    justify-content: flex-start !important;
    flex-wrap: wrap;
  }

  .show-mobile-size {
    display: flex;
    flex-direction: column;
  }

  .hide-mobile-size {
    display: none;
  }

  .row-exp-date {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .svg-mr {
    margin-right: 2rem;
  }
}
</style>
