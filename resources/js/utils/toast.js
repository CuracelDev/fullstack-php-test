import Vue from 'vue';
import Toast from 'vue-toastification';
import "vue-toastification/dist/index.css";

Vue.use(Toast);

const toast = Vue.$toast;

export default class Toasts {
    showMessage(message, type) {
        if (type === 'success') {
            toast.success(message)
        } else {
            toast.error(message)
        }
    }

    successMessage(response) {
        this.showMessage(response.data.message, 'success')
    }

    errorMessage(error) {
        if (error.response.status === 500) {
            this.showMessage('Something went wrong, please try again', 'error');
        } else if (error.response.status === 422) {
            this.showMessage(error.response.message[0], 'error');
        } else {
            this.showMessage(error.response.data.message, 'error');
        }
    }
}