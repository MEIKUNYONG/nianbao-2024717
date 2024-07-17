<template>
	<view>
		<image src="/static/img/bg_index.png" class="bg" mode="widthFix"></image>
		<image :src="banner" mode="widthFix" class="banner"></image>
		<view class="form">

			<view class="item1" v-if="status == 0">
				<view class="left">申报主体</view>
				<view class="right">
					<radio-group @change="mainChange">
						<label class="label">
							<radio value="1" color="#1E81F8" />个体工商户
						</label>
						<label class="label">
							<radio value="2" color="#1E81F8" />公司
						</label>
						<label class="label">
							<radio value="3" color="#1E81F8" />合作社
						</label>
					</radio-group>
				</view>
			</view>

<!-- 			<view class="item" v-if="status == 1">
				<view class="label">选择地区</view>
				<view class="right">
					<picker mode="region" v-model="form1.area" placeholder="请选择地区" @change="areaChange">
						<view class="pla">{{form1.area}}</view>
					</picker>
					<image class="icon" src="../../static/img/down.png" mode="widthFix"></image>
				</view>
			</view> -->

			<view class="item">
				<view class="label">企业名称</view>
				<view class="right">
					<input type="text" v-model="form1.company" @input="toSearch" class="input" placeholder="请输入企业名称"
						placeholder-class="pla" />
				</view>

				<view class="list" v-if="isShowSearchList">
					<block v-for="(item,index) in searchList" :key="index">
						<view class="list_item" :data-id="index" @click="selectCompany">
							{{item.enterprise_name}}
						</view>
					</block>
				</view>

			</view>

			<view class="item">
				<view class="label">法人姓名</view>
				<view class="right">
					<input type="text" v-model="form1.name" class="input" placeholder="请输入法人姓名" placeholder-class="pla" />
				</view>
			</view>

			<view class="item">
				<view class="label">身份证号</view>
				<view class="right">
					<input type="idcard" v-model="form1.idCard" class="input" placeholder="请输入法人身份证号" placeholder-class="pla" />
				</view>
			</view>

			<view class="item">
				<view class="label">手机号码</view>
				<view class="right">
					<input type="tel" v-model="form1.phone" class="input" placeholder="请输入法人手机号码" placeholder-class="pla" />
				</view>
			</view>

			<view class="item" v-if="status == 1">
				<view class="label">备注</view>
				<view class="right">
					<input type="text" v-model="form1.notes" class="input" placeholder="请输入备注" placeholder-class="pla" />
				</view>
			</view>

			<button class="subBtn" @click="sub">提交</button>
		</view>
	</view>
</template>

