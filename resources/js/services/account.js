import client from './axiosClient';
import logger from "../helpers/logger";

let ENDPOINT_URL = 'accounts/';

class ReferralService {
    balances() {
        return client
            .get(ENDPOINT_URL + 'balances')
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

    earningsSummary() {
        return client
            .get(ENDPOINT_URL + 'earnings/summary')
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

export default new ReferralService();
