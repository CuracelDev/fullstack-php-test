import { describe, it, expect, vi } from 'vitest'
import { shallowMount  } from '@vue/test-utils';
import SubmitOrder from '../components/SubmitOrder.vue';
import axios from 'axios'

function flushPromises() {
  return new Promise(resolve => setTimeout(resolve, 0));
}

// Mock the axios library
vi.mock("axios", () => {
  return {
    default: {
      get: vi.fn(() => Promise.resolve({ data: [] })),
    }
  };
});

describe('SubmitOrder.vue Test', () => {

  it('makes api call to fetch hmos on mount', async () => {

    const wrapper = shallowMount(SubmitOrder);

    const responseGet = {
      "data": [
          "HMO-A",
          "HMO-B",
          "HMO-C",
          "HMO-D"
      ],
      "success": true,
      "message": "Hmos Code Retrived"
    }
    axios.get.mockResolvedValue(responseGet)
    
    await flushPromises()

    expect(axios.get).toHaveBeenCalledTimes(1)
   });

  it('loads with one order item', async () => {

    const wrapper = shallowMount(SubmitOrder);

    const orders = wrapper.vm.orders;

    expect(orders).toHaveLength(1);
    expect(orders[0]).toMatchObject({
        name: '',
        unit_price: 0,
        quantity: 0,
        sub_total: 0,
    });
   }); 


   it('computes the subtotal of an item correctly', async () => {
    const wrapper = shallowMount(SubmitOrder);

    await wrapper.find('#item0').setValue('Apple');
    await wrapper.find('#unitPrice0').setValue(200);
    await wrapper.find('#quantity0').setValue(5000);

    const subTotal = wrapper.find('#subTotal0').element.value;

    expect(subTotal).toBe('1000000');
    expect(wrapper.vm.orders[0]).toMatchObject({
      name: 'Apple',
      unit_price: '200',
      quantity: '5000',
      sub_total: 1000000,
    });
   });
   
   
   it('adds more orders when the "+" button is clicked', async () => {
      const wrapper = shallowMount(SubmitOrder);

      await wrapper.find('#add').trigger('click');
      await wrapper.find('#add').trigger('click');

      expect(wrapper.vm.orders).toHaveLength(3);
   });


   it('removes orders when the "-" button is clicked', async () => {
    const wrapper = shallowMount(SubmitOrder);

    await wrapper.find('#add').trigger('click');
    await wrapper.find('#add').trigger('click');

    await wrapper.find('#remove2').trigger('click')

    expect(wrapper.vm.orders).toHaveLength(2);
  });

  it('computes the total of items correctly', async () => {
    const wrapper = shallowMount(SubmitOrder);

    await wrapper.find('#item0').setValue('Apple');
    await wrapper.find('#unitPrice0').setValue(200);
    await wrapper.find('#quantity0').setValue(5000);

    await wrapper.find('#add').trigger('click');

    await wrapper.find('#item1').setValue('Orange');
    await wrapper.find('#unitPrice1').setValue(100);
    await wrapper.find('#quantity1').setValue(20000);

    expect(wrapper.vm.orders).toStrictEqual([
      {
        name: 'Apple',
        unit_price: '200',
        quantity: '5000',
        sub_total: 1000000,
      },
      {
        name: 'Orange',
        unit_price: '100',
        quantity: '20000',
        sub_total: 2000000,
      }
    ]);

    const total = wrapper.find('#total').element.value;
    expect(total).toBe('3000000');

   });
})

