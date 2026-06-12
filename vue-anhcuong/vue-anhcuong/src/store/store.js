import { createStore } from 'vuex'
import { useToast } from 'vue-toast-notification'
import database from '@/database/database'

export const store = createStore({
  state() {
    return {
      cart: {
        count: 0,
        productList: []
      }
    }
  },

  mutations: {
    setCartFromLocalStorage(state, cart) {
      state.cart = cart
    },
    addToCart(state, product) {
      state.cart.count++
      state.cart.productList.push(product)
      localStorage.setItem('cart', JSON.stringify(state.cart))
    },
    updateCart(state, data) {
      state.cart.count = data.count
      state.cart.productList[data.index].countInCart = data.countInCart
      state.cart.productList[data.index].checkOutSumary = data.checkOutSumary
      localStorage.setItem('cart', JSON.stringify(state.cart))
    },
    removeProduct(state, id) {
      const index = state.cart.productList.findIndex(p => p.id === id)
      if (index === -1) return
      state.cart.count -= state.cart.productList[index].countInCart
      state.cart.productList.splice(index, 1)
      localStorage.setItem('cart', JSON.stringify(state.cart))
    },
    changeAmountProducts(state, info) {
      const index = state.cart.productList.findIndex(p => p.id === info.id)
      if (index === -1) return
      const product = state.cart.productList[index]
      product.checkOutSumary = info.increase * product.price + parseInt(product.checkOutSumary)
      product.countInCart += info.increase
      state.cart.count += info.increase
      if (product.countInCart <= 0) {
        state.cart.productList.splice(index, 1)
      }
      localStorage.setItem('cart', JSON.stringify(state.cart))
    }
  },

  actions: {
    initializeCartFromLocalStorage(context) {
      const cartData = localStorage.getItem('cart')
      if (cartData) {
        context.commit('setCartFromLocalStorage', JSON.parse(cartData))
      }
    },
    async addToCartAction(context, data) {
      const $toast = useToast()
      const result = await database.getDetailProduct(data.id)
      const product = result.currentProduct
      const quanity = result.quanity

      if (product && quanity > 0) {
        const existing = context.state.cart.productList.find(p => p.id === data.id)
        if (!existing) {
          context.commit('addToCart', {
            ...product,
            countInCart: 1,
            checkOutSumary: product.price
          })
          $toast.open({ message: 'Thêm vào giỏ hàng thành công!', type: 'success', position: 'top-right' })
          return true
        } else if (existing.countInCart < quanity) {
          existing.countInCart++
          existing.checkOutSumary = existing.price * existing.countInCart
          const index = context.state.cart.productList.findIndex(p => p.id === data.id)
          context.commit('updateCart', {
            countInCart: existing.countInCart,
            checkOutSumary: existing.checkOutSumary,
            index,
            count: context.state.cart.count + 1
          })
          $toast.open({ message: 'Thêm vào giỏ hàng thành công!', type: 'success', position: 'top-right' })
          return true
        } else {
          $toast.open({ message: 'Sản phẩm đã đạt số lượng tối đa!', type: 'error', position: 'top-right' })
        }
      } else {
        $toast.open({ message: 'Sản phẩm đã hết hàng!', type: 'error', position: 'top-right' })
      }
      return false
    },
    removeProductAction(context, data) {
      setTimeout(() => context.commit('removeProduct', data.id), 150)
    },
    changeAmountProductsAction(context, data) {
      setTimeout(() => context.commit('changeAmountProducts', data), 150)
    }
  }
})