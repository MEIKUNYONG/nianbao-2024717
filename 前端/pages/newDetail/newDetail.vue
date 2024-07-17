<template>
	<view>
		<image src="/static/img/bg_index.png" class="bg" mode="widthFix"></image>
		<image :src="banner" mode="widthFix" class="banner"></image>

		<view class="pane flow">
			<view class="textBox">
				<view class="line1">
					<text class="value">{{detail.title}}</text>
				</view>
				<view class="line1">
					<text class="price">￥<text class="bold">{{price}}</text></text>
				</view>
			</view>

			<view class="payBox">
				<view class="tit">支付方式</view>
				<radio-group>
					<label class="payGroup">
						<image src="/static/img/weChart.png" mode="heightFix" class="icon"></image>
						<view class="mid">
							<view class="titl">微信支付</view>
							<view class="subtit">10亿用户都在用，真安全，更放心</view>
						</view>
						<view >
						</view>
					    <!-- <radio-group @change="isPays">
							<radio value="0" :checked="isPay" ></radio>
							
						</radio-group> -->
						
					</label>
				</radio-group>
				<view class="checkLine">
					<checkbox-group @change="isCheck">
						<checkbox value="0" :checked="isChecked"></checkbox>
					</checkbox-group>
					<view class="right">
						支付成功，即代表您同意
						<text class="blue" @click="showMask">《{{detail.mo_submitted_title}}》</text>
					</view>
				</view>
			</view>
		</view>

		<view class="footer">
			<view class="payBtn" @click="toPay">立即报送</view>
		</view>

		<view class="mask" v-if="showPace"></view>
		<view class="pane1" v-if="showPace">
			<view class="head">
				<view class="title">{{detail.submitted_title}}</view>
				<i class="iconfont icon-cuo" @click="showMask"></i>
			</view>
			<scroll-view class="cont" scroll-y="true">
				<rich-text :nodes="detail.agreement"></rich-text>
			</scroll-view>
			<view class="btn" @click="showMask">同意本协议</view>
		</view>

	</view>
</template>

