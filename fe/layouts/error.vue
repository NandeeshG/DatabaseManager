<template>
  <v-app dark>
    <h1
      v-if="error.statusCode === 404"
      class="text-h1 border font-italic text-center ma-10 red--text"
    >
      {{ pageNotFound }}
    </h1>
    <h1 v-else class="text-h1 border font-italic text-center ma-10 red--text">
      {{ otherError }}
    </h1>
    <h3 class="text-h6 font-thin text-center ma-10 black--text">
      PLEASE NAVIGATE TO SOME OTHER LINK FROM BOTTOM OF THIS PAGE
    </h3>
  </v-app>
</template>

<script>
export default {
  layout: 'empty',
  props: {
    error: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      pageNotFound: '404 Not Found',
      otherError: 'An error occurred',
    }
  },
  head() {
    const title =
      this.error.statusCode === 404 ? this.pageNotFound : this.otherError
    return {
      title,
    }
  },
}
</script>

<style scoped>
h1 {
  font-size: 20px;
}
</style>
