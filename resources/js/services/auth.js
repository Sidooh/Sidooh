import client from './axiosClient';
import logger from "../helpers/logger";

const ENDPOINT_URL = 'auth';

class AuthService {
    login(user) {
        //Finally, if for some reason you want to do disable the loader for a specific request, you can do it by passing the showLoader option to Axios like so:
        // axios.get('api/your-endpoint', { showLoader: false })
        return client
            .post(ENDPOINT_URL + '/login', user)
            .then(response => {
                logger.log('resSuccess', response)

                if (response.data.token) {
                    localStorage.setItem('account', JSON.stringify(response.data.account));
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    localStorage.setItem('token', response.data.token)
                }

                if (response.data) {
                    return response.data;
                }

                return response;
            })
            .catch(error => {
                logger.log('resError', error.response)
                throw error.response
            });
    }

    logout() {
        localStorage.removeItem('user');
        localStorage.removeItem('token');
        localStorage.removeItem('account');
    }

    registerCheckPhone(phone) {
        return client
            .post(ENDPOINT_URL + '/register/check-phone', phone)
            .then(response => {
                logger.log('resSuccess', response)

                if (response.data) {
                    return response.data;
                }

                return response;
            })
            .catch(error => {
                logger.log('resError', error.response)
                throw error.response
            });
    }

    register(user) {
        return client.post(ENDPOINT_URL + '/register', user);
    }
}

export default new AuthService();
