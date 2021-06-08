import client from './axiosClient';
import router from "../router";

const account = JSON.parse(localStorage.getItem('account'));

// if (account) {
const ENDPOINT_URL = '/' + account.id + '/purchase/';
// } else {
//     // router.push('/login')
// }


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
                throw error.response
            });
    }

}

export default new PurchaseService();
