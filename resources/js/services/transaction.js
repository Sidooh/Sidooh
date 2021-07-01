import client from './axiosClient';
import logger from "../helpers/logger";

let ENDPOINT_URL = 'transactions/';

class TransactionService {
    all() {
        return client
            .get(ENDPOINT_URL)
            .then(response => {
                logger.log('resSuccess', response)

                if (response.data) {
                    return response.data;
                }

                return response;
            })
            .catch(error => {
                logger.log('resError', error)
                throw error.response
            });
    }

}

export default new TransactionService();
