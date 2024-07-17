<template>
	<view>
		<!--pages/order/order.wxml-->
		<image src="/static/img/bg_index.png" class="bg" mode="widthFix"></image>
		<view class="logoBox">
			<image :src="config.topleft_logo" mode="widthFix" class="logo"></image>
			<image :src="config.topright_logo" mode="widthFix" class="logo"></image>
		</view>


		<view class="tabTitle">
			<view class="item" :class="tabIndex == 0 ? 'active':''" data-id="0" @click="tabCHange">全部</view>
			<view class="item" :class="tabIndex == 1 ? 'active':''" data-id="1" @click="tabCHange">待申报</view>
			<view class="item" :class="tabIndex == 2 ? 'active':''" data-id="2" @click="tabCHange">已申报</view>
			<view class="item" :class="tabIndex == 3 ? 'active':''" data-id="3" @click="tabCHange">申报失败</view>
		</view>
		<scroll-view scroll-y="true" class="list" v-if="list.length > 0">
			<block v-for="(item,index) in list" :key="index">
				<view class="item">
					<view class="top">
						<view class="orderId">订单编号：{{item.order_no}}</view>
						<view class="status">{{item.status}}</view>
					</view>
					<view class="textLine">企业名称：{{item.enterprise_name}}</view>
					<view class="textLine">收费项目：{{item.title}}</view>
					<view class="textLine">支付方式：{{item.pay_type}}</view>
					<view class="textLine">下单时间：{{item.pay_time}}</view>
					<view class="btm">实付款：<text class="red">￥<text class="bb">{{item.total_price}}</text></text></view>
				</view>
			</block>
		</scroll-view>

		<view class="empty" wx:else>
			<view class="iconfont icon-zanwuneirong"></view>
			<view class="text">暂无订单</view>
		</view>
	</view>
</template>

<script>
	const app = getApp()
	export default {
		data() {
			return {
				config: [],
				mobile: '',
				miniName: '', //小程序名称
				tabIndex: 0,
				list: [],
			}
		},
		onLoad(options) {
			this.miniName = app.globalData.config.wxtitle
			this.mobile = app.globalData.mobile
			this.config = app.globalData.config
			this.$fn.setTitle()
			this.getOrder(0)
		},
		methods: {
			tabCHange(e) { //切换标签				
				this.tabIndex = e.currentTarget.dataset.id
				this.getOrder(e.currentTarget.dataset.id)
			},
			getOrder(e) {
				this.$fn.getOrder({
					mobile: this.mobile,
					is_status: e
				}, res => {
					this.list = res.data.data
				})
			},
		}
	}
</script>

<style>
	/* pages/order/order.wxss */
	.bg {
		width: 100%;
		position: absolute;
		top: 0;
		left: 0;
		z-index: -1;
	}

	.logoBox {
		width: 100%;
		text-align: center;
		padding: 45rpx 0;
		box-sizing: border-box;
	}

	.logoBox .logo {
		width: 295rpx;
		margin: 0 15rpx;
	}

	.tabTitle {
		width: 703rpx;
		line-height: 88rpx;
		margin: 0 auto;
		background-color: #ffffff;
		border-radius: 10rpx;
		display: flex;
		justify-content: space-around;
		color: #666666;
		align-items: center;
	}

	.tabTitle .item {
		width: 25%;
		text-align: center;
		font-size: 28rpx;
	}

	.tabTitle .active {
		font-weight: bold;
		color: #333333;
		font-size: 32rpx;
		position: relative;
	}

	.tabTitle .active::after {
		display: block;
		content: '';
		width: 44rpx;
		height: 8rpx;
		background-color: #1B82F8;
		border-radius: 4rpx;
		position: absolute;
		left: 50%;
		bottom: 5rpx;
		margin-left: -22rpx;
	}

	.list {
		height: calc(100vh - 300rpx);
		width: 703rpx;
		margin: 28rpx auto 0 auto;
	}

	.list .item {
		background-color: #ffffff;
		width: 100%;
		border-radius: 10rpx;
		margin-bottom: 28rpx;
		box-sizing: border-box;
		padding: 0 28rpx;
	}

	.list .item .top {
		padding: 31rpx 0;
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 28rpx;
		color: #333333;
	}

	.list .item .top .status {
		color: #E23A2E;
		float: right;
	}

	.list .item .textLine {
		color: #666666;
		font-size: 24rpx;
		line-height: 48rpx;
	}

	.list .item .btm {
		line-height: 88rpx;
		font-size: 28rpx;
	}

	.list .item .btm .red {
		color: #E23A2E;
		font-weight: bold;
	}

	.list .item .btm .red .bb {
		font-size: 36rpx;
	}

	.empty {
		text-align: center;
		background-color: #ffffff;
		height: 500rpx;
		width: 703rpx;
		margin: 28rpx auto 0 auto;
		border-radius: 20rpx;
	}

	.empty .iconfont {
		width: 100%;
		font-size: 180rpx;
		color: #bbbbbb;
		padding-top: 100rpx;
		margin-bottom: 30rpx;
	}

	.empty .text {
		width: 100%;
		color: #bbbbbb;
		font-size: 28rpx;
	}
</style>