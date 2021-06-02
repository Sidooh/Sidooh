import client from './axiosClient';

const ENDPOINT_URL = '/auth';

class AuthService {
    login(user) {
        return client
            .post(ENDPOINT_URL + '/login', user)
            .then(response => {
                console.log('resSuccess', response)

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
                console.log('resError', error.response)
                throw error.response
            });
    }

    logout() {
        localStorage.removeItem('user');
        localStorage.removeItem('token');
    }

    registerCheckPhone(phone) {
        return client
            .post(ENDPOINT_URL + '/register/check-phone', phone)
            .then(response => {
                console.log('resSuccess', response)

                if (response.data) {
                    return response.data;
                }

                return response;
            })
            .catch(error => {
                console.log('resError', error.response)
                throw error.response
            });
    }

    register(user) {
        return client.post(ENDPOINT_URL + '/register', user);
    }
}

export default new AuthService();
