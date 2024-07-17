<template>
	<view>
		<!--pages/paySuccess/paySuccess.wxml-->
		<image src="/static/img/success.png" mode="widthFix" class="img"></image>
		<view class="text">支付成功</view>
		<view class="btn" @click="toOrder">查看详情</view>
	</view>
</template>

<script>
	const app = getApp()
	export default {
		data() {
			return {

			}
		},
		onLoad(options) {
			this.$fn.setTitle()
		},
		methods: {
			toOrder() {
				uni.reLaunch({
					url: '/pages/order/order',
				})
			},
		}
	}
</script>

<style>
	/* pages/paySuccess/paySuccess.wxss */
	page {
		background-color: #F1F1F1;
		text-align: center;
	}

	.img {
		width: 198rpx;
		margin-top: 137rpx;
	}

	.text {
		font-size: 36rpx;
		margin-top: 63rpx;
	}

	.btn {
		width: 640rpx;
		line-height: 90rpx;
		border-radius: 50rpx;
		margin: 118rpx auto 0 auto;
		color: #ffffff;
		background-color: #1B82F8;
		font-size: 32rpx;
	}
</style>