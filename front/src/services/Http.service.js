// Http.service.js
import axios from 'axios';

export default class httpService {
  constructor() {    
    this.axiosInstance = axios.create({
      baseURL: import.meta.env.VITE_APP_API_URL,
    });
  }

  async get(url) {
    try {
      const response = await this.axiosInstance.get(url);
      return response.data;
    } catch (error) {
      console.error("Error making GET request:", error);
      throw error;
    }
  }
  
  async put(url, data) {
    try {
      const response = await this.axiosInstance.put(url, data);
      return response.data;
    } catch (error) {
      console.error("Error making PUT request:", error);
      throw error;
    }
  }
}