<script>
	const app = getApp()
	export default {
		data() {
			return {
				banner: '',
				config: [],
				id: '', //
				detail: [],
				isPay:true,
				isQuery: false, //是否已申报
				miniName: '', //小程序名称
				isChecked: true, //是否同意协议
				showPace: false, //是否显示协议弹窗    
				form: [],
				status: '',
				price: '',
				
			}
		},
		onLoad(options) {
			console.log(options)
			this.id = options.id
			this.config = app.globalData.config
			this.miniName = app.globalData.config.wxtitle
			// this.mobile = app.globalData.mobile

			this.form = JSON.parse(options.form)
			this.status = options.status
			console.log(this.form)
			this.getInfo()
			this.getConfig()

		},
		methods: {
			isCheck(e) { //是否同意协议
				this.isChecked = !this.isChecked
				console.log(e.detail.value, this.isChecked)
			},
			isPays(e) { //
				this.isPay = !this.isPay
				//console.log(848488747)
			},
			
			showMask() {
				this.showPace = !this.showPace
			},

			getConfig() { //获取配置信息
				this.$fn.getConfig({},res => {
					console.log(res.data.data) 
					app.globalData.config = res.data.data
					this.config = res.data.data
					this.miniName = res.data.data.wxtitle
					this.isQiang = res.data.data.is_qiang
					this.$fn.setTitle()
					if (this.status == 0) {
						console.log(this.config.newprice) 
						this.price = this.config.newprice
						this.banner = this.config.qypic
					} else {
						this.banner = this.config.ycpic
						this.getAreaPrice()
					}
				})
			},
			toOffiaccount() { //跳转公众号
				uni.navigateTo({
					url: '/pages/web/web?url=' + this.config.article_link,
				})
			},
			getDetail() { //获取年报页详情
				this.$fn.getDetail({
					id: this.id,
					mobile: this.mobile
				}, res => {
					console.log(res.data.data)
					this.$fn.setTitle()
					this.detail = res.data.data
					if (res.data.data.is_report == 0) {
						this.isQuery = false
					} else if (res.data.data.is_report == 1) {
						this.isQuery = true
					}
				})
			},
			getAreaPrice() { //获取地区价格
				let area = this.form.area.split('-')
				console.log(area)
				let data = {
					area_sheng: area[0],
					area_shi: area[1],
					area_qu: area[2]
				}
				this.$fn.getAreaPrice(data, res => {
					console.log(res.data.data)
					this.$fn.setTitle()
					if (res.data.data == null) {
						this.price = this.config.ycnewprice
					} else {
						this.price = res.data.data.area_price
					}
				})
			},
			getInfo() {
				let status =this.status
				
				this.$fn.getTmpInfo({status}, res => {
					this.detail = res.data.data
				})
			},
			toPay() { //支付
				if (!this.isPay) {
					uni.showToast({
						title: '请勾选支付方式',
						icon: 'none'
					})
				} else {
					if (this.status == 0) {
						console.log(this.form)
						let data = {
							total_price: this.price,
							enterprise_id: '',
							title: this.detail.title,
							idcard: this.form.idCard,
							fmobile: this.form.phone,
							legal_person: this.form.name,
							declaration_type: this.form.main,
							enterprise_name: this.form.company
						}
						if (this.form.id != '') {
							data.enterprise_id = this.form.id
						}
						this.$fn.toPayA(data, res => {
							console.log(res.data.data)
							let vv = res.data.data
							uni.requestPayment({
								nonceStr: vv.nonceStr,
								package: vv.package,
								paySign: vv.paySign,
								timeStamp: vv.timestamp,
								signType: vv.signType,
								success(ress) {
									console.log(ress)
									uni.reLaunch({
										url: '/pages/paySuccess/paySuccess'
									})
								}
							})
						})
					} else if (this.status == 1) {
						let area = this.form.area.split('-')
						let data = {
							total_price: this.price,
							enterprise_id: '',
							title: this.detail.title,
							idcard: this.form.idCard,
							fmobile: this.form.phone,
							legal_person: this.form.name,
							declaration_type: this.form.main,
							enterprise_name: this.form.company,
							area_sheng: area[0],
							area_shi: area[1],
							area_qu: area[2],
							notes: this.form.notes
						}
						if (this.form.id != '') {
							data.enterprise_id = this.form.id
						}
						this.$fn.toPayB(data, res => {
							console.log(res.data.data)
							let vv = res.data.data
							uni.requestPayment({
								nonceStr: vv.nonceStr,
								package: vv.package,
								paySign: vv.paySign,
								timeStamp: vv.timestamp,
								signType: vv.signType,
								success(ress) {
									console.log(ress)
									uni.reLaunch({
										url: '/pages/paySuccess/paySuccess'
									})
								}
							})
						})
					}

				}
			},
		}
	}
</script>

