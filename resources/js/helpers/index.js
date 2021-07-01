import Vue from 'vue'

import dateHelpers from './date-helpers'
import stringHelpers from './string-helpers'
import miscHelpers from './misc-helpers'

export default {
    install: () => {
        Vue.prototype.dateHelpers = dateHelpers
        Vue.dateHelpers = dateHelpers

        Vue.prototype.stringHelpers = stringHelpers
        Vue.stringHelpers = stringHelpers

        Vue.prototype.miscHelpers = miscHelpers
        Vue.miscHelpers = miscHelpers
    }
}
