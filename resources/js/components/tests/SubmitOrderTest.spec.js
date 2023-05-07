import { shallowMount } from '@vue/test-utils'
import SubmitOrder from '../components/SubmitOrder'

const factory = (values = {}) => {
    return shallowMount(SubmitOrder, {
        data () {
            return {
                formData: {
                    items: values
                }
            }
        }
    })
}

describe('SubmitOrder', () => {
    it('calculates the correct subtotal and total prices', () => {
        const wrapper = factory([
            {
                unit_price: 100,
                quantity: 2
            }
        ])

        expect(wrapper.find('.subtotal-0').text()).toEqual(100 * 2)
        expect(wrapper.find('.total').text()).toEqual(100 * 2)
    })

    it('calculates the correct subtotal and total prices', () => {
        const wrapper = factory([
            {
                unit_price: 100,
                quantity: 2
            },
            {
                unit_price: 200,
                quantity: 4
            }
        ])

        expect(wrapper.find('.subtotal-0').text()).toEqual(100 * 2)
        expect(wrapper.find('.subtotal-1').text()).toEqual(200 * 4)
        expect(wrapper.find('.total').text()).toEqual((100 * 2) + (200 * 4))
    })
});
