import { mount } from '@vue/test-utils'
import Order from '../../resources/js/components/Order.vue'

describe('Order.vue', () => {
    it('increments counter', () => {
      
      const wrapper = mount(Order, {
        data () {
          return {
              form:{
                provider_id:null,
                hmo_id:null,
                items:[],
                encounter_date:null,
                total:0
            }
          }
        },
      })

      wrapper.vm.addItem({
        name:'',
        unitPrice:2,
        qty:2,
        subTotal:null
      })

      let subTotal0 = wrapper.vm.subTotal(0)
      let subTotal1 = wrapper.vm.subTotal(1)
       
      expect(wrapper.vm.form.items[0].subTotal).toBe(0)
      expect(wrapper.vm.form.items[1].subTotal).toBe(4)

      expect(wrapper.vm.form.total).toBe(subTotal0 + subTotal1)

      wrapper.vm.addItem({
        name:'',
        unitPrice:5,
        qty:2,
        subTotal:null
      })

     let subTotal2 = wrapper.vm.subTotal(2)
     
     expect(wrapper.vm.form.items[2].subTotal).toBe(10)

     expect(wrapper.vm.form.total).toBe(subTotal0 + subTotal1 + subTotal2)

     wrapper.vm.removeItem(1)

     expect(wrapper.vm.form.total).toBe(subTotal0 + subTotal2)

     console.log(subTotal0 + subTotal2)

    })
})