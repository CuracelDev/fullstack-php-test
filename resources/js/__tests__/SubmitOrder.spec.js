import { mount } from '@vue/test-utils'
import SubmitOrder from '../widgets/SubmitOrder.vue'

let wrapper = mount(SubmitOrder);

beforeEach(() => {
    wrapper = mount(SubmitOrder);
});

afterEach(() => {
    wrapper.destroy();
});

describe('Submit order widget', function () {

    test('is vue instance', function() {
        expect(wrapper.isVueInstance).toBeTruthy();
    })

    it('should have hmo code, provider name and encounter date inputs', function () {
        expect(wrapper.find('input[name="hmo_code"').exists()).toBe(true)
        expect(wrapper.find('input[name="provider_name"]').exists()).toBe(true)
        expect(wrapper.find('input[name="encounter_date"]').exists()).toBe(true)
    });

    it('should have one item by default', function () {
        expect(wrapper.vm.form.items.length).toBe(1);
        expect(wrapper.findAll('.order-item-input').length).toBe(1)
    });

    it('should have button to add item', function () {
        expect(wrapper.find('.add-item').exists()).toBe(true)
    });

    it('should have new item inputs when add item button is clicked', function () {
        expect(wrapper.vm.form.items.length).toBe(1);
        wrapper.find('.add-item').trigger('click').then(() => {
            expect(wrapper.vm.form.items.length).toBe(2);
            expect(wrapper.findAll('.order-item-input').length).toBe(wrapper.vm.form.items.length)
        })
    });

    it('should calculate the total accurately', function () {
        const items = [
            { price: 100, quantity: 1 },
            { price: 200, quantity: 2 },
            { price: 300, quantity: 3 }
        ]
        wrapper.setData({
            form: { items }
        })
        expect(wrapper.vm.total).toBe(1400)
    });
});
