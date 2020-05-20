import bearer from '@websanova/vue-auth/drivers/auth/bearer'
import axios from '@websanova/vue-auth/drivers/http/axios.1.x'
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x'
// Auth base configuration some of this options
// can be override in method calls
const config = {
  auth: bearer,
  http: axios,
  router: router,
  tokenDefaultName: 'mini-market',
  tokenStore: ['localStorage'],
  rolesVar: 'role',
  loginData: {url: 'admin/login', method: 'POST', redirect: '/dashboard', fetchUser: true},
  logoutData: {url: 'admin/logout', method: 'POST', redirect: '/', makeRequest: true},
  refreshData: {url: 'admin/refresh', method: 'GET', enabled: true, interval: 30}
}
export default config
