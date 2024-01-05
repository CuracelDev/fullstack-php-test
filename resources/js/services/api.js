const { Axios } = require("axios");

export default class Api {
    constructor(baseURL) {
        this.axios = new Axios({
            baseURL,
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        });
    }

    setAxiosConfig(config) {
        this.axios = new Axios(config);
        return this;
    }

    setConfig(key, value) {
        this.axios.defaults[key] = value;
        return this;
    }

    setBaseUrl(url) {
        this.axios.defaults.baseURL = url;
        return this;
    }

    setHeader(header, value) {
        this.axios.defaults.headers[header] = value;
        return this;
    }

    setRequestInterceptor(onSuccess, onError = error => Promise.reject(error)) {
        this.axios.interceptors.request.use(onSuccess, onError)
        return this;
    }

    setResponseInterceptor(onSuccess, onError = error => Promise.reject(error)) {
        this.axios.interceptors.response.use(onSuccess, onError)
    }

    request(config) {
        this.axios.request(config)
    }

    get(url) {
        return this.axios.get(url);
    }

    post(url, data, config) {
        return this.axios.post(url, data, config)
    }

    put(url, data, config) {
        return this.axios.put(url, data, config)
    }

    delete(url, config) {
        return this.axios.delete(url, config)
    }
}
