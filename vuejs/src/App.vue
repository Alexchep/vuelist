<template>
    <div id="app">
        <div id="nav"></div>
        <router-view/>
        <v-footer height="35px" dark inset app>
            <v-spacer></v-spacer>
            <div>&copy;<b> Alexchep {{ new Date().getFullYear() }}</b></div>
        </v-footer>
    </div>
</template>

<style lang="scss">
    html, body, #app {
      padding: 0;
      margin: 0;
      height: 100%;
    }

    * {
      box-sizing: border-box;
    }

    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

    #app {
      font-family: 'Roboto', sans-serif;
      background: url('assets/bg-img.jpg') repeat center center;
    }
</style>