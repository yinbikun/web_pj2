<template>
  <el-main>
    <el-row v-if="detailId" class="detail-item">
      <el-col :span="24">
        <el-button @click="toBack" icon="el-icon-arrow-left" size="small">返回</el-button>
      </el-col>
      <el-col :span="8">
        <h1>{{title}}</h1>
        <el-image
            class="detail-image"
            :src="url"
            :preview-src-list="[url]">
        </el-image>
      </el-col>
      <el-col :span="16">
        <h3>详细信息</h3>
        <el-button @click="setCollect" type="success" icon="el-icon-star-off" v-if="!collectInfo.is_collect">
          收藏（共有{{collectInfo.collect_count}}人收藏）
        </el-button>
        <el-button @click="setCollect" type="warning" icon="el-icon-star-on" v-if="collectInfo.is_collect">
          取消收藏（共有{{collectInfo.collect_count}}人收藏）
        </el-button>
        <el-button @click="editVisible = true" type="primary" icon="el-icon-edit" v-if="isMyPhoto">
          编辑
        </el-button>
        <el-button @click="deleteImage" type="danger" icon="el-icon-delete" v-if="isMyPhoto">
          删除
        </el-button>
        <el-table
            :data="tableData"
            stripe
            style="width: 100%">
          <el-table-column
              prop="title"
              label="图片详情"
              width="180">
          </el-table-column>
          <el-table-column
              prop="val"
              label="">
          </el-table-column>
        </el-table>
      </el-col>
    </el-row>
    <el-row v-if="!detailId" class="detail-item">
      <el-col :span="24">
        <el-button @click="toBack" icon="el-icon-arrow-left" size="small">返回</el-button>
      </el-col>
      <el-col :span="24">
        <h1>没有找到该图片!</h1>
      </el-col>
    </el-row>
    <el-dialog
        title="编辑"
        :visible.sync="editVisible"
        width="30%"
        :before-close="handleClose">
      <edit ref="editCard" :defaultValue="originalData"></edit>
      <span slot="footer" class="dialog-footer">
        <el-button @click="editVisible = false">取 消</el-button>
        <el-button type="primary" @click="handleOk">确 定</el-button>
      </span>
    </el-dialog>
  </el-main>
</template>

<script>
  import {homePicDetail, personalAddCollect, personalDelete, IMAGE_PREFIX} from "@/api"
  import Edit from "@/views/TravelDetail/Edit";

  export default {
    name: 'TravelDetail',
    data() {
      return {
        title: "",
        detailId: 0,
        userId: 0,
        notFound: false,
        url: "",
        tableData: [],
        collectInfo: {
          collect_count: 0,
          is_collect: 0
        },
        originalData: {},
        editVisible: false
      }
    },
    created() {
      if (this.$route.query.did)
        this.detailId = this.$route.query.did;
      else this.notFound = true;
      this.initImageInfo();
    },
    components: {Edit},
    computed: {
      isMyPhoto() {
        return this.userId === this.$store.state.userInfo.UID;
      }
    },
    methods: {
      //弹窗确定
      handleOk(){
        this.$refs.editCard.onSubmit();
        this.editVisible=false
      },
      initImageInfo() {
        // 图片详情
        homePicDetail({
          id: this.detailId,
          uid: this.$store.state.userInfo.UID
        }).then(result => {
          const res = result ? result.data : void 0;
          if (res && res.success) {
            Object.assign(this.collectInfo, {
              collect_count: res.data.collect_count,
              is_collect: res.data.is_collect,
            });
            this.url = `${IMAGE_PREFIX}${res.data.PATH}`;
            this.title = res.data.Title;
            const tableData = [{
              title: '名称',
              val: res.data.Title
            }, {
              title: '作者',
              val: res.data.userName
            }, {
              title: '介绍',
              val: res.data.Description
            }, {
              title: '风格',
              val: res.data.Content
            }, {
              title: '国家',
              val: res.data.countryName
            }, {
              title: '城市',
              val: res.data.cityName
            }];
            tableData.forEach(item => {
              this.tableData.push(item);
            });
            this.userId = res.data.UID;
            this.originalData = res.data;
          }
        });
      },
      setCollect() {
        // 收藏详情
        personalAddCollect({
          imgId: this.detailId,
          uid: this.$store.state.userInfo.UID
        }).then(result => {
          const res = result ? result.data : void 0;
          if (res && res.success) {
            Object.assign(this.collectInfo, res.data);
          }
        })
      },
      toBack() {
        this.$router.go(-1);//返回上一层
      },
      handleClose(done) {
        this.$confirm('确认关闭？')
            .then(_ => {
              done();
            })
            .catch(_ => {
            });
      },
      deleteImage() {
        this.$confirm('是否确认删除该图片?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          personalDelete({id: this.detailId, uid: this.userId}).then(result => {
            const res = result ? result.data : void 0;
            if (res && res.success) {
              this.$message({
                type: 'success',
                message: '删除成功!'
              });
            }
          })
        });
      }
    }
  }
</script>
<style lang="less" scoped>
  .detail-item {
    padding: 0 8vw;
    min-height: calc(100vh - 181px);
  }

  .detail-image {
    display: block;
    width: 80%;
    border-radius: 3%;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
  }
</style>