import client from './axiosClient';
import logger from "../helpers/logger";

let ENDPOINT_URL = '/purchases/';

class PurchaseService {
    airtime(form) {
        return client
            .post(ENDPOINT_URL + 'airtime', form)
            .then(response => {
                logger.log('resSuccess', response)

                if (response.data) {
                    return response.data;
                }

                return response;
            })
            .catch(error => {
                logger.log('resError', error.response)
                throw error.response.data
            });
    }


    airtimeStatus(transactionId) {
        return client
            .get(ENDPOINT_URL + 'airtime/' + transactionId)
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

    voucher(form) {
        return client
            .post(ENDPOINT_URL + 'voucher', form)
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


    voucherStatus(transactionId) {
        return client
            .get(ENDPOINT_URL + 'voucher/' + transactionId)
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


}

export default new PurchaseService();
