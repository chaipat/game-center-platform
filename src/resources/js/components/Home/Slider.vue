<template>
  <v-container class="mt-10 position-relative container-style">
    <v-row>
      <v-col>
        <v-carousel :show-arrows="false" :touch="true" style="height: 300px; overflow: visible;">
          <v-carousel-item v-for="(item, i) in items" :key="i">
            <v-img :src="item.src" class="slide-image align-center text-center fill-height"
              style="height: 300px;"></v-img>
            <v-img :src="items[i++].src" class="slide-image-some align-center text-center fill-height"
              style="height: 300px;"></v-img>
          </v-carousel-item>
        </v-carousel>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { config } from "~/plugins/config";
import DeviceMixin from "~/mixins/Device";

export default {
  mixins: [DeviceMixin],
  data() {
    return {
      items: [
        {
          src: "images/slide.png",
        },
        {
          src: "images/slide.png",
        },
        {
          src: "images/slide.png",
        },
      ],
    };
  },
  computed: {
    slidesCount() {
      return this.slider ? this.slider.slides.length : 0;
    },
  },
};
</script>
<style lang="scss" scoped>
.darken-60 {
  background: rgba(0, 0, 0, 0.6);
}

.container-style {
  height: 350px !important;
}

.container-style ::v-deep .v-responsive__content {
  display: flex;
  gap: 9px;
}

.slide-image::v-deep {
  .v-responsive__content {
    height: 100%;
    border-radius: 14px;
  }
}

.slide-image {
  border-radius: 14px;
}

.slide-image-some {
  display: none;
}

::v-deep .v-carousel__controls {
  position: absolute;
  transform: translateY(125%);
}

::v-deep .v-carousel__controls .v-btn--icon.v-size--small {
  height: 0px !important;
  width: 8px !important;
  scale: 0.7;
}

::v-deep .v-carousel__controls button span i {
  color: #2C2C2C !important;
}

::v-deep .v-carousel__controls .v-item--active span i {
  background: linear-gradient(to right, #faeb06, #f5b105) !important;
  background-clip: text !important;
  color: transparent !important;
  opacity: 1 !important;
}

@media screen and (max-width: 768px) {
  .container-style {
    padding-right: 0px !important;
    height: 260px !important;
  }

  .slide-image {
    width: 332px !important;
    height: 249px !important;
    border-radius: 8.22px !important;
  }

  .slide-image-some {
    display: flex;
    width: 45px !important;
    height: 249px !important;
    border-radius: 8.22px !important;
  }

  .slide-image .v-responsive__content {
    height: 100%;
    border-radius: 8.22px;
  }

  ::v-deep .v-stepperff {
    padding: 0px !important;
  }

  ::v-deep .v-carousel__controls {
    position: absolute;
    transform: translateY(0%) !important;
  }
}
</style>
