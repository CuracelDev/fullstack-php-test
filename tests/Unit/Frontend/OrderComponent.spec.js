import { mount } from '@vue/test-utils';
import OrderForm from '@/components/OrderForm.vue';

describe('OrderForm.vue', () => {
    let wrapper;

    beforeEach(() => {
        wrapper = mount(OrderForm);
    });

    afterEach(() => {
        wrapper.unmount();
    });

    it('renders the form with initial data', () => {
        expect(wrapper.find('[data-testid="hmo-code-input"]').exists()).toBe(true);
        expect(wrapper.find('[data-testid="provider-code-input"]').exists()).toBe(true);
        expect(wrapper.find('[data-testid="encounter-date-input"]').exists()).toBe(true);
        expect(wrapper.find('[data-testid="sent-date-input"]').exists()).toBe(true);
        expect(wrapper.find('[data-testid="add-item-button"]').exists()).toBe(true);
        expect(wrapper.find('[data-testid="submit-button"]').exists()).toBe(true);

        expect(wrapper.vm.formData.hmo_code).toBe('');
        expect(wrapper.vm.formData.provider_code).toBe('');
        expect(wrapper.vm.formData.encounter_date).toBe(null);
        expect(wrapper.vm.formData.sent_date).toBeDefined();
        expect(wrapper.vm.formData.items).toHaveLength(1);
    });

    it('adds an item to the form when "Add Item" button is clicked', async () => {
        const addItemButton = wrapper.find('[data-testid="add-item-button"]');
        await addItemButton.trigger('click');

        expect(wrapper.vm.formData.items).toHaveLength(2);
    });

    it('removes an item from the form when "Remove Item" button is clicked', async () => {
        const removeItemButton = wrapper.find('[data-testid="remove-item-button"]');
        await removeItemButton.trigger('click');

        expect(wrapper.vm.formData.items).toHaveLength(0);
    });

    it('calculates the subtotal when an item quantity or unit price changes', async () => {
        const quantityInput = wrapper.find('[data-testid="quantity-input"]');
        await quantityInput.setValue(3);

        const unitPriceInput = wrapper.find('[data-testid="unit-price-input"]');
        await unitPriceInput.setValue(100);

        expect(wrapper.vm.formData.items[0].subtotal).toBe(300);
    });

    it('submits the form when "Submit" button is clicked', async () => {
        const submitButton = wrapper.find('[data-testid="submit-button"]');

        const axiosPostSpy = jest.spyOn(wrapper.vm.axios, 'post').mockResolvedValueOnce({});
        const alertSpy = jest.spyOn(window, 'alert').mockImplementation(() => {});

        await submitButton.trigger('click');

        expect(axiosPostSpy).toHaveBeenCalledWith('/api/orders', wrapper.vm.formData);
        expect(alertSpy).toHaveBeenCalled();
        expect(wrapper.vm.formData.hmo_code).toBe('');
        expect(wrapper.vm.formData.provider_code).toBe('');
        expect(wrapper.vm.formData.encounter_date).toBe(null);
        expect(wrapper.vm.formData.sent_date).toBeDefined();
        expect(wrapper.vm.formData.items).toHaveLength(1);

        axiosPostSpy.mockRestore();
        alertSpy.mockRestore();
    });
});
