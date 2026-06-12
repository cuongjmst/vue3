<template>
  <div class="main">
    <div class="top-main">
      <!-- Sidebar trái -->
      <aside class="aside">
        <div class="category">
          <CategoryMenuRow v-for="cat in categories" :key="cat" :title="cat" />
        </div>

        <div class="aside-block">
          <AsideTitle title="HỖ TRỢ TRỰC TUYẾN" />
          <div class="support-info">
            <p class="support-label">📞 08 888 03 999</p>
            <p class="support-label">✉ sieuthimaytinhls@gmail.com</p>
          </div>
        </div>

        <div class="aside-block">
          <AsideTitle title="SẢN PHẨM BÁN CHẠY" />
          <div class="best-seller-viewport" ref="viewport">
            <div class="best-seller-list" ref="bsList">
              <BestSellerItem
                v-for="n in 6"
                :key="n"
                title="Laptop Dell Inspiron 14 AMD Ryzen 5"
                thumbnailUrl="/img/sanpham5.jpg"
                price="18.000.000đ"
                status="Sẵn hàng"
              />
            </div>
          </div>
        </div>

        <div class="aside-block">
          <AsideTitle title="TIN TỨC MỚI" />
          <div class="news-list">
            <div class="news-item" v-for="news in newsList" :key="news.title">
              <span class="news-title">{{ news.title }}</span>
            </div>
          </div>
        </div>
      </aside>

      <!-- Nội dung chính -->
      <router-view class="route-content" />
    </div>

    <!-- Phần dưới -->
    <div class="bottom-main">
      <div class="commits">
        <div class="commit" v-for="c in commits" :key="c.title">
          <div class="commit-icon">{{ c.icon }}</div>
          <div>
            <span class="commit-title">{{ c.title }}</span>
            <span class="commit-detail">{{ c.detail }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import AsideTitle from './AsideTitle.vue'
import BestSellerItem from './BestSellerItem.vue'
import CategoryMenuRow from './CategoryMenuRow.vue'

export default {
  name: 'AppMain',
  components: { AsideTitle, BestSellerItem, CategoryMenuRow },

  setup() {
    const bsList = ref(null)
    let currentY = 0

    const scrollBestSeller = (direction) => {
      if (!bsList.value) return
      const itemH = 80
      currentY += direction * itemH
      if (currentY > 0) currentY = 0
      bsList.value.style.transform = `translateY(${currentY}px)`
      bsList.value.style.transition = 'transform 0.5s ease'
    }

    onMounted(() => {
      setInterval(() => scrollBestSeller(-1), 4000)
    })

    return { bsList, scrollBestSeller }
  },

  data() {
    return {
      categories: [
        'Máy tính để bàn', 'Laptop', 'Máy in', 'Máy tính bảng',
        'Thiết bị mạng', 'Linh kiện máy tính', 'Phụ kiện', 'Phần mềm'
      ],
      newsList: [
        { title: 'Chính sách bảo vệ thông tin cá nhân người tiêu dùng' },
        { title: 'Top laptop gaming đáng mua nhất năm 2024' },
        { title: 'Hướng dẫn chọn mua máy tính phù hợp nhu cầu' }
      ],
      commits: [
        { icon: '🚚', title: 'GIAO HÀNG TOÀN QUỐC', detail: 'Nhận hàng từ 1-3 ngày' },
        { icon: '⭐', title: 'DỊCH VỤ CHUYÊN NGHIỆP', detail: 'Tư vấn hỗ trợ tận tình' },
        { icon: '📞', title: 'HOTLINE 08 888 03 999', detail: 'Kỹ thuật: 083 84 85 888' },
        { icon: '✅', title: 'BẢO ĐẢM CHẤT LƯỢNG', detail: 'Sản phẩm chính hãng, có VAT' }
      ]
    }
  }
}
</script>

<style scoped>
.main { width: 100%; }

.top-main {
  display: flex;
  gap: 20px;
  align-items: flex-start;
}

.aside {
  width: 250px;
  flex-shrink: 0;
}

.category {
  border: 1px solid #ccc;
  border-bottom: none;
}

.aside-block {
  margin-top: 20px;
}

.support-info {
  padding: 8px;
  font-size: 13px;
}

.support-label {
  margin: 5px 0;
  color: #333;
}

.best-seller-viewport {
  height: 400px;
  overflow: hidden;
}

.best-seller-list {
  display: flex;
  flex-direction: column;
}

.news-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
  padding: 8px;
}

.news-item { border-bottom: 1px solid #eee; padding-bottom: 8px; }

.news-title {
  font-size: 13px;
  color: #333;
  line-height: 1.4;
}

.route-content { flex: 1; min-width: 0; }

.bottom-main {
  margin-top: 30px;
  width: 100%;
}

.commits {
  display: flex;
  justify-content: space-between;
  padding: 20px 0;
  gap: 10px;
  flex-wrap: wrap;
}

.commit {
  display: flex;
  align-items: center;
  gap: 10px;
  width: calc(25% - 10px);
}

.commit-icon { font-size: 32px; }

.commit-title {
  display: block;
  color: #D92037;
  font-weight: 700;
  font-size: 13px;
}

.commit-detail {
  display: block;
  font-size: 12px;
  color: #555;
}

@media (max-width: 900px) {
  .aside { display: none; }
  .commit { width: calc(50% - 10px); }
}
</style>