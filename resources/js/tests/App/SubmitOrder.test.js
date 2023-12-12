import {shallowMount} from '@vue/test-utils'
import SubmitOrder from '../../components/App/SubmitOrder.vue'

describe('SubmitOrder.test.js', () => {


    it('adds more order items when "Add More" button is clicked', async () => {
        const wrapper = shallowMount(SubmitOrder);

        // Find the "Add More" button and trigger a click event
        const addButton = wrapper.find('#add-button');
        await addButton.trigger('click');

        // Check if the number of order items has increased
        expect(wrapper.vm.form.orderItems).toHaveLength(2); // Adjust the length based on your test case
    });

    it('removes an order item when "Delete" button is clicked', async () => {
        const wrapper = shallowMount(SubmitOrder);

        // Find the "Add More" button and trigger a click event to have at least two items
        const addButton = wrapper.find('#add-button');
        await addButton.trigger('click');

        // Find the "Delete" button and trigger a click event on the second item
        const deleteButton = wrapper.findAll('#delete-button').at(1); // Adjust the index based on your test case
        await deleteButton.trigger('click');

        // Check if an order item has been removed
        expect(wrapper.vm.form.orderItems).toHaveLength(1); // Adjust the length based on your test case
    });

    it('initially renders with one order item', () => {
        const wrapper = shallowMount(SubmitOrder);
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
        const wrapper = shallowMount(SubmitOrder);
        await wrapper.find("[data-name]").setValue("test item");

        // Simulate input changes for unit price and quantity as needed

        const orderItem = wrapper.vm.form.orderItems[0];
        expect(orderItem.name).toBe('Test Item');
        // Assert other updated properties in a similar manner
    });

    it('disables submit button when submitting is true', async () => {
        const wrapper = shallowMount(SubmitOrder);

        const submitButton = wrapper.find('#submit-button');
        expect(submitButton.attributes('disabled')).toBeFalsy();

        // Trigger the submit action (you may need to mock the axios.post call)
        await wrapper.vm.submit();
        await wrapper.vm.$nextTick();

        expect(submitButton.attributes('disabled')).toBeTruthy();
    });
});
