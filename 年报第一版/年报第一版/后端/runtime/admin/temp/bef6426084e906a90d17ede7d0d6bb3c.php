<?php /*a:2:{s:64:"/www/wwwroot/tieie.xyaa.vip/app/admin/view/baseconfig/index.html";i:1712274368;s:64:"/www/wwwroot/tieie.xyaa.vip/app/admin/view/common/container.html";i:1693629258;}*/ ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/element/index.css" rel="stylesheet">
<link href="/assets/css/base.css" rel="stylesheet">
<script src="/assets/element/vue.js"></script>
<script src="/assets/element/index.js"></script>
<script src="/assets/js/axios.min.js"></script>
<script src="/components/base.component.js"></script>
<script src="/assets/libs/jquery/jquery.min.js"></script>
<script src="/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="/assets/js/js.cookie.min.js"></script>
<script src="/assets/js/common.js"></script>
<script type="text/javascript">
Vue.config.productionTip = false
<?php
$dialogstate = request()->get('dialogstate');
?>
const base_url = '<?php echo getBaseUrl()?>';
const base_dir = '';//勿要删除
</script>
</head>


<body>

<style>
.title-block{
    display: flex;
    align-items: center;
    width: 100%;
    height: 38px;
    padding: 0 10px;
    margin: 20px 0;
    line-height: 38px;
    background-color: #f0f0f0;
}
.title-block .title{
    height: 24px;
    padding-left: 8px;
    font-size: 16px;
    font-weight: 700;
    line-height: 24px;
    border-left: 3px solid #1890ff;
}
.monthAndKmStyle{
	display: flex;
	   
}

.monthAndKmStyle .el-input{
    width: 50%;
	display: inline-block;
}
.btm{position:fixed;bottom:0px;z-index:9999;width:100%;}
</style>

<header id="page-topbar" style="position:fixed;left:0; top:0; z-index:999;<?php if($dialogstate == 1): ?>display:none;<?php endif; ?>" v-cloak>
	<div class="navbar-header">
		<div class="d-flex">
			<div class="navbar-header">
				<div class="d-flex" data-toggle="cospan">
					<i style="margin-left:15px;" id="vertical-menu-btn" class="el-icon-s-fold"></i>
					<i style="margin-left:15px;" @click="reload" class="el-icon-refresh hidden-sm-and-down"></i>
				</div>
				<div class="d-flex hidden-sm-and-down">
					<el-breadcrumb separator="/" style="margin-left:30px;">
						<el-breadcrumb-item v-for="item in levelList" :key="item.path">
							<a v-if="item.title == '首页'" :href="item.path">{{item.title}}</a>
							<span v-else>{{item.title}}</span>
						</el-breadcrumb-item>
					</el-breadcrumb>
				</div>
			</div>
		</div>
		<div class="d-flex">
			<div class="iconbutton">
				<el-tooltip content="清除缓存" effect="dark" placement="bottom">
					<i @click="clearCache()" class="icontool el-icon-delete"></i>
				</el-tooltip>
			</div>
			
			<div class="iconbutton">
				<el-avatar src="<?php echo config('base_config.logo'); ?>" style="vertical-align:middle"></el-avatar>
				<el-dropdown trigger="click" placement="bottom" style="cursor: pointer;margin-right:15px;">
					<span class="el-dropdown-link">
						<?php echo session('admin.username'); ?><i style="margin-left:0px; font-size:100%" class="icontool el-icon-arrow-down"></i>
					</span>
					<el-dropdown-menu slot="dropdown">
						<el-dropdown-item icon="el-icon-lock" @click.native.prevent="passwordDialogStatus = true">修改密码</el-dropdown-item>
						<el-dropdown-item icon="el-icon-back" @click.native.prevent="logout">退出</el-dropdown-item>
					</el-dropdown-menu>
				</el-dropdown>
			</div>
			<div class="iconbutton" style="margin-left:0">
				<i class="bx bx-cog bx-spin right-bar-toggle"></i>
			</div>
		</div>
	</div>
	
	<el-dialog title="重置密码" style="margin-top:100px;" width="450px"  :visible="passwordDialogStatus" :before-close="closeForm" append-to-body>
		<el-form :size="size" ref="form" :model="form" :rules="rules" label-width="80px">
			<el-row>
				<el-col :span="24">
					<el-form-item label="新密码" prop="password">
						<el-input  show-password autoComplete="off" v-model="form.password"  clearable placeholder="请输入密码"/>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row>
				<el-col :span="24">
					<el-form-item label="确认密码" prop="repassword">
						<el-input  show-password autoComplete="off" v-model="form.repassword"  clearable placeholder="请输入确认密码"/>
					</el-form-item>
				</el-col>
			</el-row>
		</el-form>
		<div slot="footer" class="dialog-footer">
			<el-button :size="size" :loading="loading" type="primary" @click="submit" >
				<span v-if="!loading">确 定</span>
				<span v-else>提 交 中...</span>
			</el-button>
			<el-button :size="size" @click="closeForm">取 消</el-button>
		</div>
	</el-dialog>
