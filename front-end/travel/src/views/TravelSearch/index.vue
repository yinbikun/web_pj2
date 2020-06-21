<template>
  <el-main>
    <el-row style="padding:0 8vw;">
      <el-col :span="24" style="padding:0 7vw 0 5vw;">
        <h1>搜索图片</h1>
        <el-input placeholder="请输入关键字" v-model="searchKeywords" class="input-with-select">
          <el-select v-model="searchType" slot="prepend" placeholder="请选择">
            <el-option label="按标题" value="1"></el-option>
            <el-option label="按国家" value="2"></el-option>
          </el-select>
          <el-button slot="append" @click="searchClickHandler" icon="el-icon-search"></el-button>
        </el-input>
      </el-col>
      <el-col :span="24" style="margin:0 3vw;">
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
      </el-col>
    </el-row>
  </el-main>
</template>

<script>
  import DetailItem from "@/views/components/DetailItem";
  import {homePicsList} from "@/api"

  export default {
    name: 'TravelSearch',
    components: {DetailItem},
    data() {
      return {
        searchKeywords: "",
        searchType: "1",
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
      searchClickHandler() {
        const pageInfo = {
          pageNo: 1,
          pageSize: 12,
          totalNum: 12,
          totalPage: 1
        }
        Object.assign(this.pageInfo, pageInfo);
        this.searchImageListByPage(this.pageInfo.pageNo, this.pageInfo.pageSize);
      },
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
        const searchParam = {
          page: pageNo,
          pageSize: pageSize
        }
        if (this.searchType === "1")
          searchParam.title = this.searchKeywords;
        if (this.searchType === "2")
          searchParam.country = this.searchKeywords;
        homePicsList({
          ...searchParam
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
          }
        })
      }
    }
  }
</script>
<style lang="less">
  .el-select .el-input {
    width: 130px;
  }

  .input-with-select .el-input-group__prepend {
    background-color: #fff;
  }
</style>