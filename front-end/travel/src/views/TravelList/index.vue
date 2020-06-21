<template>
  <el-container>
    <el-aside width="20vw">
      <el-card class="box-card">
        <div slot="header" class="clearfix">搜索图片</div>
        <el-input
            placeholder="请输入关键字"
            v-model="searchKeywords">
          <el-button slot="append" icon="el-icon-search" @click="searchClickHandler"></el-button>
        </el-input>
      </el-card>
      <el-card class="box-card">
        <div slot="header" class="clearfix">热门国家</div>
        <el-tag v-for="(item,index) in CountryListArr" :key="index" type="danger" class="fast-country-item" @click="countryClickHandler(item.ISO)">{{item.name}}({{item.count}})
        </el-tag>
      </el-card>
      <el-card class="box-card">
        <div slot="header" class="clearfix">热门城市</div>
        <el-tag v-for="(item,index) in CityListArr" :key="index" type="warning" class="fast-country-item" @click="cityClickHandler(item.id)">{{item.name}}({{item.count}})
        </el-tag>
      </el-card>
      <el-card class="box-card">
        <div slot="header" class="clearfix">热门风景</div>
        <el-tag v-for="(item,index) in StyleListArr" :key="index" class="fast-country-item" @click="styleClickHandler(item.Content)">{{item.Content}}({{item.count}})</el-tag>
      </el-card>
    </el-aside>
    <el-main>
      <!-- 筛选 -->
      <el-form :inline="true" style="margin-left: 2vw" :model="listFilterForm">
        <el-form-item label="风格">
          <el-select v-model="listFilterForm.listStyle" placeholder="根据风格筛选">
            <el-option
                    v-for="(item,index) in ContentListSelectArr"
                    :key="index"
                    :label="item.name"
                    :value="item.name"
            ></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="国家">
          <el-select v-model="listFilterForm.listCountry" placeholder="根据国家筛选" @change="selectCurCountry">
            <el-option
                    v-for="(item,index) in CountryListSelectArr"
                    :key="index"
                    :label="item.Country_RegionName"
                    :value="item.ISO">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="城市">
          <el-select v-model="listFilterForm.listCityNew" placeholder="根据城市筛选">
            <el-option
                    v-for="(item,index) in CityListSelectArr"
                    :key="index"
                    :label="item.AsciiName"
                    :value="item.GeoNameID">
            </el-option>
          </el-select>
          <el-form-item>
            <el-button type="primary" @click="onListFilter">筛选</el-button>
          </el-form-item>
        </el-form-item>
      </el-form>
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
    </el-main>
  </el-container>
</template>

<script>
  import DetailItem from "@/views/components/DetailItem";
  import {homeHotList,homePicsList,homeCountryList,homeCityList} from "@/api";
  export default {
    name: 'TravelList',
    components: {DetailItem},
    data() {
      return {
        searchKeywords: "",
        listFilterForm: {
          listStyle: "",
          listCountry: "",
          listCityNew: "",
          listCity: "",
        },
        pageInfo: {
          pageNo: 1,
          pageSize: 12,
          totalNum: 12,
          totalPage: 1
        },
        imageList: [],
        StyleListArr: [],
        ContentListSelectArr: [
          {name:"Scenery"},
          {name:"City"},
          {name:"People"},
          {name:"Animal"},
          {name:"Building"},
          {name:"Wonder"},
          {name:"Other"}
        ],
        CountryListArr: [],
        CountryListSelectArr: [],
        CityListSelectArr: [],
        CityListArr: []
      }
    },
    methods: {
      getHostList(){
        homeHotList().then(res => {
          if (res && res.data.success) {
            var data = res.data.data;
            this.CountryListArr = data.countryList;
            this.CityListArr = data.cityList;
            this.StyleListArr = data.contentList;
          }
        });
      },
      getHomeCountryList(){
        homeCountryList().then(res => {
          this.CountryListSelectArr = res.data.data;
        });
      },
      countryClickHandler(val){
        this.listFilterForm.listCity = "";
        this.listFilterForm.listStyle = "";
        this.listFilterForm.listCountry = val;
        this.getImageListByPage(this.pageInfo.pageNo, this.pageInfo.pageSize);
      },
      styleClickHandler(val){
        this.listFilterForm.listStyle = val;
        this.listFilterForm.listCity = "";
        this.listFilterForm.listCountry = "";
        this.getImageListByPage(this.pageInfo.pageNo, this.pageInfo.pageSize);
      },
      cityClickHandler(val){
        this.listFilterForm.listCity = val;
        this.listFilterForm.listCountry = "";
        this.listFilterForm.listStyle = "";
        this.getImageListByPage(this.pageInfo.pageNo, this.pageInfo.pageSize);
      },
      onListFilter() {
        this.searchKeywords = "";
        const pageInfo = {
          pageNo: 1,
          pageSize: 12,
          totalNum: 12,
          totalPage: 1
        }
        Object.assign(this.pageInfo, pageInfo);
        this.getImageListByPage(this.pageInfo.pageNo, this.pageInfo.pageSize);
      },
      selectCurCountry(){
        var listCountry = this.listFilterForm.listCountry;
        this.listFilterForm.listCity = "";
        this.CityListSelectArr = [];
        if(listCountry) {
          var data = {country:listCountry};
          homeCityList(data).then(res => {
            this.CityListSelectArr = res.data.data;
          });
        }
      },
      onClickDetailItemHandler(item) {
        console.log(item);
        this.$router.push({
          name: "Detail",
          query: {
            did: item.ImageID
          }
        });
      },
      onSelectPageHandler(index) {
        this.getImageListByPage(index, this.pageInfo.pageSize);
      },
      searchClickHandler(){
        const pageInfo = {
          pageNo: 1,
          pageSize: 12,
          totalNum: 12,
          totalPage: 1
        }
        this.listFilterForm.listCountry ="";
        this.listFilterForm.listCity="";
        Object.assign(this.pageInfo, pageInfo);
        this.getImageListByPage(this.pageInfo.pageNo, this.pageInfo.pageSize);
      },
      getImageListByPage(pageNo, pageSize) {
        const searchParam = {
          page: pageNo,
          pageSize: pageSize
        }
        if (this.searchKeywords) {
          searchParam.title = this.searchKeywords;
        }
        if(this.listFilterForm.listCountry){
          searchParam.country = this.listFilterForm.listCountry;
        }
        if(this.listFilterForm.listCity){
          searchParam.city = this.listFilterForm.listCity;
        }
        if(this.listFilterForm.listStyle){
          searchParam.content = this.listFilterForm.listStyle;
        }
        homePicsList({
          ...searchParam
        }).then(res => {
          this.imageList.splice(0, this.imageList.length);
          if (res && res.data.success) {
            // 加载列表
            res.data.data.list.map(item => {
              this.imageList.push(item);
            });
            // 设置分页参数
            Object.assign(this.pageInfo, res.data.data.pageInfo);
            this.pageInfo.pageNo = pageNo;
          }
        })
      }
    },
    mounted() {
      this.getHomeCountryList();
    },
    created() {
      this.getHostList();
      // 初始化查询图片列表
      this.getImageListByPage(this.pageInfo.pageNo, this.pageInfo.pageSize);
    }
  }
</script>
<style lang="less" scoped>
  .clearfix:before,
  .clearfix:after {
    display: table;
    content: "";
  }

  .text {
    font-size: 14px;
  }

  .item {
    margin-bottom: 18px;
  }

  .clearfix:after {
    clear: both
  }

  .fast-country-item {
    margin: 5px 10px;

    &:hover {

    }
  }
</style>