import { mount, createLocalVue } from '@vue/test-utils';
import SubmitOrderForm from '../components/SubmitOrder.vue';

describe('SubmitOrderForm.vue - Order Management', () => {
  let localVue;

  beforeEach(() => {
    localVue = createLocalVue();
  });

  it('adds new items correctly', async () => {
    const wrapper = mount(SubmitOrderForm, {
      localVue,
      propsData: {
        provider: 'Test Provider'
      }
    });

    // Simulate user input for the first item
    await wrapper.find('[data-testid="order-item-0"] [data-testid="item-name"]').setValue('Test Item 1');
    await wrapper.find('[data-testid="order-item-0"] [data-testid="item-unit-price"]').setValue('10');
    await wrapper.find('[data-testid="order-item-0"] [data-testid="item-quantity"]').setValue('2');

    // Add a new item
    wrapper.find('[data-testid="add-item-btn"]').trigger('click');
    await wrapper.vm.$nextTick();

    // Assert that a new item is added correctly
    expect(wrapper.findAll('[data-testid^="order-item-"]').length).toBe(2);
  });

  it('removes items correctly', async () => {
    const wrapper = mount(SubmitOrderForm, {
        localVue,
        propsData: {
          provider: 'Test Provider'
        }
      });

      // Simulate user input for the first item
      await wrapper.find('[data-testid="order-item-0"] [data-testid="item-name"]').setValue('Test Item 1');
      await wrapper.find('[data-testid="order-item-0"] [data-testid="item-unit-price"]').setValue('10');
      await wrapper.find('[data-testid="order-item-0"] [data-testid="item-quantity"]').setValue('2');

      // Add a new item
      wrapper.find('[data-testid="add-item-btn"]').trigger('click');
      await wrapper.vm.$nextTick();

      // Simulate user input for the second item
      await wrapper.find('[data-testid="order-item-1"] [data-testid="item-name"]').setValue('Test Item 2');
      await wrapper.find('[data-testid="order-item-1"] [data-testid="item-unit-price"]').setValue('15');
      await wrapper.find('[data-testid="order-item-1"] [data-testid="item-quantity"]').setValue('3');

      // Remove the first item
      wrapper.find('[data-testid="remove-item-btn-0"]').trigger('click');
      await wrapper.vm.$nextTick();

      // Assert that the first item is removed correctly
      expect(wrapper.findAll('[data-testid^="order-item-"]').length).toBe(1);
      expect(wrapper.vm.order.items.length).toBe(1);
      expect(wrapper.vm.order.items[0].name).toBe('Test Item 2');
  });

  it('calculates unit prices correctly', async () => {
    const wrapper = mount(SubmitOrderForm, {
        localVue,
        propsData: {
          provider: 'Test Provider'
        }
      });

      // Simulate user input for the first item
      await wrapper.find('[data-testid="order-item-0"] [data-testid="item-name"]').setValue('Test Item 1');
      await wrapper.find('[data-testid="order-item-0"] [data-testid="item-unit-price"]').setValue('10');
      await wrapper.find('[data-testid="order-item-0"] [data-testid="item-quantity"]').setValue('2');

      // Add a new item
      wrapper.find('[data-testid="add-item-btn"]').trigger('click');
      await wrapper.vm.$nextTick();

      // Simulate user input for the second item
      await wrapper.find('[data-testid="order-item-1"] [data-testid="item-name"]').setValue('Test Item 2');
      await wrapper.find('[data-testid="order-item-1"] [data-testid="item-unit-price"]').setValue('15');
      await wrapper.find('[data-testid="order-item-1"] [data-testid="item-quantity"]').setValue('3');

      // Assert that subtotal for the first item is calculated correctly
      expect(wrapper.vm.order.items[0].sub_total).toBe(20);

      // Assert that subtotal for the second item is calculated correctly
      expect(wrapper.vm.order.items[1].sub_total).toBe(45);
  });

  it('calculates total order amount correctly', async () => {
    const wrapper = mount(SubmitOrderForm, {
      localVue,
      propsData: {
        provider: 'Test Provider'
      }
    });

    // Simulate user input for the first item
    await wrapper.find('[data-testid="order-item-0"] [data-testid="item-name"]').setValue('Test Item 1');
    await wrapper.find('[data-testid="order-item-0"] [data-testid="item-unit-price"]').setValue('10');
    await wrapper.find('[data-testid="order-item-0"] [data-testid="item-quantity"]').setValue('2');

    // Add a new item
    wrapper.find('[data-testid="add-item-btn"]').trigger('click');
    await wrapper.vm.$nextTick();

    // Simulate user input for the second item
    await wrapper.find('[data-testid="order-item-1"] [data-testid="item-name"]').setValue('Test Item 2');
    await wrapper.find('[data-testid="order-item-1"] [data-testid="item-unit-price"]').setValue('15');
    await wrapper.find('[data-testid="order-item-1"] [data-testid="item-quantity"]').setValue('3');

    // Assert that total order amount is calculated correctly
    expect(wrapper.vm.calculateOrderAmount).toBe(65);
  });

  it('recalculates total when items are removed', async () => {
    const wrapper = mount(SubmitOrderForm, {
      localVue,
      propsData: {
        provider: 'Test Provider'
      }
    });

    // Simulate user input for the first item
    await wrapper.find('[data-testid="order-item-0"] [data-testid="item-name"]').setValue('Test Item 1');
    await wrapper.find('[data-testid="order-item-0"] [data-testid="item-unit-price"]').setValue('10');
    await wrapper.find('[data-testid="order-item-0"] [data-testid="item-quantity"]').setValue('2');

    // Add a new item
    wrapper.find('[data-testid="add-item-btn"]').trigger('click');
    await wrapper.vm.$nextTick();

    // Simulate user input for the second item
    await wrapper.find('[data-testid="order-item-1"] [data-testid="item-name"]').setValue('Test Item 2');
    await wrapper.find('[data-testid="order-item-1"] [data-testid="item-unit-price"]').setValue('15');
    await wrapper.find('[data-testid="order-item-1"] [data-testid="item-quantity"]').setValue('3');

    // Remove the first item
    wrapper.find('[data-testid="remove-item-btn-0"]').trigger('click');
    await wrapper.vm.$nextTick();

    // Assert that total order amount is recalculated correctly
    expect(wrapper.vm.calculateOrderAmount).toBe(45);
  });
});
