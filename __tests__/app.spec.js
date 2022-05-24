
import { mount } from '@vue/test-utils'

import SubmitOrder from './../resources/js/components/SubmitOrder.vue'
import OrderItem from './../resources/js/components/OrderItem.vue'

describe('SubmitOrder', () => {
    // Inspect the raw component options
    it('has data', () => {
        expect(typeof SubmitOrder.data).toBe('function')
    })


    test('calls add Item when the button is clicked', async () => {
        const wrapper = mount(SubmitOrder, {
            // propsData: {
            //     totalItems: '4'
            // }
        })

        // wrapper.setData({ totalItems: 4})
        // const addItemButton =  wrapper.find('#addItem')
        const addItemButton =  wrapper.get('[data-test="addItem"]')
        const addItem = jest.fn()
        wrapper.setMethods({
            addItem: addItem
        })
        expect(wrapper.vm.totalItems).toBe(4)
        expect(wrapper.findAll('[data-test="order-item"]')).toHaveLength(4)
        await addItemButton.trigger('click')
        await wrapper.vm.addItem()


        expect(addItem).toHaveBeenCalled()
        // expect(wrapper.findAll('[data-test="order-item"]')).toHaveLength(5)
       //expect(wrapper.vm.totalItems).toBe(5)
    })

    test('calls remove Item when the button is clicked', async () => {
        const wrapper = mount(OrderItem, {})
        const removeItemButton =  wrapper.find('#removeItem')
        const remove = jest.fn()
        wrapper.setMethods({
            remove: remove
        })
        await removeItemButton.trigger('click')

        expect(remove).toHaveBeenCalled()
    })

    // test('saves item', async () => {
    //     expect.assertions(1)
    //     const data = await fetchListData()
    //     expect(data).toBe('some data')
    // })
      
      
})
