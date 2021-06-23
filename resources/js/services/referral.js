import client from './axiosClient';

const account = JSON.parse(localStorage.getItem('account'));

//TODO: Transfer this to helper file that deals with local storage
let ENDPOINT_URL = '/';

if (account) {
    ENDPOINT_URL = '/' + account.id + '/referrals/';
} else {
    // router.push('/login')
}

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
