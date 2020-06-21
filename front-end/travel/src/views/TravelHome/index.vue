<template>
  <el-container>
    <el-main>
      <!-- 顶部滚动图片 -->
      <el-carousel trigger="click" :interval="5000" height="50vh">
        <el-carousel-item v-for="(imgSrc,key) in carouselImages" :key="key">
          <img class="carousel-item" :src="imgSrc.PATH"/>
        </el-carousel-item>
      </el-carousel>
      <!-- 列表 -->
      <el-row>
        <el-col>
          <detail-item
              v-for="item in imageList"
              :key="item.ImageID"
              :image-id="item.ImageID"
              :image-uri="item.PATH"
              :title="item.Title"
              :introduce="item.Description"
              @onClick="onClickDetailItemHandler(item)"
          ></detail-item>
        </el-col>
        <el-col>
          <el-pagination
              background
              layout="prev, pager, next"
              :page-count="pageInfo.totalPage"
              :total="pageInfo.totalNum"
              :page-size="pageInfo.pageSize"
              :current-page="pageInfo.pageNo"
              @current-change="onSelectPageHandler"
          >
          </el-pagination>
        </el-col>
      </el-row>
      <el-button circle type="primary" :loading="loading" icon="el-icon-refresh-right" class="refreshAllimg" @click="onClickRefreshAllImg"></el-button>
    </el-main>
  </el-container>
</template>

<script>
  import DetailItem from "@/views/components/DetailItem";
  import {homePicsList,homeBannerList, IMAGE_PREFIX} from "@/api"

  export default {
    name: 'TravelHome',
    components: {DetailItem},
    data() {
      return {
        loading: false,
        carouselImages: [],
        imageList: [],
        pageInfo: {
          pageNo: 1,
          pageSize: 12,
          totalNum: 12,
          totalPage: 1
        }
      }
    },
    created() {
      // 初始化查询图片列表
      this.getImageListByPage(1, 12);
      this.getHomeBannerList();
    },
    methods: {
      getHomeBannerList(){
        homeBannerList().then(res => {
          if (res && res.data.success) {
            var lists = res.data.data;
            lists.forEach(function(item) {
              item.PATH = IMAGE_PREFIX + item.PATH;
            });
            this.carouselImages = lists;
          }
        });
      },
      onSelectPageHandler(index) {
        this.getImageListByPage(index, this.pageInfo.pageSize);
      },
      onClickRefreshAllImg(){
        this.loading = true;
        homePicsList({
          page: this.pageInfo.pageNo,
          pageSize: this.pageInfo.pageSize,
          random: 1
        }).then(res => {
          if (res && res.data.success) {
            this.loading = false;
            this.imageList.splice(0, this.imageList.length);
            res.data.data.list.map(item => {
              this.imageList.push(item);
            });
            Object.assign(this.pageInfo, res.data.data.pageInfo);
          }
        })
      },
      getImageListByPage(pageNo, pageSize) {
        homePicsList({
          page: pageNo,
          pageSize: pageSize
        }).then(res => {
          if (res && res.data.success) {
            // 加载列表
            this.imageList.splice(0, this.imageList.length);
            res.data.data.list.map(item => {
              this.imageList.push(item);
            });
            // 设置分页参数
            Object.assign(this.pageInfo, res.data.data.pageInfo);
            this.pageInfo.pageNo = pageNo;
          }
        })
      },
      onClickDetailItemHandler(item) {
        this.$router.push({
          name: "Detail",
          query: {
            did: item.ImageID
          }
        });
      }
    }
  }
</script>
<style lang="less" scoped>
  .carousel-item {
    height: 50vh;
    width: 100%;
    object-fit: cover;
  }
  .refreshAllimg {
    position: fixed;
    bottom: 10vh;
    right: 5vh;
  }
</style>