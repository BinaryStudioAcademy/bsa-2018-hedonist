import httpService from '../../../services/common/httpService';

export default {
    checkIn: (context, data) => {
        return httpService.post('/users/me/checkins', data)
            .then(response => { 
                return response; 
            })
            .catch(error => {
                return error;
            });
    },
    
    setPlaceRating: (context, data) => {
        return httpService.post('/places/rating', data)
            .then(response => { 
                return response; 
            })
            .catch(error => {
                return error;
            });
    }
};
