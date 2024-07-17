<template>
	<view>
		<!--index.wxml-->
		<image src="/static/img/bg_index.png" class="bg" mode="widthFix"></image>

		<view class="tip clear" v-if="isShowTip">
			<view class="text">{{config.top_word}}</view>
			<i class="iconfont icon-cuo" @click="closeTip"></i>
		</view>

		<view class="logoBox">
			<image :src="config.topleft_logo" mode="widthFix" class="logo"></image>
			<image :src="config.topright_logo" mode="widthFix" class="logo"></image>
		</view>
		<view class="topText">快速代报 省时省力</view>

		<view class="pane head" v-if="!isLogin && isTmp == 0">
			<view class="top" @click="toLogin">
				<i class="iconfont icon-gerenzhongxin4"></i>
				<text>未登录</text>
			</view>
			<view class="cont">
				欢迎使用{{miniName}}，请登录使用，您可以在此查询年报公示情况、补报年报、办理移出经营异常。
				<text class="red">(提示: 本平台仅支持已绑定企业的用户使用，如未绑定则无法使用相关功能。）</text>
			</view>
		</view>

		<view class="logged" v-else>
			<form @submit="search" v-if="isTmp == 0">
				<view class="searchBox">
					<i class="iconfont icon-sousuo"></i>
					<input placeholder="查询需要年报的个体/企业名称" class="search" confirm-type="search" @input="toSearch"
						:value="searchText" />
					<!-- <view class="bd" @click="toBind" v-if="searchCompany.enterprise_name">绑定</view> -->
					<button class="searchBtn" @click="toBind" v-if="searchCompany.enterprise_name">绑定</button>
					<button class="searchBtn" form-type="submit" v-else>搜索</button>

					<view class="list" v-if="isShowSearchList">
						<block v-for="(item,index) in searchList" :key="index">
							<view class="item" :data-id="index" @click="selectCompany">
								{{item.enterprise_name}}
							</view>
						</block>
					</view>
				</view>
			</form>
			<view class="pane company" v-if="isTmp == 0">
				<view class="top">
					<view class="left">
						<view class="name" v-if="nowCompany.length != 0 ">{{nowCompany.enterprise_name}}</view>
						<view class="phone">{{mobile}}</view>
					</view>
					<view class="change" @click="toSelect" v-if="companyList.length > 1">更换主体</view>
					<view class="iconfont icon-qiantai-xiayibu1" @click="showExit"></view>
				</view>

				<view class="btm" v-if="nowCompany">
					<i class="iconfont icon-dui"></i>
					<text>欢迎使用{{miniName}}，您可以免费查看企业年报信息、信用情况，享受更多专属服务</text>
				</view>
				<view class="error" v-else>
					<i class="iconfont icon-tixingshixin"></i>
					<text>该手机号未查询到对应的企业，请搜索企业名称进行绑定9如有疑问咨询在线客服。</text>
				</view>

			</view>
		</view>

		<view class="pane menu" v-if="isTmp == 1">
			<view class="left">
				<view class="title">企业年报</view>
				<view class="btn" @click="toDetails(0)" v-if="nowCompany.is_report == 0">年报报送</view>
				<view class="btn" @click="toDetails(0)" v-else>查询年报</view>
				<view class="subtitle" @click="toOrder">查看年报申报情况</view>
			</view>
			<view class="right">
				<image mode="widthFix" class="img" src="/static/img/icon1.png" />
			</view>
		</view>

		<view class="pane menu" v-if="isTmp == 0">
			<view class="left">
				<view class="title">企业年报</view>
				<view class="btn" @click="toDetail(0)" v-if="nowCompany.is_report == 0">年报报送</view>
				<view class="btn" @click="toDetail(0)" v-else>查询年报</view>
				<view class="subtitle" @click="toOrder">查看年报申报情况</view>
			</view>
			<view class="right">
				<image mode="widthFix" class="img" src="/static/img/icon1.png" />
			</view>
		</view>

		<view class="pane menu" v-if="isTmp == 1 && isYc==1">
			<view class="left">
				<view class="title">经营异常</view>
				<view class="btn" @click="toDetails(1)" v-if="nowCompany.is_report == 0">异常注销</view>
				<view class="btn" @click="toDetails(1)" v-else>查询年报</view>
				<view class="subtitle" @click="toOrder">查看异常注销情况</view>
			</view>
			<view class="right">
				<image mode="widthFix" class="img" src="/static/img/icon2.png" />
			</view>
		</view>


		<view class="pane menu" v-if="isTmp == 0 && isYc==1">
			<view class="left">
				<view class="title">经营异常</view>
				<view class="btn" @click="toDetail(1)" v-if="nowCompany.is_report == 0 && isTmp == 1">异常注销</view>
				<view class="btn" @click="toDetail(1)" v-else>查询年报</view>
				<view class="subtitle" @click="toOrder">查看异常注销情况</view>
			</view>
			<view class="right">
				<image mode="widthFix" class="img" src="/static/img/icon2.png" />
			</view>
		</view>

		<view class="rich">
			<image :src="config.db_img" mode="widthFix" style="width: 100%;"></image>
		</view>

		<view class="between">

			<view class="item">
				<view class="title">
					<i class="iconfont icon-woshou"></i>
					<text>关于年报</text>
				</view>
				<view class="cont">
					企业/个体户应当于每年1月1日至6月30日，通过企业信用信息公示系统向市场监督管理部门报送上一年度年度报告，并向社会公示。当年设立登记的主体，自下一年起报送并公示。否则将被列入经营异常名录，影响企业信用和正常经营。
				</view>
			</view>

			<view class="item">
				<view class="title">
					<i class="iconfont icon-woshou"></i>
					<text>关于经营异常</text>
				</view>
				<view class="cont">
					经营主体被列入经营异常名录，将会通过国家企业信用信息公示系统、信用中国及相关征信机构网站向社会公示，影响经营主体和法人的信用形象，影响企业正常经营。可根据各省市移出流程办理经营异常移出，修复企业信用。
				</view>
			</view>

		</view>

		<view class="gray">
			<text>政策参见:《个体工商户年度报告暂行办法》《企业信息公示暂行条例》</text>
			<text>国家企业信用信息公示系统 官方地址:http://www.gsxt.gov.cn/index</text>
		</view>
		<view class="service">
			<image @click="makeCall" src="/static/img/lx.jpg" mode="widthFix" style="width: 100%; border-radius: 10rpx;"></image>
			<!-- <i class="iconfont icon-kefu"></i> -->
			<!-- <view class="rights">
				<view class="titles"  @click="makeCall">联系我们</view>
				
			</view> -->
		</view>

		<!-- <view class="offiaccount" @click="toOffiaccount">
			<view class="left">
				<text>关注“{{miniName}}”公众号，\n即可订阅年报公示结果通知。</text>
			</view>
			<view class="btn">立即订阅</view>
		</view>



		<button open-type="contact" class="service">
			<i class="iconfont icon-kefu"></i>
			<view class="right">
				<view class="title">在线咨询</view>
				<view class="subtitle">如何使用?年报怎么填写?</view>
			</view>
		</button> -->

		<view class="btmGray">{{config.bottom_copyright}}</view>

		<!-- 退出弹窗 -->
		<view class="mask" v-if="isShowExit" catchtouchmove="true"></view>
		<view class="exitBox" v-if="isShowExit">
			<view class="top">
				<view class="phone">{{userInfo.mobile}}</view>
				<view class="out" @click="logout">退出<i class="iconfont icon-you"></i></view>
			</view>
			<view class="mid">您确认要退出登录吗？</view>
			<view class="btn" @click="showExit">取消</view>
		</view>

		<!-- 选择公司弹窗 -->
		<view class="mask" v-if="isShowSelect" catchtouchmove="true"></view>
		<view class="selectBox" v-if="isShowSelect">
			<view class="top">
				<view class="phone">提示</view>
				<i class="iconfont icon-cuo out" @click="toSelect"></i>
			</view>
			<view class="selectTip">
				<i class="iconfont icon-dui"></i>
				<text>该手机号关联到以下企业，选择一个进行绑定</text>
			</view>
			<view class="mid">
				<radio-group @change="companyChange">
					<block v-for="(item,index) in companyList" :key="index">
						<label class="ra">
							<radio color="#1E81F8" :value="index" />
							<text class="comName">{{item.enterprise_name}}</text>
						</label>
					</block>
				</radio-group>
			</view>
			<view class="btn" @click="changeCompany">确认更换公司</view>
		</view>
	</view>
</template>

<script>
	const app = getApp()
	export default {
		data() {
			return {
				isLogin: false, //登录状态
				isShowTip: true, //是否显示顶部提示
				isShowExit: false, //是否显示退出弹窗
				isShowSelect: false, //是否显示选择公司弹窗
				config: [],
				logo1: '/static/img/del/logo1.png', //顶部LOGO
				logo2: '/static/img/del/logo2.png', //顶部LOGO
				miniName: '', //小程序名称
				oaUrl: '', //公众号文章链接
				searchText: '', //搜索栏内容
				isShowSearchList: false, //是否显示搜索结果列表

				searchList: [], //搜索结果列表
				searchCompany: [], //选择的公司

				nowCompany: [], //当前显示的公司
				companyList: [], //已绑定公司列表
				companyIndex: null, //当前选择的公司序号

				userInfo: [], //用户信息
				mobile: '',
				isTmp: 0, //是否启用模板（1是开启，0是不开启）
				isYc: 0, //是否启用异常（1是开启，0是不开启）
				telephone:'',
			}
		},
		onLoad() {
			this.getConfig()


			if (app.globalData.userInfo == null) {
				console.log('正常登录')

				this.first()
			} else {
				console.log('链接进入')
				this.mobile = app.globalData.mobile
				this.getCompany()
				this.getCompanyList() //获取公司列表
			}
		},
		onShow() {
			this.isLogin = app.globalData.isLogin
			this.userInfo = app.globalData.userInfo
		},
		onShareAppMessage() {
			return {
				title: this.config.wxtitle
			}
		},
		onShareTimeline() {
			return {
				title: this.config.wxtitle
			}
		},

		methods: {
			toLogin() { //跳转登录页
				uni.navigateTo({
					url: '/pages/login/login',
				})
			},
			makeCall() {
				//console.log('658487');
				uni.makePhoneCall({
					phoneNumber:this.telephone,
					success: function() {
						console.log('拨打电话成功');
					},
					fail: function() {
						console.log('拨打电话失败');
					}
				});
			},


			closeTip() { //关闭页面顶部提示				
				this.isShowTip = false
			},
			toOffiaccount() { //跳转公众号
				uni.navigateTo({
					url: '/pages/web/web?url=' + this.config.article_link,
				})
			},
			toSearch(e) { //搜索
				let id = e.detail.value
				if (id == '') {
					this.searchList = []
					this.isShowSearchList = false
				} else {
					this.searchCompany = []
					// this.enterprise_name.enterprise_name=[]
					this.$fn.searchCompany({
						keyword: id,
						mobile: this.mobile
					}, res => {
						console.log(res.data)
						if (res.data.code == 200) {
							this.searchList = res.data.data
							this.isShowSearchList = true
						} else {
							this.searchList = []
							this.isShowSearchList = false
						}
					})
				}
			},
			selectCompany(e) { //选择公司
				let id = e.currentTarget.dataset.id
				console.log(id)
				this.searchText = this.searchList[id].enterprise_name
				this.searchCompany = this.searchList[id]
				this.isShowSearchList = false
				this.searchList = []

				this.toBind()
			},
			toBind() { //绑定企业
				let that = this
				uni.showModal({
					title: '提示',
					content: '您确认要绑定这家公司吗',
					success(res) {
						if (res.confirm) {
							console.log('用户点击确定')
							let data = {
								...that.searchCompany,
								mobile: that.mobile
							}

							that.$fn.toBinding(data, res => {
								console.log(res)
								if (res.data.code == 200) {
									uni.showToast({
										icon: 'success',
										title: '绑定成功',
										success() {
											that.searchCompany = []
											that.searchList = []
											that.searchText = ''
											that.getCompanyList() //获取公司列表
											that.getCompany()
										}
									})
								}
							})
						} else if (res.cancel) {
							console.log('用户点击取消')
						}
					}
				})
			},
			showExit() { //切换退出弹窗				
				this.isShowExit = !this.isShowExit
			},
			toSelect() { //切换绑定公司弹窗				
				this.isShowSelect = !this.isShowSelect
			},
			companyChange(e) { //切换公司选项
				let id = e.detail.value
				console.log('当前公司序号：', id)
				this.companyIndex = id
			},
			changeCompany() { // 确认切换公司
				console.log(this.companyIndex)
				if (this.companyIndex == null) {
					uni.showToast({
						title: '请选择一个公司',
						icon: 'none'
					})
				} else {
					uni.setStorage({
						key: 'nowCompany',
						data: this.companyList[this.companyIndex]
					})
					this.nowCompany = this.companyList[this.companyIndex]
					this.isShowSelect = false
				}
			},
			call(e) {
				console.log(e)
				wx.makePhoneCall({
					phoneNumber: e.currentTarget.dataset.phone
				})
			},
			toDetails(e) { //跳转年报报送
				if (this.isLogin) {
					if (this.isTmp == 0) {
						uni.navigateTo({
							url: '/pages/detail/detail?id=' + this.nowCompany.id,
						})
					} else {
						if (e == 0) {
							uni.navigateTo({
								url: '/pages/form/form?id=' + this.nowCompany.id + '&status=0',
							})
						} else if (e == 1) {
							uni.navigateTo({
								url: '/pages/form/form?id=' + this.nowCompany.id + '&status=1',
							})
						}
					}

				}
			},
			toDetail(e) { //跳转年报报送
				if (this.isLogin) {
					console.log(this.nowCompany.length)
					if (this.nowCompany.length == 0) {
						uni.showToast({
							title: '请先查询并绑定企业',
							icon: 'none'
						})
					} else {
						if (this.isTmp == 0) {
							if (e == 0) {
								uni.navigateTo({
									url: '/pages/detail/detail?id=' + this.nowCompany.id + '&status=0',
								})
							} else if (e == 1) {
								uni.navigateTo({
									url: '/pages/detail/detail?id=' + this.nowCompany.id + '&status=1',
								})
							}
						}


					}

				} else {
					uni.navigateTo({
						url: '/pages/login/login',
					})
				}
			},
			toOrder() { //跳转订单
				if (this.isLogin) {
					uni.navigateTo({
						url: '/pages/order/order',
					})
				} else {
					uni.navigateTo({
						url: '/pages/login/login',
					})
				}
			},
			getCompany() { //获取当前显示的公司
				this.$fn.getCompany({
					mobile: this.mobile
				}, res => {
					console.log(res.data.data)
					this.nowCompany = res.data.data
					uni.setStorage({
						key: 'nowCompany',
						data: res.data.data
					})
				})
			},
			getCompanyList() { //获取已绑定的公司列表
				this.$fn.getCompanyList({
					mobile: this.mobile
				}, res => {
					this.companyList = res.data.data
				})
			},
			getConfig() { //获取配置信息
				this.$fn.getConfig({}, res => {
					console.log(res.data.data)
					app.globalData.config = res.data.data
					app.globalData.is_mo = res.data.data.is_mo
					this.config = res.data.data
					this.miniName = res.data.data.wxtitle
					this.isTmp = res.data.data.is_mo
					this.isYc = res.data.data.is_yc
					this.telephone = res.data.data.service_telephone
					this.isQiang = res.data.data.is_qiang
					this.$fn.setTitle()
				})
			},
			first() { //首次打开

				let that = this
				that.$fn.getConfig({}, res => {
					console.log(res.data.data)
					app.globalData.config = res.data.data
					that.config = res.data.data
					that.miniName = res.data.data.wxtitle
					that.isTmp = res.data.data.is_mo
					that.isQiang = res.data.data.is_qiang
					that.$fn.setTitle()
					console.log(that.isTmp)
					if (that.isTmp == 1) {
						that.$fn.getLogin(res => {
							console.log(res.data.data)
							app.globalData.isLogin = true
							that.userInfo = res.data.data
							that.mobile = ''
							that.isLogin = true

							uni.setStorage({
								key: 'userInfo',
								data: res.data.data,
								success() {
									app.globalData.isLogin = true
									app.globalData.userInfo = res.data.data
									app.globalData.mobile = ""

								}
							})
						})
					}
				})
				uni.getStorage({ //获取缓存用户信息，判断是否登录过
					key: 'userInfo',
					success(res) { //如果已登录，读取信息
						console.log(res)

						if (res.data == undefined) {
							console.log('缓存没有信息')
							// 登录
							that.$fn.getLogin(res => {
								console.log(res.data.data)
								app.globalData.isLogin = false
								that.userInfo = ''
								that.mobile = ''
								that.isLogin = false
							})
						} else {
							app.globalData.userInfo = res.data
							app.globalData.mobile = res.data.mobile
							app.globalData.access_token = res.data.access_token
							app.globalData.isLogin = true
							that.userInfo = res.data
							that.mobile = res.data.mobile
							that.isLogin = true
							that.getCompanyList() //获取公司列表        
							uni.getStorage({ //判断是否已修改主体公司
								key: 'nowCompany',
								success(ress) { //如果有，保存当前主体
									console.log(ress)
									if (ress.data.mobile == res.data.mobile) {
										that.nowCompany = ress.data
									} else {
										that.getCompany()
									}
								},
								fail() { //如果没有获取默认主体
									that.getCompany()
								}
							})
						}




					},
					fail(res) { //如果未登录，调login接口获取token
						console.log('缓存没有信息')
						// 登录
						console.log(that.isTmp)
						that.$fn.getLogin(res => {
							console.log(res.data.data)
							app.globalData.isLogin = false
							that.userInfo = ""
							that.mobile = ''
							that.isLogin = false
						})
						/* if(that.isTmp==1){
							that.$fn.getLogin(res => {
								console.log(res.data.data)
								app.globalData.isLogin = true
								that.userInfo = res.data.data
								that.mobile = ''
								that.isLogin = true
							})
						}else{
							that.$fn.getLogin(res => {
								console.log(res.data.data)
								app.globalData.isLogin = false
								that.userInfo = ""
								that.mobile = ''
								that.isLogin = false
							})
						
							
						} */

					}
				})

			},
			logout() { //登出
				let that = this
				uni.clearStorage({
					success(res) {
						console.log(res)
						app.globalData.userInfo = []
						app.globalData.isLogin = false
						app.globalData.mobile = ''
						that.userInfo = []
						that.isLogin = false
						that.nowCompany = []
						that.isShowExit = false
					},
					complete(res) {
						console.log(res)
					}
				})
			},
		}
	}
</script>

<style>
	/**index.wxss**/
	.bg {
		width: 100%;
		position: absolute;
		top: 0;
		left: 0;
		z-index: -1;
	}

	.tip {
		width: 750rpx;
		background-color: #FFF7D3;
		color: #F59E2E;
		font-size: 22rpx;
		box-sizing: border-box;
		padding: 24rpx 22rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.tip .text {
		float: left;
	}

	.tip .icon-cuo {
		font-size: 26rpx;
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

	.topText {
		text-align: center;
		color: #ffffff;
		font-size: 30rpx;
	}

	.pane {
		background-color: #ffffff;
		width: 700rpx;
		margin: 0 auto;
		border-radius: 20rpx;
		box-sizing: border-box;
	}

	.head {
		padding: 60rpx 25rpx 55rpx 25rpx;
		margin-top: 78rpx;
	}

	.head .top {
		font-size: 55rpx;
		margin-bottom: 45rpx;
	}

	.head .top .iconfont {
		font-size: 60rpx;
		margin-right: 20rpx;
		display: inline-block;
	}

	.head .cont {
		font-size: 26rpx;
		color: #666666;
		line-height: 48rpx;
	}

	.head .cont .red {
		color: #C20000;
		display: block;
	}

	.menu {
		margin-top: 28rpx;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.menu .left {
		text-align: center;
		width: 50%;
	}

	.menu .left .title {
		font-size: 32rpx;
	}

	.menu .left .btn {
		color: #ffffff;
		background-color: #1B82F8;
		width: 244rpx;
		line-height: 76rpx;
		border-radius: 10rpx;
		font-size: 26rpx;
		margin: 26rpx auto 0 auto;
	}

	.menu .left .subtitle {
		font-size: 24rpx;
		color: #999999;
		margin-top: 24rpx;
	}

	.menu .right {
		width: 50%;
		text-align: center;
	}

	.menu .right .img {
		width: 299rpx;
		display: block;
		margin: 41rpx 0;
	}

	.between {
		width: 700rpx;
		margin: 38rpx auto;
		display: flex;
	}

	.between .item {
		width: 50%;
	}

	.between .item .title {
		font-size: 30rpx;
		display: flex;
		align-items: center;
		margin-bottom: 31rpx;
	}

	.between .item .title .iconfont {
		color: #1B82F8;
		margin-right: 8rpx;
		font-size: 36rpx;
	}

	.between .item .cont {
		background-color: #ffffff;
		width: 334rpx;
		border-radius: 10rpx;
		box-sizing: border-box;
		padding: 30rpx 22rpx;
		color: #666666;
		font-size: 24rpx;
		line-height: 44rpx;
	}

	.gray {
		color: #999999;
		font-size: 20rpx;
		width: 700rpx;
		margin: 33rpx auto;
	}

	.gray text {
		display: block;
	}

	.rich {
		width: 700rpx;
		background-color: #ffffff;
		border-radius: 20rpx;
		padding: 40rpx 26rpx;
		box-sizing: border-box;
		margin: 28rpx auto;
	}


	.service {
		width: 700rpx !important;
		margin: 27rpx auto;
		display: block;
		background-color: #ffffff !important;
		border-radius: 20rpx !important;
		padding: 17rpx !important;
		display: flex;
		text-align: left !important;
		justify-content: left;
	}

	.service .iconfont {
		width: 90rpx;
		height: 90rpx;
		line-height: 90rpx;
		text-align: center;
		background-color: #F7F8FD;
		color: #1B82F8;
		border-radius: 50%;
		font-size: 40rpx;
	}

	.service .right {
		margin-left: 28rpx;
		font-weight: normal;
		line-height: 45rpx;
	}

	.service .right .title {
		font-size: 28rpx;
		color: #1B82F8;
	}

	.service .rights {
		margin-left: 28rpx;
		font-weight: normal;
		line-height: 90rpx;
	}

	.service .rights .titles {
		font-size: 34rpx;
		color: #1B82F8;

	}

	.service .right .subtitle {
		font-size: 24rpx;
		color: #999999;
	}


	.btmGray {
		color: #999999;
		font-size: 22rpx;
		width: 623rpx;
		margin: 0 auto;
		text-align: center;
		line-height: 41rpx;
		padding: 34rpx;
	}

	.offiaccount {
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

	.offiaccount .left {
		font-size: 28rpx;
		line-height: 56rpx;
	}

	.offiaccount .btn {
		width: 202rpx;
		line-height: 80rpx;
		font-size: 32rpx;
		text-align: center;
		border-radius: 10rpx;
		background-color: #1B82F8;
	}

	.logged .searchBox {
		width: 700rpx;
		margin: 43rpx auto 27rpx auto;
		background-color: #ECF0FC;
		display: flex;
		height: 90rpx;
		line-height: 90rpx;
		padding: 0 37rpx;
		border-radius: 50rpx;
		box-sizing: border-box;
		position: relative;
	}

	.logged .searchBox .iconfont {
		height: 90rpx;
		margin-right: 14rpx;
	}

	.logged .searchBox .search {
		height: 90rpx;
		width: 470rpx;
		font-size: 28rpx;
	}

	.logged .searchBox form {
		width: 100%;
		display: block;
	}

	.logged .searchBox .bd {
		width: 100rpx;
		height: 60rpx;
		line-height: 50rpx;
		margin-top: 20rpx;
		text-align: center;
		font-size: 28rpx;
		margin-left: auto;
		color: #1B82F8;
		font-size: 24rpx;
		border-left: 1px solid #dddddd;
	}

	.logged .searchBox .searchBtn {
		margin: 20rpx 0 0 auto !important;
		padding: 0 !important;
		background: none !important;
		border-radius: 0 !important;
		width: 100rpx;
		height: 60rpx;
		line-height: 50rpx;
		color: #1B82F8;
		font-size: 24rpx;
		border-left: 1px solid #dddddd !important;
		display: block;
		text-align: center;
	}

	.logged .searchBox .list {
		width: 700rpx;
		position: absolute;
		top: 95rpx;
		left: 0;
		background-color: #ffffff;
		border-radius: 20rpx;
		z-index: 10;
		box-shadow: 0 0 6rpx #dddddd;
	}

	.logged .searchBox .list .item {
		padding: 0 24rpx;
		font-size: 28rpx;
		border-bottom: 1px solid #dddddd;
	}

	.logged .searchBox .list .item:last-child {
		border-bottom: none;
	}

	.logged .company {
		box-sizing: border-box;
		padding: 0 27rpx;
	}

	.logged .company .top {
		display: flex;
		padding-top: 41rpx;
		justify-content: space-between;
	}

	.logged .company .top .left .name {
		font-size: 30rpx;
		width: 450rpx;
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
		line-height: 48rpx;
		font-weight: bold;
		padding-bottom: 20rpx;
	}

	.logged .company .top .left .phone {
		font-size: 28rpx;
		padding-bottom: 21rpx;
		border-bottom: 1px solid #EEEEEE;
		width: 450rpx;
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
	}

	.logged .company .top .change {
		background-color: #E8F2FE;
		color: #1B82F8;
		font-size: 22rpx;
		width: 115rpx;
		height: 48rpx;
		line-height: 48rpx;
		text-align: center;
		border-radius: 10rpx;
	}

	.logged .company .top .iconfont {
		font-size: 32rpx;
		color: #666666;
		margin-top: 11rpx;
	}

	.logged .company .btm {
		display: flex;
		padding-top: 19rpx;
		font-size: 22rpx;
		color: #4D9CF5;
		padding-bottom: 33rpx;
		align-items: center;
	}

	.logged .company .btm .iconfont {
		font-size: 27rpx;
		margin-right: 12rpx;
	}

	.logged .company .error {
		display: flex;
		padding-top: 19rpx;
		font-size: 22rpx;
		color: #F9605B;
		padding-bottom: 33rpx;
		align-items: center;
	}

	.logged .company .error .iconfont {
		font-size: 27rpx;
		margin-right: 12rpx;
	}



	.exitBox {
		width: 627rpx;
		border-radius: 20rpx;
		background-color: #ffffff;
		position: fixed;
		top: 30vh;
		left: 50%;
		z-index: 100;
		margin-left: -313.5rpx;
		box-sizing: border-box;
	}

	.exitBox .top {
		line-height: 96rpx;
		padding: 0 29rpx;
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 28rpx;
		box-sizing: border-box;
	}

	.exitBox .top .out {
		font-size: 28rpx;
		color: #1B82F8;
	}

	.exitBox .top .out .iconfont {
		font-size: 26rpx;
		display: inline-block;
	}

	.exitBox .mid {
		width: 100%;
		line-height: 78rpx;
		padding: 0 28rpx;
		font-size: 30rpx;
		box-sizing: border-box;
		background-color: #F4F9FF;
	}

	.exitBox .btn {
		width: 574rpx;
		line-height: 90rpx;
		margin: 40rpx auto 35rpx auto;
		text-align: center;
		color: #ffffff;
		background-color: #1B82F8;
		border-radius: 20rpx;
		font-size: 30rpx;
	}

	.selectBox {
		width: 627rpx;
		border-radius: 20rpx;
		background-color: #ffffff;
		position: fixed;
		top: 30vh;
		left: 50%;
		z-index: 100;
		margin-left: -313.5rpx;
		box-sizing: border-box;
	}

	.selectBox .top {
		line-height: 96rpx;
		padding: 0 29rpx;
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 30rpx;
		box-sizing: border-box;
	}

	.selectBox .top .out {
		font-size: 30rpx;
		display: block;
		color: #666666;
	}

	.selectBox .selectTip {
		width: 100%;
		line-height: 78rpx;
		background-color: #F2FDF7;
		box-sizing: border-box;
		padding: 0 27rpx;
		font-size: 24rpx;
		color: #666666;
		display: flex;
		align-items: center;
	}

	.selectBox .selectTip .iconfont {
		color: #19C54F;
		font-size: 30rpx;
		margin-right: 11rpx;
	}

	.selectBox .mid {
		padding: 0 27rpx;
		box-sizing: border-box;
		max-height: 278rpx;
		overflow: auto;
	}

	.selectBox .mid .ra {
		width: 100%;
		margin: 24rpx 0;
		font-size: 28rpx;
		display: flex;
		align-items: center;
	}

	.selectBox .mid .ra .comName {
		width: 530rpx;
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
		margin-left: 12rpx;
	}

	.selectBox .mid .wx-radio-input {
		width: 30rpx !important;
		height: 30rpx !important;
	}

	.selectBox .mid .wx-radio-input.wx-radio-input-checked {
		width: 30rpx !important;
		height: 30rpx !important;
		background-color: #1E81F8 !important;
	}

	.selectBox .mid .wx-radio-input.wx-radio-input-checked::before {
		width: 30rpx;
		height: 30rpx;
		line-height: 30rpx;
		text-align: center;
		font-size: 30rpx;
	}

	.selectBox .btn {
		width: 574rpx;
		line-height: 90rpx;
		margin: 58rpx auto 35rpx auto;
		text-align: center;
		color: #ffffff;
		background-color: #1B82F8;
		border-radius: 20rpx;
		font-size: 30rpx;
	}
</style>