import Vue from 'vue'
import ProgressBar from './Progress.vue'

const bar = Vue.prototype.$bar = new Vue(ProgressBar).$mount()

document.body.appendChild(bar.$el)

export default bar
