import httpClient from "./http_service";
import router from '../router';

const authService = {
    user: null,

    /**
     * Login user
     * @param formData
     * @returns {Promise<{success: boolean, errors: *}|{success: boolean}>}
     */
    async login(formData) {
        try {
            const {status, data} = await httpClient.post('user/login', formData)

            if (status === 200) {
                this.setUser(data)
                return {success: true}
            }

        } catch (e) {
            return {success: false, errors: e.response.data.errors}
        }
    },

    /**
     * Register user
     * @param formData
     * @returns {Promise<{success: boolean, errors: *}|{success: boolean}>}
     */
    async register(formData) {
        try {
            const {status, data} = await httpClient.post('user/register', formData)

            if (status === 200) {
                this.setUser(data)
                return {success: true}
            }

        } catch (e) {
            return {success: false, errors: e.response.data.errors}
        }
    },

    /**
     * Get user
     * @returns {Promise<null>}
     */
    async getCurrentUser() {
        if (!this.user) {
            const {status, data} = await httpClient.post('user/get-data');

            if (status === 200) {
                this.user = data;
            }
        }

        return this.user;
    },

    /**
     * Set user
     * @param user
     */
    setUser(user) {
        this.user = user;
        localStorage.setItem('ACCESS_TOKEN', user.access_token);
    },

    /**
     * Check is logged
     * @returns {boolean}
     */
    isLoggedIn() {
        return !!localStorage.getItem('ACCESS_TOKEN');
    },

    /**
     * Get access token
     * @returns {string}
     */
    getToken() {
        return localStorage.getItem('ACCESS_TOKEN');
    },

    /**
     * Logout user
     */
    logout() {
        localStorage.removeItem('ACCESS_TOKEN');
        router.push('login');
    }
}

export default authService;