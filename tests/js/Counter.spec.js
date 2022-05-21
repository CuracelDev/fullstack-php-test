// tests/js/Counter.spec.js
import { mount } from '@vue/test-utils'
//const mount = require('vue-test-utils')
import Counter from '../../resources/js/components/Counter.vue'

describe('Counter.vue', () => {
    it('increments counter', () => {
        const wrapper = mount(Counter);

        expect(wrapper.vm.counter).toBe(0);

        wrapper.find('button').trigger('click')

        expect(wrapper.vm.counter).toBe(1);
    })
})