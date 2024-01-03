import { mount } from '@vue/test-utils';
import axios from 'axios';
import SubmitOrder from '../components/SubmitOrder.vue';

jest.mock("axios");
axios.get.mockResolvedValue({ 
    data: [], 
});
axios.post.mockResolvedValue({ 
    data: [], 
});

describe('SubmitOrder', () => {

    it('adds item when the add button is clicked', () => {
        const wrapper = mount(SubmitOrder);

        expect(wrapper.vm.order.items.length).toEqual(1);

        wrapper.find('#add-button').trigger('click');

        expect(wrapper.vm.order.items.length).toEqual(2);
    });

    it('removes item when the remove button is clicked', () => {
        const wrapper = mount(SubmitOrder);

        expect(wrapper.vm.order.items.length).toEqual(1);

        wrapper.find('#remove-button0').trigger('click');

        expect(wrapper.vm.order.items.length).toEqual(0);
    });

    it('calculates subtotal for each item and total', async () => {

        const wrapper = mount(SubmitOrder);

        const items = [
            {
                item:'Panadol',
                unit_price: Math.floor(Math.random() * 100) + 1,
                quantity: Math.floor(Math.random() * 50) + 1
            },
            {
                item:'Strepsil',
                unit_price: Math.floor(Math.random() * 100) + 1,
                quantity: Math.floor(Math.random() * 50) + 1
            }
        ];
        
        for (let i = 0; i < items.length; i++) {
            let unitPriceInput = wrapper.find('#unit-price'+i);   
            await unitPriceInput.setValue(items[i].unit_price);

            let quantityInput = wrapper.find('#quantity'+i);
            await quantityInput.setValue(items[i].quantity);

            let expectedSubtotal = items[i].quantity * items[i].unit_price;

            let actualSubtotal = wrapper.find('#sub-total'+i);

            expect(actualSubtotal.element.value).toBe(expectedSubtotal.toString());

            //add another item 
            await wrapper.find('#add-button').trigger('click');
        }

        let expectedTotal = items.reduce((sum, item) => {
            let quantity = item.quantity;
            let price = item.unit_price;
            return sum + (quantity * price);
        }, 0);

        let actualTotal = wrapper.find('#total');

        expect(actualTotal.element.value).toBe(expectedTotal.toString());

    });
});