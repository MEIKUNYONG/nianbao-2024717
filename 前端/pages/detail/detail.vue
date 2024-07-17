<template>
	<view>
		<image src="/static/img/bg_detail.png" class="bg" mode="widthFix"></image>
		<view class="logoBox">
			<image :src="config.topleft_logo" mode="widthFix" class="logo"></image>
			<image :src="config.topright_logo" mode="widthFix" class="logo"></image>
		</view>

		<view v-if="!isQuery">
			<view class="pane company">
				<view class="name">{{detail.enterprise_name}}</view>
				<view class="code">统一社会信用代码:{{detail.enterprise_code}}</view>
				<view class="person">法定代表人:{{detail.legal_person}}</view>
			</view>

			<view class="pane form1">
				<!-- <view class="item">
					<view class="label">手机号：</view>
					<input type="number" v-model="phone" placeholder="请输入手机号" maxlength="11" class="input" />
				</view> -->
				<view class="item">
					<view class="label">身份证号：</view>
					<input type="idcard" v-model="idcard" placeholder="请输入身份证号" maxlength="18" class="input" />
				</view>
			</view>
			
			<view class="pane flow">
				<view class="title">
					<image src="/static/img/star.png" mode="widthFix" class="star"></image>
					<text class="text">年报通服务流程</text>
					<image src="/static/img/star.png" mode="widthFix" class="star"></image>
				</view>
			
				<image src="/static/img/line.png" mode="widthFix" class="line"></image>
			
				<view class="textBox">
					<view class="line1">
						收费项目：
						<text class="value">{{detail.submitted_title}}</text>
					</view>
					<view class="line1">
						收费标准：
						<text class="price">￥<text class="bold">{{detail.price}}</text></text>
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
							<!-- <radio checked="true"></radio> -->
						</label>
					</radio-group>
					<view class="checkLine">
						<checkbox-group @change="isCheck">
							<checkbox value="0" :checked="isChecked"></checkbox>
						</checkbox-group>
						<view class="right">
							支付成功，即代表您同意
							<text class="blue" @click="showMask">《{{detail.submitted_title}}》</text>
						</view>
					</view>
			
				</view>
			</view>
			
			<view class="pane detail">
				<!-- <view class="p1">
					<view class="title">
						<image src="/static/img/star.png" mode="widthFix" class="star"></image>
						<text class="text">特别提醒</text>
						<image src="/static/img/star.png" mode="widthFix" class="star"></image>
					</view>
					<view class="content">{{detail.prompt}}</view>
				</view> -->



				<view class="p2">
					<view class="title">
						<image src="/static/img/bg_title.png" mode="scaleToFill" class="title_bg"></image>
						<text>年报提示</text>
					</view>
					<view class="content">
						{{detail.lastyear}}年12月31日前登记注册的企业、个体工商户，应当于每年规定时限内，<text
							class="orange">向市场监督管理部门报送上一年的年度报告</text>，否则将被列入经营异常名录，并向社会公示。可通过国家业信用信息公示系统或辖区市监局免费报送。
					</view>
				</view>

				<view class="p3">
					<image src="/static/img/icon3.png" mode="scaleToFill" class="left"></image>
					<view class="right">
						{{detail.thisyear}}年1月1日开始报送<text class="bold">2022年度报告。建议尽快完成年报</text>，避免后期扎堆致网络拥堵延误年报。
					</view>
				</view>

				<text class="p4">
					年报申报官方地址：国家企业信用信息公示系统\nhttp://wwwgsxt.gov.cn/index
				</text>

				<!-- <image :src="detail.db_img" mode="widthFix" class="p5"></image> -->
			</view>

			
			
		</view>

		<view v-else>
			<view class="pane Qcompany">
				<view class="name">{{detail.enterprise_name}}</view>
				<view class="code">统一社会信用代码:{{detail.enterprise_code}}</view>

				<view class="person">
					<view class="left"> 法定代表人:{{detail.legal_person}}</view>
					<view class="right">手机号:{{detail.member_mobile}}</view>
				</view>

				<veiw class="tip">
					<i class="iconfont icon-dui"></i>
					<Text>欢迎使用企业年报通平台，您可以享受专属服务</Text>
				</veiw>
			</view>

			<view class="Qoffiaccount" @click="toOffiaccount">
				<view class="left">
					<text>关注“{{miniName}}”公众号，\n即可订阅年报公示结果通知。</text>
				</view>
				<view class="btn">立即订阅</view>
			</view>

			<view class="Qtitle">
				<i class="iconfont icon-kaohetixi"></i>
				<text>年报报送</text>
			</view>

			<view class="pane submitted">
				<image src="/static/img/bg01.png" mode="scaleToFill" class="subBg"></image>
				<view class="Qline1">
					<i class="iconfont icon-dui"></i>
					<text>您{{detail.lastyear}}年报已公示</text>
				</view>
				<view class="Qline2">您可通过国家企业信用信息公示系统查询公示结果</view>
			</view>

			<view class="Qtitle">
				<i class="iconfont icon-woshou"></i>
				<text>平台专享服务</text>
			</view>

			<view class="pane Qservice">
				<view class="Qline1">
					<view class="item">
						<image src="/static/img/icon4.png" mode="widthFix" class="icon"></image>
						<view>年报报送</view>
					</view>
					<view class="item">
						<image src="/static/img/icon6.png" mode="widthFix" class="icon"></image>
						<view>年报报送提醒</view>
					</view>
					<view class="item">
						<image src="/static/img/icon5.png" mode="widthFix" class="icon"></image>
						<view>专属客户服务</view>
					</view>
				</view>

				<text class="Qline2">年报申报官方地址:国家企业信用信息公示系统\nhttp://www.gsxt.gov.cn/</text>
			</view>

			<view @click="makePhone" class="pane service">
				<i class="iconfont icon-kefu"></i>
				<view class="right">联系电话客服</view>
			</view>
		</view>

		<view class="copyright">
			{{detail.prompt}}
		</view>

		<view class="footer" v-if="!isQuery">
			<view class="left" @click="makePhone">
				<i class="iconfont icon-kefu"></i>
				<text>电话客服</text>
			</view>
			<view class="payBtn" @click="toPay">立即报送</view>
		</view>



		<button class="kf" open-type="contact">
			<image src="/static/img/kf.png" class="img" mode="widthFix"></image>
			<text class="text">在线客服</text>
		</button>

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
				config: [],
				status: '',
				id: '', //
				detail: [],
				isQuery: false, //是否已申报
				miniName: '', //小程序名称
				isChecked: false, //是否同意协议
				showPace: false, //是否显示协议弹窗    
				// phone: '', //手机号
				idcard: '', //身份证号
			}
		},
		onLoad(options) {
			this.status = options.status
			console.log(options)
			if (!app.globalData.isLogin) {
				app.toLogin(res => {
					if (options.mobile) {
						app.globalData.mobile = options.mobile
						app.globalData.isLogin = true
						this.mobile = options.mobile
						this.id = options.id
						this.getConfig()
						this.getDetail()
					}

				})
			} else {
				this.id = options.id
				this.config = app.globalData.config
				this.miniName = app.globalData.config.wxtitle
				this.mobile = app.globalData.mobile
				this.getDetail()
			}
		},
		methods: {
			isCheck(e) { //是否同意协议
				this.isChecked = !this.isChecked
				console.log(e.detail.value, this.isChecked)
			},
			showMask() {
				this.showPace = !this.showPace
				this.isChecked = true
			},

			makePhone() { //拨打客服电话
				uni.makePhoneCall({
					phoneNumber: this.detail.service_telephone,
				})
			},
			getConfig() { //获取配置信息
				this.$fn.getConfig(res => {
					console.log(res.data.data)
					app.globalData.config = res.data.data
					this.config = res.data.data,
						this.miniName = res.data.data.wxtitle
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
					mobile: this.mobile,
					status:this.status,
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
			toPay() { //支付
				console.log(this.idcard.length)

				if (!this.isChecked) {
					uni.showToast({
						title: '请阅读并同意协议',
						icon: 'none'
					})
				} else if(this.idcard.length != 18){
					uni.showToast({
						icon:'none',
						title:"身份证号错误"
					})
				} else {
					this.$fn.toPay({
						total_price: this.detail.price,
						enterprise_id: this.detail.enterprise_id,
						title: this.detail.title,
						idcard: this.idcard,
						fmobile: this.phone
					}, res => {
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

	.logoBox {
		width: 100%;
		text-align: center;
		padding: 45rpx 0;
	}

	.logoBox .logo {
		width: 295rpx;
		margin: 0 15rpx;
	}

	.pane {
		background-color: #ffffff;
		width: 700rpx;
		margin: 0 auto;
		border-radius: 20rpx;
		box-sizing: border-box;
	}

	.company {
		box-sizing: border-box;
		padding: 55rpx 28rpx;
	}

	.company .name {
		font-size: 32rpx;
		color: #F40705;
		font-weight: bold;
		margin-bottom: 44rpx;
	}

	.company .code {
		color: #666666;
		font-size: 28rpx;
		margin-bottom: 43rpx;
	}

	.company .person {
		color: #666666;
		font-size: 28rpx;
	}

	.detail {
		padding: 39rpx 26rpx;
		margin-top: 29rpx;
	}

	.detail .p1 .title {
		font-size: 30rpx;
		text-align: center;
		display: flex;
		align-items: center;
		justify-content: center;
		font-weight: bold;
	}

	.detail .p1 .title .text {
		padding: 0 19rpx;
	}

	.detail .p1 .title .star {
		width: 16rpx;
	}

	.detail .p1 .content {
		line-height: 48rpx;
		font-size: 28rpx;
		margin-top: 35rpx;
	}

	.detail .p2 {
		margin-top: 69rpx;
		padding: 68rpx 25rpx;
		border-radius: 10rpx;
		background-color: #FCFEFD;
		border: 1px solid #FCEDE6;
		position: relative;
	}

	.detail .p2 .title {
		color: #ffffff;
		font-size: 36rpx;
		line-height: 80rpx;
		text-align: center;
		position: relative;
		position: absolute;
		top: -40rpx;
		left: 0;
		width: 100%;
		font-weight: bold;
	}

	.detail .p2 .title .title_bg {
		height: 80rpx;
		width: 336rpx;
		z-index: 1;
		display: block;
		position: absolute;
		top: 0;
		left: 50%;
		margin-left: -168rpx;
	}

	.detail .p2 .title text {
		z-index: 10;
		display: block;
		position: absolute;
		top: 0;
		width: 100%;
	}

	.detail .p2 .content {
		font-size: 28rpx;
		line-height: 48rpx;
	}

	.detail .p2 .content .orange {
		color: #F86724;
	}

	.detail .p3 {
		width: 647rpx;
		padding: 37rpx 29rpx;
		background-color: #E5F1FF;
		display: flex;
		align-items: center;
		justify-content: space-between;
		box-sizing: border-box;
		border-radius: 10rpx;
		margin-top: 28rpx;
	}

	.detail .p3 .left {
		height: 107rpx;
		width: 85rpx;
		display: block;
	}

	.detail .p3 .right {
		width: 465rpx;
		font-size: 24rpx;
		color: #666666;
		line-height: 35.6rpx;
	}

	.detail .p4 {
		width: 647rpx;
		margin-top: 25rpx;
		padding-bottom: 38rpx;
		font-size: 26rpx;
		color: #999999;
		line-height: 36rpx;
		border-bottom: 1px solid #eeeeee;
		display: block;
	}

	.detail .p5 {
		width: 646rpx;
		margin-top: 76rpx;
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
		width: 469rpx;
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