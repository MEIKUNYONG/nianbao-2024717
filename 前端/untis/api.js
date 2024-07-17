import Vue from 'vue';
// const address = 'https://as.bdyckj.com/';

//接口
function request_all(url, data, method, fn) {
	uni.showLoading({
		title: '加载中...',
		mask: true
	});
	uni.request({
		url: getApp().globalData.url + url,
		header: {
			'token': getApp().globalData.access_token
		},
		data,
		method,
		success: res => {
			// console.log(res)
			uni.hideLoading(); //关闭提示
			if (fn) {
				fn(res)
			}
			// if (res.statusCode == 200 && res.data.status != -1) {
			// 	if (fn) {
			// 		fn(res)
			// 	}
			// } else {
			// 	$showModal(res.data.msg)
			// }
		}
	})
}

Vue.prototype.$fn = {
	getLogin(fn) { //登录
		uni.login({
			success: res => {
				// 发送 res.code 到后台换取 openId, sessionKey, unionId
				console.log('wx登录', res)
				uni.request({
					url: getApp().globalData.url + 'api/login/login',
					data: {
						code: res.code
					},
					method: 'POST',
					success: ress => {
						getApp().globalData.access_token = ress.data.data.access_token
						
						if (fn) {
							fn(ress)
						}
					}
				})

			}
		})
	},
	setTitle() {
		uni.setNavigationBarTitle({
			title: getApp().globalData.config.wxtitle,
		})
	},
	searchCompany(data, fn) { //搜索企业
		request_all('api/index/getenterprise', data, 'POST', fn);
	},
	toBinding(data, fn) { //绑定企业
		request_all('api/index/binding', data, 'POST', fn);
	},
	getCompany(data, fn) { //获取企业
		request_all('api/index/information', data, 'get', fn);
	},
	getCompanyList(data, fn) { //获取已绑定企业列表
		request_all('api/index/enterpriselist', data, 'get', fn);
	},
	getConfig(data, fn) { //获取小程序配置信息
		request_all('api/index/config', data, 'get', fn);
	},
	getPhone(data, fn) { //授权手机号
		request_all('api/member/getPhoneNumber', data, 'POST', fn);
	},
	getOrder(data, fn) { //获取订单列表
		request_all('api/order/orderlist', data, 'POST', fn);
	},
	getDetail(data, fn) { //年报页面详细信息
		request_all('api/index/enterprise', data, 'POST', fn);
	},
	toPay(data, fn) { //年报页面支付
		request_all('api/order/submit', data, 'POST', fn);
	},
	getTypeList(fn) { //商城分类列表
		request_all('api/shop/get_typelist', {}, 'POST', fn);
	},
	getGoodsList(data, fn) { //商城商品列表
		request_all('api/shop/get_shoplist', data, 'POST', fn);
	},
	getAreaPrice(data, fn) { //获取地区价格
		request_all('api/order/getareaprice', data, 'POST', fn);
	},
	getFormCompany(data, fn) { //表单页搜索企业
		request_all('api/index/getmo_enterprise', data, 'POST', fn);
	},
	getTmpInfo(data, fn) { //模板付款页信息
		request_all('api/index/getmo_information', data, 'POST', fn);
	},
	toPayA(data, fn) { //模板 企业年报-支付
		request_all('api/order/nian_mo_submit', data, 'POST', fn);
	},
	toPayB(data, fn) { //模板 经营异常-支付
		request_all('api/order/mo_submit', data, 'POST', fn);
	},
}