<template>
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Invoices</span>
            <div>
                <router-link to="/invoices/create" class="btn btn-primary">
                    New Invoice
                </router-link>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-link">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Number</th>
                        <th>Customer</th>
                        <th>Due Date</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in model.data" :key="item.data" @click="detailsPage(item)">
                        <td class="w-1">{{item.id}}</td>
                        <td class="w-3">{{item.date}}</td>
                        <td class="w-3">{{item.number}}</td>
                        <td class="w-9">{{item.customer.text}}</td>
                        <td class="w-3">{{item.due_date}}</td>
                        <td class="w-3">{{item.total | formatMoney}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-footer flex-between">
            <div>
                <small>Showing {{model.from}} - {{model.to}} of {{model.total}}</small>
            </div>
            <div>
                <button class="btn btn-sm" :disabled="!model.prev_page_url" @click="prevPage">
                    Prev
                </button>
                <button class="btn btn-sm" :disabled="!model.next_page_url" @click="nextPage">
                    Next
                </button>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import { get } from '../../lib/api'
    export default {
        data () {
            return {
                model: {
                    data: []
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            get('/api/invoices', to.query)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            get('/api/invoices', to.query)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            detailsPage(item) {
                this.$router.push(`/invoices/${item.id}`)
            },
            setData(res) {
                Vue.set(this.$data, 'model', res.data.results)
                this.page = this.model.current_page
                this.$bar.finish()
            },
            nextPage() {
                if(this.model.next_page_url) {
                    const query = Object.assign({}, this.$route.query)
                    query.page = query.page ? (Number(query.page) + 1) : 2

                    this.$router.push({
                        path: '/invoices',
                        query: query
                    })
                }
            },
            prevPage () {
                if(this.model.prev_page_url) {
                    const query = Object.assign({}, this.$route.query)
                    query.page = query.page ? (Number(query.page) - 1) : 1

                    this.$router.push({
                        path: '/invoices',
                        query: query
                    })
                }
            }
        }
    }
</script>
