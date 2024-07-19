<template>
  <v-container fluid class="mt-10">
    <v-row class="mb-8" align="center" justify="center">
      <v-col cols="auto">
        <v-img :src="appFullLogoUrl" width="300" />
      </v-col>
    </v-row>
    <v-row class="mb-10" align="center" justify="center">
      <v-btn class="mx-3" elevation="2" outlined rounded>Provably fair</v-btn>
      <v-btn class="mx-3" elevation="2" outlined rounded>Privacy policy</v-btn>
      <v-btn class="mx-3" 
      elevation="2" outlined rounded>Terms of use</v-btn>
    </v-row>
    <v-row>
      <v-divider class="mx-5"></v-divider>
    </v-row>
    <v-row>
      <v-col class="text-center">
        <v-tooltip v-for="(link, i) in links" :key="i" bottom>
          <template #activator="{ on }">
            <v-btn
              class="mx-2 my-4 my-lg-0"
              fab
              large
              :color="link.color"
              :href="link.url"
              target="_blank"
              v-on="on"
            >
              <v-icon color="grey lighten-5">
                {{ link.icon }}
              </v-icon>
            </v-btn>
          </template>
          <span>{{ $t(link.title) }}</span>
        </v-tooltip>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { config } from "~/plugins/config";

export default {
  computed: {
    links() {
      return config("settings.content.social");
    },
    appFullLogoUrl() {
      return config("app.full_logo");
    },
  },
};
</script>
