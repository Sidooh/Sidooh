import client from './axiosClient';

const id = JSON.parse(localStorage.getItem('account')).id;

const ENDPOINT_URL = '/' + id + '/referrals/';

class ReferralService {
    all() {
        return client
            .get(ENDPOINT_URL)
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

}

export default new ReferralService();
