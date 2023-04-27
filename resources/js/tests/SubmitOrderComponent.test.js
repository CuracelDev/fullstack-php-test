import SubmitOrder from "@/components/SubmitOrder.vue";
import { mount } from '@vue/test-utils'

test('test component sub total calculation', async () => {

    const wrapper = mount(SubmitOrder, {
        props: {

        }
    })

    let itemQty = wrapper.find('#item-qty-0');
    const itemQtyValue = Math.floor(Math.random() * 100)
    await itemQty.setValue(itemQtyValue)

    let itemUnitPrice = wrapper.find('#item-unit-price-0');
    const unitPriceValue = Math.random() * 100;
    await itemUnitPrice.setValue(unitPriceValue)

    let itemSubTotal = wrapper.find('#item-sub-total-0');

    expect(itemQtyValue * unitPriceValue).toEqual(itemSubTotal.element.value);
})
