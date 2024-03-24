import { shallowMount } from '@vue/test-utils';
import SubmitOrder from '../../components/SubmitOrder.vue';

describe('SubmitOrder.vue', () => {
    it('calculates the correct total amount', () => {
        const wrapper = shallowMount(SubmitOrder);
        const forms = [
            { item: 'Test Item 1', unitPrice: 10, quantity: 2 },
            { item: 'Test Item 2', unitPrice: 15, quantity: 1 }
        ];
        wrapper.setData({ forms });

        // Calculate the expected total amount
        const expectedTotal = forms.reduce((acc, form) => acc + form.unitPrice * form.quantity, 0);

        // Check if the computed total amount matches the expected total
        expect(wrapper.vm.total).toBe(expectedTotal);
    });
});