<style>
	page {
		padding-bottom: 160rpx;
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


	.pane {
		background-color: #ffffff;
		width: 700rpx;
		margin: 0 auto;
		border-radius: 20rpx;
		box-sizing: border-box;
	}

	.flow {
		margin-top: 28rpx;
		padding: 0 28rpx;
		box-sizing: border-box;
	}

	.flow .title {
		font-size: 30rpx;
		text-align: center;
		display: flex;
		align-items: center;
		justify-content: center;
		font-weight: bold;
		padding-top: 38rpx;
	}

	.flow .title .text {
		padding: 0 19rpx;
	}

	.flow .title .star {
		width: 16rpx;
	}

	.flow .line {
		width: 588rpx;
		display: block;
		margin: 42rpx auto 0 auto;
	}

	.flow .textBox {
		margin-top: 41rpx;
		padding-bottom: 28rpx;
		border-bottom: 1px solid #dddddd;
	}

	.flow .textBox .line1 {
		color: #666666;
		font-size: 30rpx;
		line-height: 63rpx;
	}

	.flow .textBox .line1 .value {
		color: #333333;
		font-weight: bold;
	}

	.flow .textBox .line1 .price {
		color: #E23A2E;
		font-weight: bold;
	}

	.flow .textBox .line1 .price .bold {
		font-size: 36rpx;
	}

	.flow .payBox {
		margin-top: 35rpx;
	}

	.flow .payBox .tit {
		color: #666666;
		font-size: 30rpx;
	}

	.flow .payBox .payGroup {
		display: flex;
		margin-top: 43rpx;
		justify-content: space-between;
		width: 100%;
		align-items: center;
	}

	.flow .payBox .payGroup .icon {
		height: 64rpx;
		display: block;
	}

	.flow .payBox .payGroup .mid {
		width: 450rpx;
		display: block;
	}

	.flow .payBox .payGroup .mid .titl {
		font-size: 30rpx;
		color: #333333;
	}

	.flow .payBox .payGroup .mid .subtit {
		font-size: 26rpx;
		color: #666666;
	}

	.flow .payBox .payGroup .wx-radio-input {
		display: block;
		width: 40rpx !important;
		height: 40rpx !important;
	}

	.flow .payBox .checkLine {
		padding-bottom: 40rpx;
		margin-top: 50rpx;
		display: flex;
		justify-content: left;
		color: #666666;
		font-size: 28rpx;
		align-items: center;
	}

	.flow .payBox .checkLine .wx-checkbox-input {
		border-radius: 50%;
		margin-right: 10rpx;
		background-color: #F1F9EA;
		border-color: #97C07A;
		color: #97C07A;
		width: 40rpx !important;
		height: 40rpx !important;
	}

	.flow .payBox .checkLine .blue {
		color: #3188F2;
	}

	.copyright {
		width: 679rpx;
		text-align: center;
		color: #999999;
		margin: 50rpx auto;
		font-size: 24rpx;
		line-height: 44rpx;
	}


	.pane1 {
		background-color: #ffffff;
		border-radius: 20rpx;
		z-index: 100;
		width: 627rpx;
		position: fixed;
		top: 100rpx;
		left: 50%;
		margin-left: -313.5rpx;
	}

	.pane1 .head {
		position: relative;
		height: 108rpx;
		line-height: 108rpx;
		text-align: center;
		font-size: 32rpx;
		font-weight: bold;
	}

	.pane1 .head .iconfont {
		display: block;
		position: absolute;
		right: 32rpx;
		top: 0;
		height: 108rpx;
		color: #666666;
		font-size: 30rpx;
	}

	.pane1 .cont {
		width: 560rpx;
		height: 663rpx;
		margin: 10rpx auto 49rpx auto;
		font-size: 24rpx;
	}

	.pane1 .btn {
		width: 289rpx;
		line-height: 90rpx;
		color: #ffffff;
		background-color: #1B82F8;
		font-size: 30rpx;
		text-align: center;
		border-radius: 45rpx;
		margin: 0 auto 49rpx auto;
	}

	.footer {
		position: fixed;
		bottom: 0;
		left: 0;
		width: 100%;
		background-color: #ffffff;
		height: 157rpx;
		display: flex;
		justify-content: space-around;
		align-items: center;
		text-align: center;
		z-index: 50;
	}

	.footer .left {
		color: #1B82F8;
		font-size: 30rpx;
	}

	.footer .left .iconfont {
		margin-right: 10rpx;
	}

	.payBtn {
		width: 90%;
		height: 96rpx;
		line-height: 96rpx;
		border-radius: 50rpx;
		background: linear-gradient(90deg, #F93A22, #F35E32);
		color: #ffffff;
		font-size: 34rpx;
	}

	.kf {
		padding: 0 !important;
		width: auto !important;
		text-align: center;
		position: fixed;
		right: 19rpx;
		top: 65vh;
		background: none !important;
		display: block;
		z-index: 50;
	}

	.kf .img {
		width: 94rpx;
		display: block;
		margin: 0 auto;
	}

	.kf .text {
		display: block;
		font-weight: normal;
		color: #8FA1C7;
		font-size: 28rpx;
		line-height: 44rpx;
	}

	.Qcompany {
		padding: 42rpx 28rpx;
	}

	.Qcompany .name {
		font-weight: bold;
		font-size: 32rpx;
	}

	.Qcompany .code {
		margin-top: 35rpx;
		font-size: 26rpx;
		color: #666666;
	}

	.Qcompany .person {
		font-size: 26rpx;
		color: #666666;
		display: flex;
		margin-top: 35rpx;
	}

	.Qcompany .person .right {
		margin-left: 70rpx;
	}

	.Qcompany .tip {
		display: flex;
		align-items: center;
		background-color: #F2FDF7;
		border-radius: 50rpx;
		margin-top: 55rpx;
		color: #19C54F;
		font-size: 24rpx;
		padding: 0 20rpx;
		box-sizing: border-box;
		line-height: 58rpx;
	}

	.Qcompany .tip .iconfont {
		padding-right: 10rpx;
	}

	.Qoffiaccount {
		width: 700rpx;
		height: 169rpx;
		display: flex;
		align-items: center;
		justify-content: space-around;
		margin: 28rpx auto;
		border-radius: 20rpx;
		background: linear-gradient(90deg, #5F89E5, #BFDAF1);
		box-sizing: border-box;
		padding: 0 28rpx;
		color: #ffffff;
	}

	.Qoffiaccount .left {
		font-size: 28rpx;
		line-height: 56rpx;
	}

	.Qoffiaccount .btn {
		width: 202rpx;
		line-height: 80rpx;
		font-size: 32rpx;
		text-align: center;
		border-radius: 10rpx;
		background-color: #1B82F8;
	}

	.Qtitle {
		margin-top: 29rpx;
		padding-left: 26rpx;
		font-size: 34rpx;

	}

	.Qtitle .iconfont {
		margin-right: 17rpx;
		color: #1B82F8;
		font-size: 35rpx;
	}

	.submitted {
		margin-top: 35rpx;
		padding: 28rpx 25rpx;
		position: relative;
		height: 347rpx;
	}

	.submitted .subBg {
		position: absolute;
		top: 28rpx;
		left: 25rpx;
		border-radius: 10rpx;
		width: 650rpx;
		height: 291rpx;
		z-index: 1;
	}

	.submitted .Qline1 {
		color: #19C54F;
		font-size: 32rpx;
		text-align: center;
		z-index: 10;
		position: absolute;
		top: 120rpx;
		width: 650rpx;
	}

	.submitted .Qline1 .iconfont {
		font-size: 36rpx;
		margin-right: 6rpx;
	}

	.submitted .Qline2 {
		color: #999999;
		font-size: 22rpx;
		text-align: center;
		z-index: 10;
		position: absolute;
		top: 189rpx;
		width: 650rpx;
	}

	.Qservice {
		margin-top: 35rpx;
		padding: 29rpx 26rpx;
	}

	.Qservice .Qline1 {
		display: flex;
		justify-content: space-around;
		text-align: center;
	}

	.Qservice .Qline1 .item {
		font-size: 28rpx;
		color: #333333;
		margin-top: 10rpx;
	}

	.Qservice .Qline1 .item .icon {
		width: 80rpx;
		margin-bottom: 30rpx;
	}

	.Qservice .Qline2 {
		background-color: #F3F8FE;
		border-radius: 10rpx;
		padding: 22rpx 25rpx;
		box-sizing: border-box;
		display: block;
		margin-top: 33rpx;
		font-size: 26rpx;
		color: #999999;
	}

	.service {
		line-height: 100rpx;
		display: flex;
		align-items: center;
		padding: 0 27rpx;
		color: #2E71E9;
		font-size: 30rpx;
		margin-top: 28rpx;
	}

	.service .iconfont {
		font-size: 43rpx;
		margin-right: 23rpx;
	}

	.form1 {
		box-sizing: border-box;
		padding: 39rpx 26rpx;
		margin-top: 29rpx;
	}

	.form1 .item {
		display: flex;
		line-height: 80rpx;
		width: 100%;
		align-items: center;
	}

	.form1 .item .label {
		font-size: 32rpx;
		width: 30%;
	}

	.form1 .item .input {
		border-radius: 10rpx;
		height: 80rpx;
		border: 2rpx solid #1E81F8;
		width: 70%;
		font-size: 32rpx;
		padding: 0 10rpx;
		box-sizing: border-box;
	}
</style>