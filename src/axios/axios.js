import axios from "axios";

const axiosClient = axios.create({
    // baseURL:'https://2860-102-215-12-244.ngrok-free.app/api'
    baseURL:'http://localhost:8000/api'
    
})
axiosClient.interceptors.request.use(config =>{
    config.headers.Authorization = `Bearer ${sessionStorage.getItem('token')}`
    config.headers['Content-Type'] = 'application/json' 
    config.headers['ngrok-skip-browser-warning'] = '69420'
    return config;
})

export default axiosClient;