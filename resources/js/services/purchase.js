import client from './axiosClient';

const account = JSON.parse(localStorage.getItem('account'));

let ENDPOINT_URL = '/';

if (account) {
    ENDPOINT_URL = '/' + account.id + '/purchases/';
} else {
    // router.push('/login')
}


class PurchaseService {
    airtime(form) {
        return client
            .post(ENDPOINT_URL + 'airtime', form)
            .then(response => {
                console.log('resSuccess', response)

                if (response.data) {
                    return response.data;
                }

                return response;
            })
            .catch(error => {
                console.log('resError', error.response)
                throw error.response.data
            });
    }


    airtimeStatus(transactionId) {
        return client
            .get(ENDPOINT_URL + 'airtime/' + transactionId)
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

    voucher(form) {
        return client
            .post(ENDPOINT_URL + 'voucher', form)
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


    voucherStatus(transactionId) {
        return client
            .get(ENDPOINT_URL + 'voucher/' + transactionId)
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

export default new PurchaseService();
