<template>
  <el-col :span="span" class="show-list-item">
    <el-card :body-style="{ padding: '0px' }">
      <el-image
          @click="onClickHandler"
          class="image"
          :src="imageUrl"
          fit="cover">
        <div slot="error" class="image-slot">
          <i class="el-icon-picture-outline"></i>
          未找到图片资源
        </div>
      </el-image>
      <div style="padding: 14px;">
        <span>{{title}}</span>
        <div class="bottom clearfix">
          <time class="introduce">
            {{introduce}}
          </time>
          <el-button type="text" @click="onClickHandler" class="button">查看详情</el-button>
        </div>
      </div>
    </el-card>
  </el-col>
</template>

<script>
  import {IMAGE_PREFIX} from "@/api"

  export default {
    name: "DetailItem",
    props: {
      span: {type: Number, default: 5},
      imageUri: {type: String, default: ""},
      title: {type: String, default: ""},
      introduce: {type: String, default: ""},
      imageId: {type: String, default: ""},
    },
    computed: {
      imageUrl() {

        if (this.imageUri)
          return `${IMAGE_PREFIX}${this.imageUri}`;
        else return "";
      }
    },
    methods: {
      onClickHandler() {
        this.$emit("onClick", this.imageId);
      }
    }
  }
</script>

<style lang="less" scoped>
  .image {
    width: 100%;
    height: 40vh;
  }

  .clearfix:before,
  .clearfix:after {
    display: table;
    content: "";
  }

  .clearfix:after {
    clear: both
  }

  .introduce {
    display: block;
    width: 100%;
    font-size: 13px;
    line-height: 20px;
    height: 20px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding-bottom: 10px;
    color: #999;
  }

  .bottom {
    margin-top: 13px;
    line-height: 12px;
  }

  .button {
    padding: 0;
    float: right;
  }

  .show-list-item {
    margin: 20px 2vw;
    transition: transform 300ms ease-in-out;

    &:hover {
      transform: scale(1.05);
      cursor: pointer;
    }
  }

</style>