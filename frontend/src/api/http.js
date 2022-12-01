import axios from 'axios';

const baseURL = 'https://localhost:8000/api/v1';
const axiosConfig = {
  baseURL,
  timeout: 3000,
  withCredentials: false
};

const instance = axios.create(axiosConfig);

export function addResponseHandler(success, error) {
  instance.interceptors.response.use(success, error);
}

export default instance;
