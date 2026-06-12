<template>
  <div class="main-container">
    <!-- Banner slider -->
    <div class="main-banner">
      <div class="banner-wrapper">
        <img
          v-for="(src, idx) in banners"
          :key="idx"
          :src="src"
          :class="['banner-img', { 'active-banner': currentBanner === idx }]"
          :alt="`banner-${idx}`"
        />
      </div>
      <button class="slide-btn left-slide" @click="goToBanner(-1)">‹</button>
      <button class="slide-btn right-slide" @click="goToBanner(1)">›</button>
    </div>

    <!-- Tab Mới / Hot -->
    <div class="list-product-container">
      <div class="list-product">
        <div class="list-product-header">
          <button class="tab-btn" :class="{ 'tab-active': showNew }" @click="showNew = true">
            SẢN PHẨM MỚI
          </button>
          <button class="tab-btn" :class="{ 'tab-active': !showNew }" @click="showNew = false">
            SẢN PHẨM HOT
          </button>
          <a href="#" class="view-all-link">Xem tất cả</a>
        </div>

        <div class="products">
          <template v-if="showNew">
            <ProductCard
              v-for="p in newProducts"
              :key="p.product_id"
              :id="p.product_id"
              :title="p.title"
              :thumbnailUrl="p.url"
              :price="p.price"
              :quanity="p.quanity"
            />
          </template>
          <template v-else>
            <ProductCard
              v-for="p in hotProducts"
              :key="p.product_id"
              :id="p.product_id"
              :title="p.title"
              :thumbnailUrl="p.url"
              :price="p.price"
              :quanity="p.quanity"
            />
          </template>
          <div v-if="loading" class="loading-text">Đang tải sản phẩm...</div>
        </div>
      </div>

      <!-- Tất cả sản phẩm -->
      <div class="list-product" v-if="allProducts.length">
        <div class="list-product-header">
          <button class="tab-btn tab-active">TẤT CẢ SẢN PHẨM</button>
        </div>
        <div class="products">
          <ProductCard
            v-for="p in allProducts"
            :key="p.product_id"
            :id="p.product_id"
            :title="p.title"
            :thumbnailUrl="p.url"
            :price="p.price"
            :quanity="p.quanity"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'
import ProductCard from '../Product/Product.vue'
import database from '@/database/database'

export default {
  name: 'MainIndex',
  components: { ProductCard },

  setup() {
    const showNew = ref(true)
    const currentBanner = ref(0)
    const banners = [
      '/img/main-banner.png',
      '/img/main-banner1.png',
      '/img/main-banner2.png'
    ]
    let timer = null

    const goToBanner = (dir) => {
      currentBanner.value = (currentBanner.value + dir + banners.length) % banners.length
    }

    onMounted(() => { timer = setInterval(() => goToBanner(1), 3500) })
    onUnmounted(() => { if (timer) clearInterval(timer) })

    return { showNew, currentBanner, banners, goToBanner }
  },

  data() {
    return {
      allProducts: [],
      newProducts: [],
      hotProducts: [],
      loading: true
    }
  },

  async created() {
    const data = await database.getIndexProducts()
    this.allProducts = data.allProducts || []
    this.newProducts = data.newProducts || []
    this.hotProducts = data.hotProducts || []
    this.loading = false
  }
}
</script>

<style scoped>
.main-container { width: 100%; }

.main-banner {
  position: relative;
  width: 100%;
  overflow: hidden;
}

.banner-wrapper {
  position: relative;
  width: 100%;
}

.banner-img {
  width: 100%;
  display: none;
}

.banner-img.active-banner {
  display: block;
}

.slide-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 36px;
  height: 36px;
  background: rgba(0,0,0,0.35);
  border: none;
  border-radius: 50%;
  color: #fff;
  font-size: 22px;
  cursor: pointer;
  line-height: 1;
}

.slide-btn:hover { background: rgba(0,0,0,0.6); }
.left-slide { left: 10px; }
.right-slide { right: 10px; }

.list-product-container {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.list-product-header {
  display: flex;
  align-items: center;
  background: #F1F1F1;
  border-bottom: 3px solid #EF233C;
}

.tab-btn {
  padding: 10px 16px;
  border: none;
  background: transparent;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  color: #333;
}

.tab-btn.tab-active {
  background: #EF233C;
  color: #fff;
}

.view-all-link {
  margin-left: auto;
  margin-right: 12px;
  font-size: 12px;
  color: #888;
  text-decoration: none;
}

.products {
  display: flex;
  flex-wrap: wrap;
  border: 1px solid #ccc;
  border-right: none;
  border-bottom: none;
}

.loading-text {
  padding: 30px;
  text-align: center;
  color: #888;
  width: 100%;
}
</style>