const { default: axios } = require("axios");

const access_token = document.querySelector('#accessToken').value

export const http = axios.create({
    baseURL: '/api',
    headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${access_token}`
    },
    timeout: 3000
});
