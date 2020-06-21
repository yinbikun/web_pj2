<template>
  <el-main class="profile-item">
    <el-card>
      <div slot="header" class="clearfix">
        我的照片
      </div>
      <el-row>
        <el-col>
          <detail-item
              :span="6"
              v-for="item in imageList"
              :key="item.ImageID"
              :image-id="item.ImageID"
              :image-uri="item.PATH"
              :title="item.Title"
              :introduce="item.Description"
              @onClick="onClickDetailItemHandler(item)">
          </detail-item>
        </el-col>
        <el-col>
          <el-pagination
              background
              layout="prev, pager, next"
              :page-count="pageInfo.totalPage"
              :total="pageInfo.totalNum"
              :page-size="pageInfo.pageSize"
              :current-page="pageInfo.pageNo"
              @current-change="onSelectPageHandler">
          </el-pagination>
        </el-col>
      </el-row>
    </el-card>
  </el-main>
</template>

<script>
  import DetailItem from "@/views/components/DetailItem";
  import {personalMyPics} from "@/api";

  export default {
    name: "MyPhoto",
    components: {DetailItem},
    data() {
      return {
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
      this.searchImageListByPage(this.pageInfo.pageNo, this.pageInfo.pageSize);
    },
    methods: {
      onSelectPageHandler(index) {
        this.searchImageListByPage(index, this.pageInfo.pageSize);
      },
      onClickDetailItemHandler(item) {
        this.$router.push({
          name: "Detail",
          query: {
            did: item.ImageID
          }
        });
      },
      searchImageListByPage(pageNo, pageSize) {
        personalMyPics({
          page: pageNo,
          pageSize: pageSize,
          uid: this.$store.state.userInfo.UID
        }).then(result => {
          const res = result ? result.data : void 0;
          this.imageList.splice(0, this.imageList.length);
          if (res && res.success) {
            // 加载列表
            res.data.list.map(item => {
              this.imageList.push(item);
            });
            // 设置分页参数
            Object.assign(this.pageInfo, res.data.pageInfo);
            this.pageInfo.pageNo = pageNo;
          }else{
            this.$message.error(res.msg)
          }
        })
      }
    }
  }
</script>

<style lang="less" scoped>
  .profile-item {
    padding:2vh 8vw;
    min-height: calc(100vh - 181px);
  }
</style>