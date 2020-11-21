<template>
  <v-app>
    <v-system-bar app class="grey" fixed> </v-system-bar>
    <v-main>
      <v-container>
        <nuxt />
      </v-container>
    </v-main>
    <v-footer app class="grey" fixed>
      <v-chip
        href="https://www.linkedin.com/in/nandeesh-gupta-05b43014a/"
        target="_blank"
      >
        Made by Nandeesh
      </v-chip>
      <v-spacer />
      <v-breadcrumbs>
        <v-breadcrumbs-item href="/"> HOME </v-breadcrumbs-item>
        <v-breadcrumbs-divider>|</v-breadcrumbs-divider>
        <v-breadcrumbs-item href="/student"> STUDENT </v-breadcrumbs-item>
        <v-breadcrumbs-divider>|</v-breadcrumbs-divider>
        <v-breadcrumbs-item href="/teacher"> TEACHER </v-breadcrumbs-item>
      </v-breadcrumbs>
      <v-spacer />
      <v-chip href="https://codetrophs.netlify.app/" target="_blank">
        Codetrophs {{ new Date().getFullYear() }}
      </v-chip>
    </v-footer>
  </v-app>
</template>

<script>
export default {}
</script>

<style></style>
