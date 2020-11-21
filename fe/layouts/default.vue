<template>
  <v-app>
    <v-system-bar app class="grey" fixed>
      <v-spacer /><span class="white--text"
        >&lt;POC for PostgreSQL Connection with Vue-Php&gt; </span
      ><v-spacer />
    </v-system-bar>
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
      <v-chip
        href="#"
        @focus="alertForPopUps"
        @mouseover="alertForPopUps"
        @click.prevent="openWindows"
      >
        TechStack
      </v-chip>
    </v-footer>
    <v-snackbar
      v-model="snackbar.display"
      :color="snackbar.color"
      timeout="2000"
      right
      dense
      rounded="pill"
      outlined
    >
      {{ snackbar.message }}
    </v-snackbar>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      snackbar: {
        display: false,
        message: '',
        color: '',
      },
    }
  },
  methods: {
    openWindows(clicked) {
      window.open('https://www.php.net/')
      window.open('https://www.nginx.com/')
      window.open('https://www.postgresql.org/')
      window.open('https://nuxtjs.org/')
      window.open('https://vuetifyjs.com/en/')
    },
    alertForPopUps() {
      this.snackbar.display = true
      this.snackbar.message = 'PLEASE MAKE SURE POP UPS ARE ALLOWED !!'
      this.snackbar.color = 'red'
    },
  },
}
</script>

<style></style>
