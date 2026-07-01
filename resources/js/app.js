import  { createApp } from 'vue'
import App from './App.vue'
import axios from "axios";
import router from './router'

/* FILE NOTE
 * This file is a mount file thats run before the frontend library is instantiated and used.
 *
 * Usually used to setup stuff, e.g. we are setting up default headers and interceptors for axios
*/

axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.interceptors.response.use(
    (response) => response, // Let successful requests pass right through
    (error) => {
        // Check if the server returns 401 (Unauthorized) or 419 (Session Expired)
        if (error.response && (error.response.status === 401 || error.response.status === 419)) {

            console.warn('Session expired. Redirecting to login page...')

            // Clear any local user profile data from state if you have it
            // e.g., authStore.logout()

            // Redirect the user immediately back to your login screen
            window.location.href = '/login'
        }
        return Promise.reject(error)
    }
)

const app = createApp(App)
app.use(router)
app.mount('#app')
