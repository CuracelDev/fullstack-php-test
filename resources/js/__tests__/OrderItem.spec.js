import { mount } from '@vue/test-utils'
import OrderItem from '../widgets/OrderItem.vue'

let wrapper = mount(OrderItem);

beforeEach(() => {
    wrapper = mount(OrderItem);
});

afterEach(() => {
    wrapper.destroy();
});

describe('Order item widget', function () {

    test('is vue instance', function() {
        expect(wrapper.isVueInstance).toBeTruthy();
    })

    it('should have name, price and quantity inputs', function () {
        const name = "item";
        wrapper.setProps({ name }).then(() => {
            expect(wrapper.find(`input[name="${name}.name"`).exists()).toBe(true)
            expect(wrapper.find(`input[name="${name}.price"`).exists()).toBe(true)
            expect(wrapper.find(`input[name="${name}.quantity"`).exists()).toBe(true)
        })
    });

    it('should calculate the total accurately', function () {
        const item = { price: 100, quantity: 5 }
        wrapper.setData({ form: item })
        expect(wrapper.vm.subtotal).toBe(500)
    });

});
