import { mount } from '@vue/test-utils'
import SubmitOrder from '../components/SubmitOrder.vue'

describe('SubmitOrder', () => {
    it('renders the component correctly', () => {
      const wrapper = mount(SubmitOrder)
      expect(wrapper.find('.card-header').text()).toEqual('Submit An Order')

      //check that one item is added
      expect(wrapper.vm.order.items.length).toEqual(1)
      expect(wrapper.vm.submitting).toBeFalsy()
    })


    it('adds item when the add button is clicked', () => {
        const wrapper = mount(SubmitOrder)
        expect(wrapper.vm.order.items.length).toEqual(1)

        wrapper.find('#add-button').trigger('click')
        expect(wrapper.vm.order.items.length).toEqual(2)
      })

      it('adds removes when the remove button is clicked', () => {
        const wrapper = mount(SubmitOrder)

        //check that one item is added
        expect(wrapper.vm.order.items.length).toEqual(1)

        wrapper.find('#add-button').trigger('click')
        expect(wrapper.vm.order.items.length).toEqual(2)

        wrapper.find('#remove-button0').trigger('click')
        expect(wrapper.vm.order.items.length).toEqual(1)
      })

      it('adds calculates totals', async () => {
        const wrapper = mount(SubmitOrder)

        let unitPrice = wrapper.find('#unit0');
        await unitPrice.setValue(500)

        unitPrice.trigger('input');
        unitPrice.trigger('keyup');
       
        let qty = wrapper.find('#qty0');
        await qty.setValue(2)
        qty.trigger('input');
        qty.trigger('keyup');

        expect(wrapper.vm.order.items[0].sub_total).toEqual(1000)
        expect(wrapper.vm.total).toEqual(1000)


        //when another item is added, total should recalculate
        await wrapper.find('#add-button').trigger('click')

        expect(wrapper.vm.order.items.length).toEqual(2)

        let unitPrice2 = wrapper.find('#unit1');
        await unitPrice2.setValue(2000)

        unitPrice2.trigger('input');
        unitPrice2.trigger('keyup');
       
        let qty2 = wrapper.find('#qty1');
        await qty2.setValue(4)
        qty2.trigger('input');
        qty2.trigger('keyup');

        expect(wrapper.vm.order.items[1].sub_total).toEqual(8000)

        expect(wrapper.vm.total).toEqual(9000)

        //Remove the first item added and the total should be 8000
        await wrapper.find('#remove-button0').trigger('click')
        expect(wrapper.vm.total).toEqual(8000)
      })
  })