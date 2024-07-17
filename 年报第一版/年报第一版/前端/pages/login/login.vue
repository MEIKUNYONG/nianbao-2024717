<template>
	<view>
		<!--pages/login/login.wxml-->
		<image src="/static/img/loginBg.png" mode="widthFix" class="pageBg" />
		<image :src="config.wxlogo" mode="widthFix" class="logo"></image>
		<view class="name">{{miniName}}</view>
		<button class="loginBtn" open-type="getPhoneNumber" @getphonenumber="getPhone" v-if="isCheck">手机号快捷登录</button>
		<button class="loginBtn" @click="phone" v-else>手机号快捷登录</button>
		<view class="line">
			<checkbox-group @change="checkchange">
				<checkbox value="0" :checked="isCheck" />
			</checkbox-group>
			<view>
				登录即同意
				<text class="tit" @click="toPace" data-id="0">{{config.agreement_title}}</text>
				和
				<text class="tit" @click="toPace" data-id="1">{{config.privacy_title}}</text>
			</view>
		</view>

		<view class="mask" v-if="showPace"></view>
		<view class="pane" v-if="showPace">
			<view class="head">
				<view class="title">{{agreement_title}}</view>
				<i class="iconfont icon-cuo" @click="closePace"></i>
			</view>
			<scroll-view class="cont" scroll-y="true">
				<rich-text :nodes="agreement"></rich-text>
			</scroll-view>
			<view class="btn" @click="closePace">同意本协议</view>
		</view>
	</view>
</template>

<script>
	const app = getApp()
	export default {
		data() {
			return {
				config: [],
				miniName: '',
				isCheck: false,
				showPace: false, //是否显示协议弹窗
				paceIndex: 0, //当前显示的协议序号
				agreement: '',
				agreement_title: ''
			}
		},
		onLoad(options) {
			this.$fn.setTitle()
			this.config = app.globalData.config
		},
		methods: {
			checkchange(e) { //切换是否同意			
				this.isCheck = !this.isCheck
			},
			toPace(e) { //显示协议弹窗
				let id = e.currentTarget.dataset.id
				console.log(id)
				if (id == 0) {
					this.agreement_title = this.config.agreement_title
					this.agreement = this.config.agreement_content
					this.showPace = true
				} else if (id == 1) {
					this.agreement_title = this.config.privacy_title
					this.agreement = this.config.privacy_content
					this.showPace = true
				}
			},
			closePace() { //关闭协议弹窗
					this.showPace= false
					this.isCheck = true
			},
			phone() {
				uni.showToast({
					title: '请阅读并同意用户协议和隐私政策',
					icon: 'none'
				})
			},
			getPhone(e) { //获取手机号
				if (e.detail.code) {
					this.$fn.getPhone({
						code: e.detail.code
					}, res => {
						console.log(res.data.data)
						uni.setStorage({
							key: 'userInfo',
							data: res.data.data,
							success() {
								app.globalData.isLogin = true
								app.globalData.userInfo = res.data.data
								app.globalData.mobile = res.data.data.mobile
								uni.reLaunch({
									url: '/pages/index/index',
								})
							}
						})

					})
				}

			},
		}
	}
</script>

<style>
	/* pages/login/login.wxss */
	page {
		background-color: #ffffff;
	}

	.pageBg {
		position: fixed;
		left: 0;
		bottom: 0;
		width: 100%;
		z-index: -1;
	}

	.logo {
		width: 245rpx;
		margin: 170rpx auto 0 auto;
		display: block;
	}

	.name {
		text-align: center;
		font-size: 42rpx;
		color: #333333;
		font-weight: bold;
		margin-top: 45rpx;
	}

	.loginBtn {
		width: 645rpx !important;
		margin: 85rpx auto;
		display: block;
		line-height: 106rpx !important;
		padding: 0 !important;
		text-align: center;
		font-weight: normal !important;
		font-size: 32rpx !important;
		color: #ffffff;
		background-color: #1B82F8;
		border-radius: 10rpx !important;
	}

	.line {
		width: 90%;
		display: flex;
		text-align: center;
		justify-content: center;
		font-size: 28rpx;
		color: #999999;
		align-items: center;
		margin: 0 auto;
	}

	.line .tit {
		color: #1B82F8;
	}

	.line .wx-checkbox-input {
		width: 40rpx !important;
		height: 40rpx !important;
		border-radius: 50%;
	}

	.line .wx-checkbox-input.wx-checkbox-input-checked {
		border-color: #1B82F8 !important;
		background: #1B82F8 !important;
		color: #ffffff;
	}

	.line .wx-checkbox-input.wx-checkbox-input-checked::before {
		color: #ffffff;
		background: transparent;
		transform: translate(-50%, -50%) scale(0.6);
	}

	.pane {
		background-color: #ffffff;
		border-radius: 20rpx;
		z-index: 100;
		width: 627rpx;
		position: fixed;
		top: 100rpx;
		left: 50%;
		margin-left: -313.5rpx;
	}

	.pane .head {
		position: relative;
		height: 108rpx;
		line-height: 108rpx;
		text-align: center;
		font-size: 32rpx;
		font-weight: bold;
	}

	.pane .head .iconfont {
		display: block;
		position: absolute;
		right: 32rpx;
		top: 0;
		height: 108rpx;
		color: #666666;
		font-size: 30rpx;
	}

	.pane .cont {
		width: 560rpx;
		height: 663rpx;
		margin: 10rpx auto 49rpx auto;
		font-size: 24rpx;
	}

	.pane .btn {
		width: 289rpx;
		line-height: 90rpx;
		color: #ffffff;
		background-color: #1B82F8;
		font-size: 30rpx;
		text-align: center;
		border-radius: 45rpx;
		margin: 0 auto 49rpx auto;
	}
</style>