</header>

<script>
new Vue({
	el: '#page-topbar',
	data(){
		var validatePass2 = (rule, value, callback) => {
			if(value === '') {
				callback(new Error('请再次输入密码'))
			}else if (value !== this.form.password) {
				callback(new Error('两次输入密码不一致!'))
			}else {
				callback()
			}
		}
		return {
			form: {
				password:'',
				repassword:'',
			},
			url:{},
			levelList:[],
			notice:[],
			passwordDialogStatus:false,
			loading:false,
			size:'small',
			urlobj:{},//这里是判断如果是弹窗链接的话 不显示头部
			rules: {
                password: [{ required: true, message: '密码不能为空', trigger: 'blur' }],
				repassword:[
					{required: true, validator: validatePass2, trigger: 'blur'},
				],
			}
		}
	},
	mounted(){
		if(sessionStorage.getItem(base_url+'breadcrumb')){
			const menuList = JSON.parse(sessionStorage.getItem(base_url+'breadcrumb'))
			this.url = new URL(window.location.href)
			let menus = this.getMenus(menuList)
			let home = [{title:'首页', path:base_url+'/Index/main.html'}]
			if (menus !== undefined) {
				if(this.url.pathname !== base_url+'/Index/main.html' && this.url.href !== base_url+'/Index/main.html'){
					menus = home.concat(menus)
				}
			}else{
				menus = home
			}
			
			this.levelList = menus
		}
	},
	methods:{
		getMenus(menuList,arr,z){
            arr = arr || []
            z = z || 0
            for (let i = 0; i < menuList.length; i++) {
                let item = menuList[i]
                arr[z] = item
                if(this.url.pathname === menuList[i].url || this.url.href === menuList[i].url){
                   return arr.slice(0,z + 1)
                }
                if(menuList[i].children && menuList[i].children.length){
                   let res = this.getMenus(menuList[i].children,arr,z+1)
                   if(res){
                       return res
                   }
                }
            }
        },
		submit(){
			this.$refs['form'].validate(valid => {
				if(valid) {
					this.loading = true
					axios.post(base_url+'/Base/resetPwd',this.form).then(res => {
						if(res.data.status == 200){
							this.$message({message: '操作成功', type: 'success'})
							this.closeForm()
						}else{
							this.$message.error(res.data.msg)
						}
					}).catch(()=>{
						this.loading = false
					})
				}
			})
		},
		closeForm(){
			this.passwordDialogStatus = false
			this.loading = false
			if (this.$refs['form']!==undefined) {
				this.$refs['form'].resetFields()
			}
		},
		getNotice(){
			axios.post(base_url+'/Index/getNotice').then(res => {
				if(res.data.status == 200){
					this.notice = res.data.data
				}
			})
		},
		clearCache(){
			this.$confirm('确定清除缓存吗?', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(()=>{
				axios.post(base_url+'/Base/clearCache').then(res => {
					if(res.data.status == 200){
						this.$message({message: '操作成功', type: 'success'})
					}
				})
			})
		},
		logout(){
			this.$confirm('确定注销并且退出系统?', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(()=>{
				axios.get(base_url+'/Login/logout').then(res => {
					if(res.data.status == 200){
						sessionStorage.setItem(base_url+'breadcrumb','')
						Cookies.set(base_url+'menu','')
						top.parent.frames.location.href = base_url+'/login/index'
					}
				})
			})
		},
		reload(){
			location.reload()
		},
	},
})
</script>

<div id="app" class="page-content" :style="!urlobj.dialogstate ? 'margin-top:60px;':'margin-top:10px;'">
	<tab-tag v-if="!urlobj.dialogstate"></tab-tag>
	
<div style="margin:0 15px 15px 15px;">
<el-card shadow="never" class="card" style="min-height:650px;">
	<el-form size="small" ref="form" :model="form" :rules="rules" label-width="100px" >
	<el-tabs v-model="activeName">
		<el-tab-pane style="padding-top:10px"  label="基本信息" name="基本信息">
				<el-row >
					<el-col :span="24">
						<el-form-item label="站点名称" prop="site_title">
							<el-input  v-model="form.site_title" autoComplete="off" clearable  placeholder="请输入站点名称"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="站点logo" prop="logo">
							<Upload size="small"      file_type="image" :image.sync="form.logo"></Upload>
						</el-form-item>
					</el-col>
				</el-row>
			
		</el-tab-pane>
		<el-tab-pane style="padding-top:10px"  label="拓展信息" name="拓展信息">
				<el-row >
					<el-col :span="24">
						<el-form-item label="上传配置" prop="filesize">
							<el-input  v-model="form.filesize" autoComplete="off" clearable  placeholder="请输入上传配置"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="文件类型" prop="filetype">
							<el-input  v-model="form.filetype" autoComplete="off" clearable  placeholder="请输入文件类型"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
		
				<el-row >
					<el-col :span="24">
						<el-form-item label="绑定域名" prop="domain">
							<el-input  v-model="form.domain" autoComplete="off" clearable  placeholder="请输入绑定域名"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
		</el-tab-pane>
		
		<el-tab-pane style="padding-top:10px"  label="小程序配置" name="小程序配置">
				<div class="title-block">
		            <div class="title">
		                小程序基础设置
		            </div>
		        </div>
		        <el-row >
					<el-col :span="24">
						<el-form-item label="小程序名称" prop="wxtitle">
							<el-input  v-model="form.wxtitle" autoComplete="off" clearable  placeholder="请输入小程序名称"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
		        <el-row >
					<el-col :span="24">
						<el-form-item label="小程序logo" prop="wxlogo">
							<Upload size="small"   file_type="image" :image.sync="form.wxlogo"></Upload>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="APPID" prop="appid">
							<el-input  v-model="form.appid" autoComplete="off" clearable  placeholder="请输入小程序appid"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="AppSecret" prop="appsecret">
							<el-input  v-model="form.appsecret" type="password" autoComplete="off" clearable  placeholder="请输入小程序秘钥"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="客服电话" prop="service_telephone">
							<el-input  v-model="form.service_telephone" autoComplete="off" clearable  placeholder="请输入客服电话"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="是否显示经营异常" prop="is_yc">
						
							<el-switch
                                v-model="form.is_yc"
                                active-color="#13ce66"
                                inactive-color="#ff4949"
                                active-value="1"
                                inactive-value="0">
                            </el-switch>
						</el-form-item>
					</el-col>
				</el-row>
				<div class="title-block">
		            <div class="title">
		                订单配置
		            </div>
		        </div>
		        
		        <el-row >
					<el-col :span="24">
						<el-form-item label="年报服务名称" prop="shoptitle">
							<el-input  v-model="form.shoptitle" autoComplete="off" clearable  placeholder="请输入年报服务名称"></el-input>
						</el-form-item>
						<div style="font-size: 14px;margin-left: 100px;color: red;">此配置是下单页面的服务名称</div>	
					</el-col>
				</el-row>
				
				<el-row >
					<el-col :span="24">
						<el-form-item label="异常服务名称" prop="ycshoptitle">
							<el-input  v-model="form.ycshoptitle" autoComplete="off" clearable  placeholder="请输入异常服务名称"></el-input>
						</el-form-item>
						<div style="font-size: 14px;margin-left: 100px;color: red;">此配置是下单页面的服务名称</div>	
					</el-col>
				</el-row>
				
				
				<el-row >
					<el-col :span="24">
					    <div style="display:flex;">
					        <el-form-item   label="年报价格区间" prop="">
						
                                  <el-input-number  v-model="form.min_price" :min="0" :max="99999" style="width:200px;" controls-position="right" @keyup.native="UpNumber" @keydown.native="UpNumber" @change="handleChange" placeholder="请输入最小价格" />


                              
    						</el-form-item>
    						<div style="width: 47px;line-height: 2;text-align: center;">
    						    至
    						</div>
    						<el-form-item   label="" prop="" style="margin-left: -100px;">
    						    
    						    <el-input-number  v-model="form.max_price" :min="0" :max="99999" style="width:200px;" controls-position="right" @keyup.native="UpNumber" @keydown.native="UpNumber" @change="handleChange" placeholder="请输入最大价格" />

                             
    						
    						</el-form-item>
					    </div>
						
						
					</el-col>
				</el-row>
				
				
				<el-row >
					<el-col :span="24">
					    <div style="display:flex;">
					        <el-form-item   label="异常价格区间" prop="">
						
                                  <el-input-number  v-model="form.ycmin_price" :min="0" :max="99999" style="width:200px;" controls-position="right" @keyup.native="UpNumber" @keydown.native="UpNumber" @change="handleChange" placeholder="请输入最小价格" />


                              
    						</el-form-item>
    						<div style="width: 47px;line-height: 2;text-align: center;">
    						    至
    						</div>
    						<el-form-item   label="" prop="" style="margin-left: -100px;">
    						    
    						    <el-input-number  v-model="form.ycmax_price" :min="0" :max="99999" style="width:200px;" controls-position="right" @keyup.native="UpNumber" @keydown.native="UpNumber" @change="handleChange" placeholder="请输入最大价格" />

                             
    						
    						</el-form-item>
					    </div>
						
						
					</el-col>
				</el-row>
				
				
				<div class="title-block">
		            <div class="title">
		                模板配置
		            </div>
		        </div>
				<el-row >
					<el-col :span="24">
						<el-form-item label="是否启用模板" prop="is_mo">
						
							<el-switch
                                v-model="form.is_mo"
                                active-color="#13ce66"
                                inactive-color="#ff4949"
                                active-value="1"
                                inactive-value="0">
                            </el-switch>
						</el-form-item>
					</el-col>
				</el-row>
				
				<el-row >
					<el-col :span="24">
						<el-form-item label="是否强制填写" prop="is_qiang">
						
							<el-switch
                                v-model="form.is_qiang"
                                active-color="#13ce66"
                                inactive-color="#ff4949"
                                active-value="1"
                                inactive-value="0">
                            </el-switch>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="异常经营顶部图" prop="ycpic">
							<Upload size="small"   file_type="image" :image.sync="form.ycpic"></Upload>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="企业年报顶部图" prop="qypic">
							<Upload size="small"   file_type="image" :image.sync="form.qypic"></Upload>
						</el-form-item>
					</el-col>
				</el-row>
				
			<!--	<el-row >
					<el-col :span="24">
						<el-form-item label="统一服务费" prop="noareafee">
						    <el-input-number controls-position="right" style="width:200px;" autoComplete="off" v-model="form.noareafee" clearable :min="0" placeholder="请输入统一服务费"/>
						    
						
						</el-form-item>
						<div style="font-size: 14px;margin-left: 100px;color: red;">开启后没有对应地区的统一服务费（即将废弃）</div>	
					</el-col>
				</el-row>-->
				
				<el-row >
					<el-col :span="24">
						<el-form-item label="年报代报送协议" prop="mo_submitted_title">
							<el-input  v-model="form.mo_submitted_title" autoComplete="off" clearable  placeholder="请输入标题"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="年报代报送协议内容" prop="mo_tongyi_content">
							<el-input  type="textarea" id="tongyi" autoComplete="off" v-model="form.mo_tongyi_content" clearable placeholder="请输入内容"/>
						</el-form-item>
					</el-col>
				</el-row>
				
				<div class="title-block">
		            <div class="title">
		                首页配置
		            </div>
		        </div>
		        <el-row >
					<el-col :span="24">
						<el-form-item label="最顶部文字" prop="top_word">
						    <el-input  v-model="form.top_word" autoComplete="off" clearable  placeholder="请输入最顶部文字"></el-input>
							
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="顶部左logo" prop="topleft_logo">
							<Upload size="small" file_type="image" :image.sync="form.topleft_logo"></Upload>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="顶部右logo" prop="topright_logo">
							<Upload size="small" file_type="image" :image.sync="form.topright_logo"></Upload>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="公众号订阅文章链接" prop="article_link">
							<el-input  v-model="form.article_link" autoComplete="off" clearable  placeholder="请输入公众号文章链接"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				
				<div class="title-block">
		            <div class="title">
		                企业年报对比图
		            </div>
		        </div>
				<el-row >
					<el-col :span="24">
						<el-form-item label="对比图" prop="db_img">
							<Upload size="small" file_type="image" :image.sync="form.db_img"></Upload>
						</el-form-item>
					</el-col>
				</el-row>
				<div class="title-block">
		            <div class="title">
		                登录配置
		            </div>
		        </div>
		        <el-row >
					<el-col :span="24">
						<el-form-item label="用户协议标题" prop="agreement_title">
							<el-input  v-model="form.agreement_title" autoComplete="off" clearable  placeholder="请输入用户协议标题"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="用户协议内容" prop="agreement_content">
						    <el-input  ref="rContent" type="textarea" id="myte" autoComplete="off" v-model="form.agreement_content" clearable placeholder="请输入内容"/>
						</el-form-item>
					</el-col>
				</el-row>
				
			
				
				<el-row >
					<el-col :span="24">
						<el-form-item label="隐私政策标题" prop="privacy_title">
							<el-input  v-model="form.privacy_title" autoComplete="off" clearable  placeholder="请输入隐私政策标题"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="隐私政策内容" prop="privacy_content">
							<el-input  type="textarea" id="mytextareas" autoComplete="off" v-model="form.privacy_content" clearable placeholder="请输入内容"/>
						</el-form-item>
					</el-col>
				</el-row>
				
				<div class="title-block">
		            <div class="title">
		                特别提示配置
		            </div>
		        </div>
		        <el-row >
					<el-col :span="24">
						<el-form-item label="正常提示" prop="normalprompt">
						
							<el-input  type="textarea"  autoComplete="off" v-model="form.normalprompt" clearable placeholder="请输入正常提示"/>
						</el-form-item>
						
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="特价提示" prop="specialprompt">
						    <el-input  type="textarea"  autoComplete="off" v-model="form.specialprompt" clearable placeholder="请输入特价提示"/>
						
						</el-form-item>
					</el-col>
				</el-row>
				
				<div class="title-block">
		            <div class="title">
		                服务费配置
		            </div>
		        </div>
		        <!--<el-row >
					<el-col :span="24">
						<el-form-item label="正常服务费（即将废弃）" prop="normalfee">
						
							<el-input-number controls-position="right" style="width:200px;" autoComplete="off" v-model="form.normalfee" clearable :min="0" placeholder="请输入正常服务费"/>
						</el-form-item>
						
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="特价服务费（即将废弃）" prop="specialfee">
						    <el-input-number controls-position="right" style="width:200px;" autoComplete="off" v-model="form.specialfee" clearable :min="0" placeholder="请输入特价服务费"/>
						
						</el-form-item>
					</el-col>
				</el-row>-->
				
				<el-row >
					<el-col :span="24">
						<el-form-item label="报送协议标题" prop="submitted_title">
							<el-input  v-model="form.submitted_title" autoComplete="off" clearable  placeholder="请输入报送协议标题"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="正常报送协议内容" prop="normal_content">
							<el-input  type="textarea" id="normal" autoComplete="off" v-model="form.normal_content" clearable placeholder="请输入内容"/>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="特价报送协议内容" prop="special_content">
							<el-input  type="textarea" id="special" autoComplete="off" v-model="form.special_content" clearable placeholder="请输入内容"/>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="底部版权" prop="bottom_copyright">
						
							<el-input  type="textarea"  autoComplete="off" v-model="form.bottom_copyright" clearable placeholder="请输入底部版权"/>
						</el-form-item>
						
					</el-col>
				</el-row>
                
		</el-tab-pane>
		<el-tab-pane style="padding-top:10px"  label="企查查配置" name="企查查配置">
			
				<el-row >
					<el-col :span="24">
						<el-form-item label="Key" prop="key">
							<el-input  v-model="form.key" type="password" autoComplete="off" clearable  placeholder="请输入Key"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="SecretKey" prop="secretkey">
							<el-input  v-model="form.secretkey" type="password" autoComplete="off" clearable  placeholder="请输入SecretKey"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
		</el-tab-pane>
		
		
		<el-tab-pane style="padding-top:10px"  label="短信配置" name="短信配置">
				<el-row >
					<el-col :span="24">
						<el-form-item label="选择支付方式" prop="hy_type">
						
							<el-radio :disabled="form.id != null" v-model="form.hy_type" label="1" border size="medium">
								互亿无线
							</el-radio>
							
						</el-form-item>
					</el-col>
				</el-row>
				
				<template v-if="form.type == 1">
				    
                    <el-form-item label="APIID" prop="hy_apiid" >
                        <el-input  v-model.trim="form.hy_apiid" autoComplete="off" clearable  placeholder="请输入APIID"></el-input>
                       
                    </el-form-item>
                    <el-form-item label="APIKEY" prop="hy_apikey" >
                        <el-input  v-model.trim="form.hy_apikey" type="password" autoComplete="off" clearable  placeholder="请输入APIKEY"></el-input>
                       
                    </el-form-item>
                   
                   
                </template>
                
               
                
		</el-tab-pane>
	</el-tabs>

		
		<el-form-item class="btm" >
			<el-button size="small" type="primary" @click="submit">保存设置</el-button>
		</el-form-item>
	</el-form>
</el-card>
</div>

</div>

<div class="right-bar" id="rightbar">
	<div data-simplebar class="h-100">
		<div class="rightbar-title flex align-items-center bg-dark p-3">
			<h5 class="m-0 me-2 text-white">主题设置</h5>
			<a href="javascript:void(0);" class="right-bar-toggle ms-auto">
				<i class="mdi mdi-close noti-icon"></i>
			</a>
		</div>
		<div class="drawer-container">
			<div class="drawer-item">
				<span>标签页</span>
				<el-switch @change="selectTag" :active-value="1" :inactive-value="0" v-model="setting.tagsView" class="drawer-switch" />
			</div>
			<div class="drawer-item">
				<p>顶部背景色</p>
				<el-radio-group v-model="setting.topbg" @change="selectTopBg" size="mini">
					<el-radio-button label="light">白色</el-radio-button>
					<el-radio-button label="blank">黑色</el-radio-button>
					<el-radio-button label="dark">蓝色</el-radio-button>
				</el-radio-group>
			</div>
			<div class="drawer-item">
				<p>侧栏背景色</p>
				<el-radio-group v-model="setting.sidebg" @change="selectSideBg" size="mini">
					<el-radio-button label="dark">黑色</el-radio-button>
					<el-radio-button label="brand">蓝色</el-radio-button>
					<el-radio-button label="light">白色</el-radio-button>
				</el-radio-group>
			</div>
        </div>
	</div>
</div>
<div class="rightbar-overlay"></div>
<script>
var siteconfig 
if(Cookies.get(base_url+'siteconfig')){
	siteconfig = JSON.parse(Cookies.get(base_url+'siteconfig'))
	document.body.setAttribute('data-topbar', siteconfig.topbg)
	parent.document.body.setAttribute('data-sidebar', siteconfig.sidebg)
	var classname = !siteconfig.tagsView ? 'hiddenbox' : 'showbox'
	document.getElementById('app').setAttribute('tag-box', classname)
}

new Vue({
	el: '#rightbar',
	data(){
		return {
			setting:{
				tagsView:1,
				topbg:'light',
				sidebg:'dark',
			}
		}
	},
	mounted(){
		if(Cookies.get(base_url+'siteconfig')){
			this.setting = JSON.parse(Cookies.get(base_url+'siteconfig'))
		}
	},
	methods:{
		selectTopBg(val){
			document.body.setAttribute('data-topbar', val)
			Cookies.set(base_url+'siteconfig',JSON.stringify(this.setting))
		},
		selectSideBg(val){
			parent.document.body.setAttribute('data-sidebar', val)
			Cookies.set(base_url+'siteconfig',JSON.stringify(this.setting))
		},
		selectTag(val){
			var classname = !val ? 'hiddenbox' : 'showbox'
			document.getElementById('app').setAttribute('tag-box', classname)
			Cookies.set(base_url+'siteconfig',JSON.stringify(this.setting))
		}
	},
})
</script>

<script type="text/javascript">
/*
    window.onload = function(){
        
            document.onkeydown = function (){
                var e = window.event || arguments[0];
                //F12
                if(e.keyCode == 123){
                    return false;
             
                }else if((e.ctrlKey) && (e.shiftKey) && (e.keyCode == 73)){
                    return false;
              
                }else if((e.shiftKey) && (e.keyCode == 121)){
                    return false;
            
                }else if((e.ctrlKey) && (e.keyCode == 85)){
                    return false;
                }
            };
       
            document.oncontextmenu = function (){
                return false;
            }
        }
 

(function() {var a = new Date(); debugger; return new Date() - a > 100;}())
// 2
setInterval(function (){debugger;},1000);*/

</script>

<script src="/assets/js/app.js"></script>
<script src="/assets/editor/tinymce/tinymce.min.js"></script>
<script>
new Vue({
	el: '#app',
	components:{
	},
	data(){
		return {
			form: {
				site_title:'',
				logo:'',
				keyword:[],
				descrip:'',
				copyright:'',
				filesize:'0',
				filetype:'',
				water_status:1,
				domain:'',
				agreement_content:'',
				min_price:200,
				max_price:900,
				
				ycmin_price:200,
				ycmax_price:900,
				
			
			},
			loading:false,
			activeName:'基本信息',
			rules: {
			}
		}
	},
	watch: {
	    
	    
      'form.agreement_content'(val) {
          
          tinymce.get('myte').setContent(this.form.agreement_content);
          tinymce.get('mytextareas').setContent(this.form.privacy_content);
          tinymce.get('normal').setContent(this.form.normal_content);
          tinymce.get('special').setContent(this.form.special_content);
          
          tinymce.get('tongyi').setContent(this.form.mo_tongyi_content);
	
        
      }
    },
	mounted(){
	    
	    axios.post(base_url + '/Baseconfig/getInfo').then(res => {
			if(res.data.status == 200){
				this.form = JSON.stringify(res.data.data) == '[]' ? {} : res.data.data
				
				//this.$refs['rContent'].setContent(res.data.data.agreement_content)
				this.setDefaultVal('keyword')
	
			}
		});
	    
	    
	    const image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
			let formdata = new FormData()
			formdata.append('file', blobInfo.blob())
			formdata.append('edit', true)
			formdata.append('upload_config_id', this.upload_config_id)
			axios.post(base_url+'/Upload/upload', formdata).then(res => {
				resolve(res.data.data)
			})
		});
		var t = this
		tinymce.init({
            selector: '#myte',
            toolbar1: 'bold italic underline strikethrough fontsizeselect forecolor backcolor alignleft aligncenter alignright alignjustify bullist numlist link unlink code removeformat fullscreen',
        	toolbar2: '',
        	plugins: [
        			   'lists','code', 'wordcount'
        	],
        
        	height: 400,
        	language_url: base_dir+'/assets/editor/tinymce/langs/zh_CN.js',
        	language: 'zh_CN',
        	branding: false,
        	convert_urls:false,
        	images_upload_handler: image_upload_handler
        	
          });
          tinymce.init({
            selector: '#mytextareas',
            toolbar1: 'bold italic underline strikethrough fontsizeselect forecolor backcolor alignleft aligncenter alignright alignjustify bullist numlist link unlink code removeformat fullscreen',
        	toolbar2: '',
        	plugins: [
        			   'lists','code', 'wordcount'
        	],
        
        	height: 400,
        	language_url: base_dir+'/assets/editor/tinymce/langs/zh_CN.js',
        	language: 'zh_CN',
        	branding: false,
        	convert_urls:false,
        	images_upload_handler: image_upload_handler
        	
          });
          
          tinymce.init({
            selector: '#normal',
            toolbar1: 'bold italic underline strikethrough fontsizeselect forecolor backcolor alignleft aligncenter alignright alignjustify bullist numlist link unlink code removeformat fullscreen',
        	toolbar2: '',
        	plugins: [
        			   'lists','code', 'wordcount'
        	],
        
        	height: 400,
        	language_url: base_dir+'/assets/editor/tinymce/langs/zh_CN.js',
        	language: 'zh_CN',
        	branding: false,
        	convert_urls:false,
        	images_upload_handler: image_upload_handler
        	
          });
          
          tinymce.init({
            selector: '#special',
            toolbar1: 'bold italic underline strikethrough fontsizeselect forecolor backcolor alignleft aligncenter alignright alignjustify bullist numlist link unlink code removeformat fullscreen',
        	toolbar2: '',
        	plugins: [
        			   'lists','code', 'wordcount'
        	],
        
        	height: 400,
        	language_url: base_dir+'/assets/editor/tinymce/langs/zh_CN.js',
        	language: 'zh_CN',
        	branding: false,
        	convert_urls:false,
        	images_upload_handler: image_upload_handler
        	
          });
          
          tinymce.init({
            selector: '#tongyi',
            toolbar1: 'bold italic underline strikethrough fontsizeselect forecolor backcolor alignleft aligncenter alignright alignjustify bullist numlist link unlink code removeformat fullscreen',
        	toolbar2: '',
        	plugins: [
        			   'lists','code', 'wordcount'
        	],
        
        	height: 400,
        	language_url: base_dir+'/assets/editor/tinymce/langs/zh_CN.js',
        	language: 'zh_CN',
        	branding: false,
        	convert_urls:false,
        	images_upload_handler: image_upload_handler
        	
          });
          
          
	
	},
	methods: {
	    handleChange() {
    
        },
        // 只可输入数字
        UpNumber(e) {
          e.target.value = e.target.value.replace(/[^\d]/g, '')
        },
		submit(){
		    var agreement_content=tinymce.get('myte').getContent();
		  
		    this.form.agreement_content=agreement_content;
		    
		    var privacy_content=tinymce.get('mytextareas').getContent();
		    
		    this.form.privacy_content=privacy_content;
		    
		    var normal_content=tinymce.get('normal').getContent();
		    
		    this.form.normal_content=normal_content;
		    
		    var special_content=tinymce.get('special').getContent();
		    
		    this.form.special_content=special_content;
		    
		    
		    var tongyi_content=tinymce.get('tongyi').getContent();
		    
		    this.form.mo_tongyi_content=tongyi_content;
		    
		    
		    
			this.$refs['form'].validate(valid => {
				if(valid) {
					this.loading = true
					axios.post(base_url + '/Baseconfig/index',this.form).then(res => {
						if(res.data.status == 200){
							this.$message({message: res.data.msg, type: 'success'})
						}else{
							this.loading = false
							this.$message.error(res.data.msg)
						}
					}).catch(()=>{
						this.loading = false
					})
				}
			})
		},
		setDefaultVal(key){
			if(this.form[key] == null || this.form[key] == ''){
				this.form[key] = []
			}
		},
	}
})
</script>

</body>
</html>