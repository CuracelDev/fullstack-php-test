import Api from "./api";
class OrderService extends Api {
    constructor() {
        super();
        this.setRequestInterceptor(req => {
            req.data = JSON.stringify(req.data);
            return req;
        })
        this.setResponseInterceptor(res => {
            if(res.status === 422) {
                return Promise.reject(JSON.parse(res.data))
            }
            return Promise.resolve(JSON.parse(res.data))
        }, err => Promise.reject(err))
    }

    createOrder(data) {
        return this.post("order", data);
    }

    getHmos() {
        return this.get("hmos");
    }

}

export default new OrderService()
