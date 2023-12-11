import { shallowMount } from '@vue/test-utils'
import SubmitOrder from '../../components/App/SubmitOrder.vue'

describe('SubmitOrder.test.js', () => {


    it('adds more order items when "Add More" button is clicked', async () => {
        const wrapper = shallowMount(SubmitOrder);

        // Find the "Add More" button and trigger a click event
        const addButton = wrapper.find('.bg-blue-800');
        await addButton.trigger('click');

        // Check if the number of order items has increased
        expect(wrapper.vm.form.orderItems).toHaveLength(2); // Adjust the length based on your test case
    });

    it('removes an order item when "Delete" button is clicked', async () => {
        const wrapper = shallowMount(SubmitOrder);

        // Find the "Add More" button and trigger a click event to have at least two items
        const addButton = wrapper.find('.bg-blue-800');
        await addButton.trigger('click');

        // Find the "Delete" button and trigger a click event on the second item
        const deleteButton = wrapper.findAll('.bg-blue-800').at(1); // Adjust the index based on your test case
        await deleteButton.trigger('click');

        // Check if an order item has been removed
        expect(wrapper.vm.form.orderItems).toHaveLength(1); // Adjust the length based on your test case
    });

    it('initially renders with one order item', () => {
        const wrapper = mount(SubmitOrder);
        const orderItems = wrapper.vm.form.orderItems;

        expect(orderItems).toHaveLength(1);
        expect(orderItems[0]).toMatchObject({
            name: '',
            unit_price: 0,
            quantity: 0,
            sub_total: 0,
        });
    });

    it('updates order item details when input fields are changed', async () => {
        const wrapper = mount(SubmitOrder);
        const nameInput = wrapper.find('input[name="name"]');
        await nameInput.setValue('Test Item');

        // Simulate input changes for unit price and quantity as needed

        const orderItem = wrapper.vm.form.orderItems[0];
        expect(orderItem.name).toBe('Test Item');
        // Assert other updated properties in a similar manner
    });

    it('disables submit button when submitting is true', async () => {
        const wrapper = mount(SubmitOrder);

        const submitButton = wrapper.find('.bg-blue-800');
        expect(submitButton.attributes('disabled')).toBeFalsy();

        // Trigger the submit action (you may need to mock the axios.post call)
        await wrapper.vm.submit();
        await wrapper.vm.$nextTick();

        expect(submitButton.attributes('disabled')).toBeTruthy();
    });

    it('updates sub_total when quantity or unit_price changes', async () => {
        const wrapper = mount(SubmitOrder);

        // Simulate changes in quantity and unit price for an order item
        const quantityInput = wrapper.find('input[name="quantity"]');
        await quantityInput.setValue('5');

        const unitPriceInput = wrapper.find('input[name="unit_price"]');
        await unitPriceInput.setValue('10');

        const orderItem = wrapper.vm.form.orderItems[0];
        expect(orderItem.sub_total).toBe(50); // 5 * 10 = 50
    });

    it('calculates the total based on the sum of sub_total for all order items', async () => {
        const wrapper = mount(SubmitOrder);

        // Simulate changes in quantity and unit price for multiple order items
        const addButton = wrapper.find('.bg-blue-800');
        await addButton.trigger('click');

        const orderItems = wrapper.vm.form.orderItems;
        orderItems[0].quantity = 5;
        orderItems[0].unit_price = 10;

        orderItems[1].quantity = 3;
        orderItems[1].unit_price = 8;

        // Calculate the expected total
        const expectedTotal = orderItems[0].sub_total + orderItems[1].sub_total;

        expect(wrapper.vm.total).toBe(expectedTotal);
    });
});
