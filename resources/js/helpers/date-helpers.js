import moment from 'moment'
import Vue from "vue";

const format = (d, f = 'DD/MM/YYYY HH:mm') => d && moment(d).isValid() && moment(d).format(f)

const dateIsPast = (d) => moment(d).isValid() && moment().diff(moment(d)) > 0

const getMonths = (lang = 'en') => moment.localeData(lang).months().map(Vue.stringHelpers.capitalize)

export default {
    format,
    dateIsPast,
    getMonths
}
