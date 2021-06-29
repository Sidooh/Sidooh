import client from './axiosClient';

let ENDPOINT_URL = '/earnings/';

class EarningService {
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

export default new EarningService();
