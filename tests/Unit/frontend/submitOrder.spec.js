import { shallowMount } from '@vue/test-utils'
import SubmitOrderComp from '../../../resources/js/components/SubmitOrder.vue'
import crypto from 'crypto'

describe('Adding and removing Items', () => {
  it('adds item successfully', () => {
    const wrapper = shallowMount(SubmitOrderComp, {
      data() {
        return { items: [] };
      }
    })
    for (let i = 0; i < 20; i++) {
      wrapper.vm.addItem();
      expect(wrapper.vm.items).toHaveLength(i + 1);
    }
  });
  it('deletes item successfully', () => {
    const items = randomItems(20);
    const reference = Array.from(items);
    const wrapper = shallowMount(SubmitOrderComp, {
      data() {
        return { items };
      }
    })
    for (let i = 19; i > 0; i--) {
      const index = randomNumber(i);
      wrapper.vm.removeItem(index);     //remove random item
      expect(wrapper.vm.items).toHaveLength(i);
      reference.splice(index, 1);
      expect(wrapper.vm.items).toEqual(reference);
    }
  })
  it('refuses to delete the last item', () => { //an order must contain at least one item
    const items = randomItems(5);
    const reference = Array.from(items);
    const wrapper = shallowMount(SubmitOrderComp, {
      data() {
        return { items };
      }
    })
    for (let i = 5; i >= 0; i--) { // (try to) remove all items
      wrapper.vm.removeItem(i);
    }
    expect(wrapper.vm.items.length).toBe(1); // assert that one item was left
    wrapper.vm.removeItem(0); // try to remove that last item again
    expect(wrapper.vm.items.length).toBe(1); // assert that it survived and is still in the array
  })
})


describe('Computing total', () => {
  it('computes and formats subtotals correctly (fixed values)', () => {
    const wrapper = shallowMount(SubmitOrderComp, {});
    for (let i = 0; i < 5; i++) {
      expect(wrapper.vm.subTotal(11.32, 8)).toBe("90.56"); //result doesn't need rounding (90.56)
      expect(wrapper.vm.subTotal(2, 100)).toBe("200.00"); // result needs extra zeros after decimal point(200)
      expect(wrapper.vm.subTotal(1025.61, 7)).toBe("7179.27"); // result produces infinite decimal digits (7179.2699999999995)
    }
  });
  it('computes subtotals correctly (random values)', () => {
    const wrapper = shallowMount(SubmitOrderComp, {});
    for (let i = 0; i < 5; i++) {
      const unitPrice = randomNumber();
      const quantity = randomNumber();
      expect(Number(wrapper.vm.subTotal(unitPrice, quantity))).toBeCloseTo(unitPrice * quantity);
    }
  });
  it('computes totals(not subtotals) correctly', () => {
    const wrapper = shallowMount(SubmitOrderComp, {});
      expect(wrapper.vm.total( [
        {name: "joe", unit_price: 0.1, quantity: 1},
        {name: "doe", unit_price: 0.2, quantity: 1}
      ])).toBe("0.30"); // multiple items, result needs rounding (0.30000000000000004)
    wrapper.vm.items = 
    expect(wrapper.vm.total([{name: "joe", unit_price: 100, quantity: 4}])).toBe("400.00"); // one item
    expect(wrapper.vm.total([
      {name: "joe", unit_price: 1000, quantity: 50},
      {name: "joe", unit_price: 250.99, quantity: 10}
    ])).toBe("52509.90"); //multiple items, result needs extra zeros (52509.9)
  });
  it('total never produces NaN (to avoid weird value in browser)', () => {
    const wrapper = shallowMount(SubmitOrderComp, {});
    expect(wrapper.vm.total([
      {name: "jane", unit_price: undefined, quantity: 1}
    ])).toBe("")
  })
});

function randomItems(amount) {
  const items = [];
  for (let i = 0; i < amount; i++) {
    items.push({ name: randomName(), unit_price: randomNumber(), quantity: randomNumber() });
  }
  return items;
}
function randomNumber(max=99999999999999) {
return Math.floor(Math.random() * max);
}
function randomName() {
  return crypto.randomUUID().substring(0, 8);
}