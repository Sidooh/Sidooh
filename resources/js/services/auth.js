import axios from 'axios';

const API_URL = 'auth/';

class AuthService {
    login(user) {
        return axios
            .post(API_URL + 'login', {
                username: user.username,
                password: user.password
            })
            .then(response => {
                console.log('resSuccess', response)

                if (response.data.accessToken) {
                    localStorage.setItem('user', JSON.stringify(response.data));
                }

                if (response.data) {
                    return response.data;
                }

                throw onerror;
            })
            .catch(error => {
                console.log('resError', error)
                throw error
            });
    }

    logout() {
        localStorage.removeItem('user');
    }

    register(user) {
        return axios.post(API_URL + 'register', {
            username: user.username,
            email: user.email,
            password: user.password
        });
    }
}

export default new AuthService();
