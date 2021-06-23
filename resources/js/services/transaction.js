import client from './axiosClient';

const account = JSON.parse(localStorage.getItem('account'));

if (account) {
    const ENDPOINT_URL = '/' + account.id + '/transactions/';
} else {
    // router.push('/login')
}


class TransactionService {
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

export default new TransactionService();
