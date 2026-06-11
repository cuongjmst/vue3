import { createRouter, createWebHashHistory } from 'vue-router'
import MainIndex from '@/components/Main/MainIndex/MainIndex.vue'
import CheckCart from '@/components/Main/CheckCart/CheckCart.vue'
import CheckOut from '@/components/Main/CheckOut/CheckOut.vue'
import ProductDetail from '@/components/Main/ProductDetail/ProductDetail.vue'

const routes = [
    {
        path: '/',
        component: MainIndex
    },
    {
        path: '/check-cart',
        component: CheckCart
    },
    {
        path: '/check-out',
        component: CheckOut
    },
    {
        path: '/product-detail/:id',
        component: ProductDetail
    }
]

const router = createRouter({
    history: createWebHashHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 }
    }
})

export default router