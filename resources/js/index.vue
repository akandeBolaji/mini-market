<template>
    <div id="main">
        <nav class="navbar navbar-light bg-light justify-content-between">
            <a class="navbar-brand h1">
                <router-link :to="{name: 'home'}">
                    Mini Market
                </router-link>
            </a>
            <navigationMenu class="mr-sm-2"></navigationMenu>
        </nav>
        <router-view></router-view>
    </div>
</template>
<script>
  import navigationMenu from './components/Menu.vue'
  export default {
    data() {
      return {
        //
      }
    },
    components: {
        navigationMenu
    }
  }
</script>
