import client from './axiosClient';

const account = JSON.parse(localStorage.getItem('account'));

//TODO: Transfer this to helper file that deals with local storage
// if (account) {
const ENDPOINT_URL = '/' + account.id + '/accounts/';
// } else {
//     // router.push('/login')
// }

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
