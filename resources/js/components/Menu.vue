<template>
  <div>
            <!--UNLOGGED-->
            <span v-if="!$auth.check()" v-for="(route, key) in routes.unlogged" v-bind:key="route.path">
                <router-link  :to="{ name : route.path }" :key="key">
                    {{route.name}}
                </router-link>
            </span>
            <!--LOGGED Admin-->
            <span v-if="$auth.check()" v-for="(route, key) in routes.user" v-bind:key="route.path">
                <router-link  :to="{ name : route.path }" :key="key">
                    {{route.name}} |
                </router-link>
            </span>
            <!--LOGOUT-->
            <span v-if="$auth.check()">
                <a href="#" @click.prevent="$auth.logout()">Logout</a>
            </span>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        routes: {
          // UNLOGGED
          unlogged: [
            {
              name: 'Admin Login',
              path: 'login'
            }
          ],
          // LOGGED ADMIN
          user: [
            {
              name: 'Dashboard',
              path: 'dashboard'
            }
          ],
        }
      }
    },
    mounted() {
      //
    }
  }
</script>
