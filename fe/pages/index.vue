<template>
  <v-app>
    <v-main>
      <v-container>
        <h1
          class="text-md-h1 text-sm-h4 border font-weight-bold text-center ma-md-10 ma-sm-3"
        >
          School Manager
        </h1>
        <v-divider></v-divider>
        <v-row justify="center">
          <v-col cols="12" sm="10" md="6" lg="5" justify="center">
            <v-btn block href="/student"> STUDENT </v-btn>
            <v-list two-line>
              <v-list-item>
                <v-list-item-title> Registered </v-list-item-title>
                <v-list-item-subtitle> 20 </v-list-item-subtitle>
              </v-list-item>
              <v-list-item>
                <v-list-item-title> Present </v-list-item-title>
                <v-list-item-subtitle> 30 </v-list-item-subtitle>
              </v-list-item>
              <v-list-item>
                <v-list-item-title> Absent </v-list-item-title>
                <v-list-item-subtitle> 40 </v-list-item-subtitle>
              </v-list-item>
            </v-list>
          </v-col>
          <v-col cols="12" sm="10" md="6" lg="5" justify="center">
            <v-btn block href="/teacher"> TEACHER </v-btn>
            <v-list two-line>
              <v-list-item>
                <v-list-item-title> Registered </v-list-item-title>
                <v-list-item-subtitle> 20 </v-list-item-subtitle>
              </v-list-item>
              <v-list-item>
                <v-list-item-title> Present </v-list-item-title>
                <v-list-item-subtitle> 30 </v-list-item-subtitle>
              </v-list-item>
              <v-list-item>
                <v-list-item-title> Absent </v-list-item-title>
                <v-list-item-subtitle> 40 </v-list-item-subtitle>
              </v-list-item>
            </v-list>
          </v-col>
        </v-row>
        <v-row>
          <v-btn block> CLEAR DATA (are you sure)</v-btn>
          <v-btn block> CLASS VIEW </v-btn>
        </v-row>
        <v-divider></v-divider>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {}
</script>
