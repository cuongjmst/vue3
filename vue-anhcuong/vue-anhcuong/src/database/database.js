import axios from 'axios'

const BASE_URL = import.meta.env.VITE_BE_URL || 'http://127.0.0.1:8000'

export default {
  async getIndexProducts() {
    try {
      const res = await axios.get(`${BASE_URL}/api/product`)
      const data = res.data.data
      return {
        allProducts: data.product || [],
        newProducts: data.newProduct || [],
        hotProducts: data.hotProduct || []
      }
    } catch (err) {
      return { allProducts: [], newProducts: [], hotProducts: [], error: err.message }
    }
  },

  async getDetailProduct(id) {
    try {
      const res = await axios.get(`${BASE_URL}/api/product/${id}`)
      return {
        currentProduct: res.data.data,
        quanity: res.data.data?.quanity || 0
      }
    } catch (err) {
      return { currentProduct: null, quanity: 0, error: err.message }
    }
  }
}