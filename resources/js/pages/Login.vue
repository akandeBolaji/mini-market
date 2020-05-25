<template>
    <main class="container">
        <div class="row justify-content-center" style="height: 100vh">
            <section class="col-md-8">
            <div class="card card-default mt-5">
                <div class="card-header">Admin Login</div>
                <div class="card-body">
                    <div class="alert alert-danger" v-if="has_error">
                        <p>An error occured, please try again.</p>
                    </div>
                    <form autocomplete="off" @submit.prevent="login" method="post">
                        <div class="form-group">
                            <label for="InputEmail">Email address</label>
                            <input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" placeholder="test@theagromall.com" v-model="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password" v-model="password" required>
                        </div>
                        <button type="submit" :disabled='submit' class="btn btn-primary">
                            {{ submit ? "Sending..." :  "Submit" }}
                        </button>
                    </form>
                </div>
            </div>
        </section>
        </div>
    </main>
</template>
<script>
  export default {
    data() {
      return {
        email: null,
        password: null,
        has_error: false,
        submit: false
      }
    },
    mounted() {
      //
    },
    methods: {
      login() {
        // get the redirect object
        this.submit = true;
        var redirect = this.$auth.redirect()
        var app = this
        this.$auth.login({
          params: {
            email: app.email,
            password: app.password
          },
          success: function() {
            // handle redirection
            const redirectTo = redirect ? redirect.from.name : 'dashboard'
            this.$router.push({name: redirectTo})
          },
          error: function() {
            app.has_error = true
          },
          rememberMe: true,
          fetchUser: true
        })
      }
    }
  }
</script>
