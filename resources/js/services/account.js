import client from './axiosClient';

let ENDPOINT_URL = 'accounts/';

class ReferralService {
    balances() {
        return client
            .get(ENDPOINT_URL + 'balances')
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

    earnings() {
        return client
            .get(ENDPOINT_URL + 'earnings')
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
