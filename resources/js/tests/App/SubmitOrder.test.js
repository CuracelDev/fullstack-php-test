import { shallowMount } from '@vue/test-utils'
import SubmitOrder from '../../components/App/SubmitOrder.vue'

describe('SubmitOrder.test.js', () => {

    let cmp, vm;

    beforeEach(() => {
        cmp = shallowMount(SubmitOrder, {
            // Create a shallow instance of the component
            data: {
                messages: ["Cat"]
            }
        });
    });


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

    // Add more test cases as needed to cover other functionalities, like submitting data, computed properties, etc.
});