<script>
	const app = getApp()
	export default {
		data() {
			return {
				isShowSearchList: false,
				searchList: [],
				banner: '',
				status: '',
				id: '',
				isQiang: 0, //是否强制填写
				form1: {
					main: '',
					company: '',
					name: '',
					idCard: '',
					phone: '',
					area: '请选择地区',
					notes: '',
					id: ''
				}
			}
		},
		onLoad(e) {
			console.log(e)
			this.status = e.status
			this.id = e.id
			this.isQiang = app.globalData.config.is_qiang
			this.$fn.setTitle()
			if (e.status == 0) {
				this.banner = app.globalData.config.qypic
			} else if (e.status == 1) {
				this.banner = app.globalData.config.ycpic
			} 
			
		},
		methods: {
			toSearch() {
				console.log(this.form1.company)
				if(this.form1.company!=""){
					this.$fn.getFormCompany({ keyword: this.form1.company }, res => {
						this.searchList = res.data.data
						this.isShowSearchList = true
					})
				}
				
			},
			selectCompany(e) { //选择公司
				let id = e.currentTarget.dataset.id
				console.log(id)
				this.form1.company = this.searchList[id].enterprise_name
				this.form1.name = this.searchList[id].legal_person
				this.form1.id = this.searchList[id].id
				this.isShowSearchList = false
				this.searchList = []
			},
			mainChange(e) {
				this.form1.main = e.detail.value
			},
			areaChange(e) {
				this.form1.area = e.detail.value.join('-')
			},
			sub() {
				console.log(this.form1)
				console.log(this.isQiang)
				if(this.isQiang==1){
					let idcard = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/
					let phoneReg = /^1[3-9]\d{9}$/
					if (this.form1.main == '' && this.status == 0) {
						wx.showToast({
							icon: 'none',
							title: "请选择申报主体"
						})
					} else if (this.form1.area == '请选择地区' && this.status == 1) {
						wx.showToast({
							icon: 'none',
							title: "请选择地区"
						})
					} else if (this.form1.company == '') {
						wx.showToast({
							icon: 'none',
							title: "请输入企业名称"
						})
					} else if (this.form1.name == '') {
						wx.showToast({
							icon: 'none',
							title: "请输入法人姓名"
						})
					} else if (this.form1.idCard == '') {
						wx.showToast({
							icon: 'none',
							title: "请输入法人身份证号"
						})
					} else if (idcard.test(this.form1.idCard) == false) {
						wx.showToast({
							icon: 'none',
							title: "身份证号不正确"
						})
					} else if (this.form1.phone == '') {
						wx.showToast({
							icon: 'none',
							title: "请输入法人手机号"
						})
					} else if (phoneReg.test(this.form1.phone) == false) {
						wx.showToast({
							icon: 'none',
							title: "手机号不正确"
						})
					} else {
						uni.navigateTo({
							url: '/pages/newDetail/newDetail?status=' + this.status + '&id=' + this.id + '&form=' + JSON.stringify(
								this.form1)
						})
					}
					
				}else{
					uni.navigateTo({
						url: '/pages/newDetail/newDetail?status=' + this.status + '&id=' + this.id + '&form=' + JSON.stringify(
							this.form1)
					})
				}
				

			}
		}
	}
</script>

<style lang="less">
	page {
		padding-bottom: 40rpx;
	}

	.bg {
		width: 100%;
		position: absolute;
		top: 0;
		left: 0;
		z-index: -1;
	}

	.banner {
		display: block;
		width: 90%;
		margin: 45rpx auto 0 auto;
	}

	.form {
		width: 700rpx;
		margin: 24rpx auto;

		.item1 {
			width: 100%;
			border-radius: 20rpx;
			background-color: #ffffff;
			padding: 24rpx;
			margin-bottom: 25rpx;
			box-sizing: border-box;
			font-size: 28rpx;

			.left {
				margin-bottom: 24rpx;
			}

			.right {

				.label {
					display: inline-block;
					padding-right: 24rpx;
				}

				radio {
					transform: scale(0.7);
				}
			}
		}

		.item {
			width: 100%;
			border-radius: 20rpx;
			background-color: #ffffff;
			padding: 0 24rpx;
			margin-bottom: 25rpx;
			box-sizing: border-box;
			font-size: 28rpx;
			display: flex;
			justify-content: space-between;
			align-items: center;
			line-height: 90rpx;
			position: relative;

			.list {
				width: 700rpx;
				max-height: 500rpx;
				overflow-y: auto;
				position: absolute;
				top: 95rpx;
				left: 0;
				background-color: #ffffff;
				border-radius: 20rpx;
				z-index: 10;
				box-shadow: 0 0 6rpx #dddddd;

				.list_item {
					padding: 0 24rpx;
					font-size: 28rpx;
					border-bottom: 1px solid #dddddd;

					&:last-child {
						border-bottom: none;
					}
				}
			}


			.label {
				width: 150rpx;
			}

			.right {
				width: 500rpx;
				display: flex;
				align-items: center;
				justify-content: space-between;

				.icon {
					width: 20rpx;
				}

				.pla {
					font-size: 28rpx;
					color: #999999;
					font-family: Arial, Helvetica, sans-serif;
					width: 450rpx;
				}

				.input {
					width: 100%;
					height: 90rpx;
				}
			}

		}

		.subBtn {
			width: 700rpx;
			background-color: #1B82F8;
			border-radius: 50rpx;
			line-height: 90rpx;
			font-size: 32rpx;
			color: #ffffff;
			padding: 0 !important;
			margin: 100rpx auto 0rpx auto;
		}
	}
</style>