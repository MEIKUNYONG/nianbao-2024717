<script>
	export default {
		onLaunch: function() {
			console.log('App Launch')
		},
		onShow: function() {
			console.log('App Show')
		},
		onHide: function() {
			console.log('App Hide')
		},
		globalData: {
			url: 'https://tieie.xyaa.vip/',
			//url: 'https://ss.xyaa.vip/',
			// url: 'https://nianbao.2751.cn/',
			isLogin: false, //是否登录
			userInfo: null,
			mobile: '', //手机号
			config: [], //通用配置信息
			access_token: '',
		}
	}
</script>

<style>
	/*每个页面公共css */
	@import '/static/font/iconfont.css';

	page {
		color: #333333;
		box-sizing: border-box;
		font-family: "Microsoft YaHei", "Helvetica Neue", "Helvetica", "Arial", sans-serif;
		background-color: #F1F1F1;
	}

	.clear::after {
		clear: both;
		display: block;
		content: '';
	}

	.mask {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100vh;
		background: rgba(0, 0, 0, 0.5);
		z-index: 99;
	}

	button::after {
		border: none;
	}
</style>