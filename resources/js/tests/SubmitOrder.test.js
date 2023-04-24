import { mount } from '@vue/test-utils';
import SubmitOrder from '../components/SubmitOrder.vue';

describe('SubmitOrder', () => {
  it('calculates subtotal correctly for each item', async () => {
    const wrapper = mount(SubmitOrder);

    const quantity = Math.floor(Math.random() * 10) + 1;
    const price = Math.floor(Math.random() * 50) + 1;

    const priceInput = wrapper.find('#price');   
    await priceInput.setValue(price);

    const quantityInput = wrapper.find('#quantity');
    await quantityInput.setValue(quantity);

    const expectedSubtotal = quantity * price;

    // Simulate a change event on the price input
    await priceInput.trigger('change');

    const actualSubtotal = wrapper.find('#subtotal');

    expect(actualSubtotal.element.value).toBe(expectedSubtotal.toString());
  });
});