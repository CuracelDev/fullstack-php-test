import { shallowMount } from '@vue/test-utils'
import AppButton from '../components/AppButton.vue'

describe('App Button', function () {
    const wrapper = shallowMount(AppButton);

    it('should be rendered and active', function () {
        expect(wrapper.find('.btn').exists()).toBe(true)
        expect(wrapper.element.hasAttribute('disabled')).toBe(false)
    });

    it('should be disabled when loading', function () {
        wrapper.setProps({ loading: true }).then(() => {
            expect(wrapper.find('.spinner-border').exists()).toBe(true)
            expect(wrapper.element.hasAttribute('disabled')).toBe(true)
        })
    });
});
