<template>
	<view>
		<!-- <image src="/static/img/bg_index.png" class="bg" mode="scaleToFill"></image> -->
		<image :src="banner" class="banner" mode="scaleToFill"></image>
		<view class="cont">
			<scroll-view scroll-y="true" class="left">
				<block v-for="(item,index) in list" :key="index">
					<view class="item" :class="listIndex == item.id ? 'active':'' " @click="sortChange"
						:data-id="item.id">{{item.class_name}}</view>
				</block>
			</scroll-view>
			<scroll-view scroll-y="true" class="right">
				<block v-for="(item,index) in goods" :key="index">
					<button class="item" open-type="contact" :session-from="item.goods_name">
						<image :src="item.pic" class="pic" mode="scaleToFill"></image>
						<view class="info">
							<view class="name">{{item.goods_name}}</view>
							<view class="text">{{item.subtitle}}</view>
							<view class="price">
								<view class="red">￥<b class="b">{{item.sale_price}}</b>起</view>/件
							</view>
						</view>
					</button>
				</block>
			</scroll-view>
		</view>
	</view>
</template>

<script>
	const app = getApp()
	export default {
		data() {
			return {
				banner: '', //顶部图片
				listIndex: 0,
				list: [], //分类列表
				goods: []
			}
		},
		onLoad() {
			this.getConfig()
			this.getTypeList()
		},
		methods: {
			sortChange(e) { //切换分类
				console.log(e.currentTarget.dataset.id)
				this.listIndex = e.currentTarget.dataset.id
				this.getGoodsList()
			},
			toContact(e) { //点击商品回调
				console.log(e)
			},
			getConfig() { //获取配置信息
				this.$fn.getConfig({}, res => {
					// console.log(res.data.data)
					app.globalData.config = res.data.data
					this.config = res.data.data
					this.miniName = res.data.data.wxtitle
					this.banner = res.data.data.shoptop_logo
					this.$fn.setTitle()
				})
			},
			getTypeList(id) { //获取分类 
				this.$fn.getTypeList(res => {
					this.list = res.data.data
					this.listIndex = res.data.data[0].id
					this.getGoodsList()
				})
			},

			getGoodsList() { //获取商品
				this.$fn.getGoodsList({
					class_id: this.listIndex
				}, res => {
					this.goods = res.data.data
				})
			},




		}
	}
</script>

<style lang="less" scoped>
	.bg {
		width: 100%;
		height: 290rpx;
		position: absolute;
		top: 0;
		left: 0;
		z-index: -1;
	}

	.banner {
		width: 710rpx;
		height: 205rpx;
		margin: 25rpx auto;
		display: block;
		border-radius: 20rpx;
	}

	.cont {
		width: 100%;
		height: calc(100vh - 255rpx);
		display: flex;
		justify-content: space-between;

		.left {
			width: 170rpx;
			line-height: 100rpx;
			text-align: center;
			background-color: #fff;

			.item {
				font-size: 28rpx;
			}

			.active {
				color: #1B82F8;
				position: relative;

				&::after {
					content: '';
					display: block;
					width: 36%;
					height: 4px;
					background-color: #1B82F8;
					border-radius: 10px;
					position: absolute;
					left: 32%;
					bottom: 15rpx;
				}
			}
		}

		.right {
			width: 580rpx;
			padding: 0 25rpx;
			box-sizing: border-box;

			.item {
				width: 100%;
				background-color: #fff;
				border-radius: 10px;
				box-sizing: border-box;
				padding: 10px !important;
				margin: 0 0 20rpx 0 !important;
				display: flex;
				justify-content: space-between;

				.pic {
					width: 190rpx;
					height: 190rpx;
					display: block;
				}

				.info {
					text-align: left;
					margin-left: 20rpx;
					line-height: normal;
					width: calc(100% - 200rpx);

					.name {
						font-weight: bold;
						font-size: 30rpx;
						margin-bottom: 15px;
						width: 100%;
						overflow: hidden;
						white-space: nowrap;
						text-overflow: ellipsis;
					}

					.text {
						font-size: 24rpx;
						color: #999999;
						margin-bottom: 15px;
						width: 100%;
						overflow: hidden;
						text-overflow: ellipsis;
						white-space: nowrap;
						// -webkit-line-clamp: 2;
						// display: -webkit-box;
						// -webkit-box-orient: vertical;
					}

					.price {
						font-size: 24rpx;
						color: #999999;

						.red {
							color: #f32f2f;
							display: inline-block;
							padding-right: 5rpx;

							.b {
								font-size: 36rpx;
								display: inline-block;
							}
						}
					}
				}

			}
		}
	}
</style>