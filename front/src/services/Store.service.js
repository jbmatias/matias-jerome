import httpService from '@/services/Http.service';

export default class StoreService extends httpService {
  constructor() {
    super();    
  }

  getStoreHours = async () => {
    return await this.get('/store-hours');
  }

  updateStoreHours = async (data) => {
    return await this.put('/store-hours', data);
  }
}
