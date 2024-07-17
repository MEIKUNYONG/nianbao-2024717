<?php /*a:2:{s:53:"/www/wwwroot/nianbao/app/admin/view/member/index.html";i:1688114545;s:57:"/www/wwwroot/nianbao/app/admin/view/common/container.html";i:1693629258;}*/ ?>
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
<el-card shadow="never" style="min-height:650px;">
<div v-if="search_visible" id="search" class="search">
	<el-form ref="form" size="small" :model="searchData" inline>
		<el-form-item label="用户名">
			<el-input id="username" v-model="searchData.username"  style="width:150px;" placeholder="请输入用户名"></el-input>
		</el-form-item>
		
		<el-form-item label="手机号">
			<el-input id="mobile" v-model="searchData.mobile"  style="width:150px;" placeholder="请输入手机号"></el-input>
		</el-form-item>
		
		<el-form-item label="状态">
			<el-select style="width:150px" v-model="searchData.status" filterable clearable placeholder="请选择">
				<el-option key="0" label="开启" value="1"></el-option>
				<el-option key="1" label="关闭" value="0"></el-option>
			</el-select>
		</el-form-item>
	
		<el-form-item label="创建时间">
			<el-date-picker value-format="yyyy-MM-dd HH:mm:ss" type="daterange" v-model="searchData.create_time" clearable range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期"></el-date-picker>
		</el-form-item>
		<search-tool :search_data.sync="searchData" :is_clear.sync="is_clear" @refesh_list="index"></search-tool>
	</el-form>
</div>
<div class="btn-group" style="margin-top:10px;margin-bottom:10px;">
	<div>
		<el-button v-for="item in button_group" :key="item.access" v-if="checkPermission(item.access,'<?php echo implode(',',session('admin.access')); ?>','<?php echo session('admin.role_id'); ?>',[1])" :disabled="$data[item.disabled]" :type="item.color" size="mini" :icon="item.icon" @click="fn(item.clickname)">
			<span v-if="item.batch" v-text="$data['batchUpdateStatus']?'批量保存':'批量编辑'"></span>
			<span v-else v-text="item.name"></span>
		</el-button>
	</div>
	<div><table-tool :search_visible.sync="search_visible"  @refesh_list="index"></table-tool></div>
</div>
<el-table :row-class-name="rowClass" @selection-change="selection"  @row-click="handleRowClick"  row-key="id"  :header-cell-style="{ background: '#eef1f6', color: '#606266' }" @sort-change='sortChange' v-loading="loading"  ref="multipleTable" border class="eltable" :data="list"  style="width: 100%">
	<el-table-column align="center" type="selection" width="42"></el-table-column>
	<el-table-column align="center" type = '' property="id"  label="编号"  width="70">
	</el-table-column>
	<el-table-column align="center"  property="nickname"  label="用户名"  width="">
	</el-table-column>

	<el-table-column align="center"  property="avatar"  label="头像"  width="">
		<template slot-scope="scope">
			<div class="demo-image__preview">
				<el-image v-if="scope.row.avatar" class="table_list_pic" :src="scope.row.avatar"  :preview-src-list="[scope.row.avatar]"></el-image>
			</div>
		</template>
	</el-table-column>
	<el-table-column align="center"  property="mobile"  label="手机号"  width="">
	</el-table-column>


	
	<el-table-column align="center"  property="create_time"  label="创建时间"  width="">
		<template slot-scope="scope">
			{{parseTime(scope.row.create_time)}}
		</template>
	</el-table-column>
	<el-table-column :fixed="ismobile()?false:'right'" label="操作" align="center" width="180">
		<template slot-scope="scope">
			<div v-if="scope.row.id">
				<el-button v-if="checkPermission('/admin/Member/binding.html','<?php echo implode(",",session("admin.access")); ?>','<?php echo session("admin.role_id"); ?>',[1])" size="mini" type="primary" @click="binding(scope.row)" >查看绑定企业</el-button>
				
			</div>
		</template>
	</el-table-column>
</el-table>
<Page :total="page_data.total" :page.sync="page_data.page" :limit.sync="page_data.limit" @pagination="index" />
</el-card>

<!--添加-->
<Add :show.sync="dialog.addDialogStatus" size="small" @refesh_list="index"></Add>
<!--修改-->
<Update :info="updateInfo" :show.sync="dialog.updateDialogStatus" size="small" @refesh_list="index"></Update>


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
<script src="/assets/libs/xlsx/xlsx.core.min.js"></script>
<script src="/components/admin/member/add.js?v=<?php echo rand(1000,9999)?>"></script>
<script src="/components/admin/member/update.js?v=<?php echo rand(1000,9999)?>"></script>

<script>
new Vue({
	el: '#app',
	components:{
	},
	data: function() {
		return {
			dialog: {
				addDialogStatus : false,
				updateDialogStatus : false,
				detailDialogStatus : false,
				resetPwdDialogStatus : false,
				jiaDialogStatus : false,
				jianDialogStatus : false,
				importDataDialogStatus : false,
			},
			searchData:{},
			button_group:[
			/*	{name:'添加',color:'success',access:'/admin/Member/add.html',icon:'el-icon-plus',disabled:'',clickname:'add'},
				{name:'修改',color:'primary',access:'/admin/Member/update.html',icon:'el-icon-edit',disabled:'single',clickname:'update'},*/
			
				
			],
			loading: false,
			page_data: {
				limit: 20,
				page: 1,
				total:20,
			},
			order:'',
			sort:'',
			ids: [],
			single:true,
			multiple:true,
			search_visible:true,
			list: [],
			updateInfo:{},
			detailInfo:{},
			resetPwdInfo:{},
			jiaInfo:{},
			jianInfo:{},
			exceldata:[],
			dumppage:1,
			ws:{},
			dumpshow:false,
			percentage:0,
			filename:'',
			exceldata:[],
			dumppage:1,
			ws:{},
			dumpshow:false,
			percentage:0,
			filename:'',
			sum_amount:'',
			is_clear:false,
		}
	},
	methods:{
		index(){
			let param = {limit:this.page_data.limit,page:this.page_data.page,order:this.order,sort:this.sort}
			Object.assign(param, this.searchData,this.urlobj)
			this.loading = true
			axios.post(base_url + '/Member/index',param).then(res => {
				if(res.data.status == 200){
					this.list = res.data.data.data
					this.page_data.total = res.data.data.total
					this.sum_amount = res.data.sum_amount
					this.loading = false
				}else{
					this.$message.error(res.data.msg);
				}
			})
		},
		updateExt(row,field){
			if(row.id){
				axios.post(base_url + '/Member/updateExt',{id:row.id,[field]:row[field]}).then(res => {
					if(res.data.status == 200){
						this.$message({message: res.data.msg, type: 'success'})
					}else{
						this.$message.error(res.data.msg)
					}
				})
			}
		},
		add(){
			this.dialog.addDialogStatus = true
		},
		update(row){
			let id = row.id ? row.id : this.ids.join(',')
			axios.post(base_url + '/Member/getUpdateInfo',{id:id}).then(res => {
				if(res.data.status == 200){
					this.dialog.updateDialogStatus = true
					this.updateInfo = res.data.data
				}else{
					this.$message.error(res.data.msg)
				}
			})
		},
		del(row){
			this.$confirm('确定操作吗?', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(() => {
				let ids = row.id ? row.id : this.ids.join(',')
				axios.post(base_url + '/Member/delete',{id:ids}).then(res => {
					if(res.data.status == 200){
						this.$message({message: res.data.msg, type: 'success'})
						this.index()
					}else{
						this.$message.error(res.data.msg)
					}
				})
			}).catch(() => {})
		},
		binding(row){
			let query = {}
			let ids = row.id ? row.id : this.ids.join(',')
			let data = {}
			this.list.forEach((item,i) => {
				if(item.id == ids){
					data = this.list[i]
				}
			})
			Object.assign(query, {id:data.id})
			Object.assign(query, {jumpstate:1})
			window.location.href = base_url+"/Member/binding.html?"+param(query)
		},
		detail(row){
			this.dialog.detailDialogStatus = true
			this.detailInfo = {id:row.id ? row.id : this.ids.join(',')}
		},
		resetPwd(row){
			this.dialog.resetPwdDialogStatus = true
			this.resetPwdInfo = {id:row.id ? row.id : this.ids.join(',')}
		},
		jia(row){
			this.dialog.jiaDialogStatus = true
			this.jiaInfo = {id:row.id ? row.id : this.ids.join(',')}
		},
		jian(row){
			this.dialog.jianDialogStatus = true
			this.jianInfo = {id:row.id ? row.id : this.ids.join(',')}
		},
		importData(){
			this.dialog.importDataDialogStatus = true
		},
		dumpdata(){
			this.$confirm('确定操作吗?', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(() => {
				this.dumpshow = true
				this.confirmdumpdata()
			}).catch(() => {})
		},
		confirmdumpdata(){
			let query = {page:this.dumppage,order:this.order,sort:this.sort}
			Object.assign(query, this.searchData,{id:this.ids.join(',')},this.urlobj)
			axios.post(base_url + '/Member/dumpdata',query).then(res => {
				if(res.data.data && res.data.data.length > 0){
					if(this.dumppage == 1){
						this.exceldata.push(res.data.header)
					}
					res.data.data.forEach((item) => {
						this.exceldata.push(Object.values(item))
					})
					this.percentage = res.data.percentage
					this.filename = res.data.filename
					this.ws = XLSX.utils.aoa_to_sheet(this.exceldata)
					this.dumppage = this.dumppage + 1
					this.confirmdumpdata()
				}else{
					let wb = XLSX.utils.book_new()
					XLSX.utils.book_append_sheet(wb, this.ws)
					XLSX.writeFile(wb, this.filename)
					this.exceldata = []
					this.dumpshow = false
					this.dumppage = 1
					this.percentage = 0
				}
			})
		},
		closedialog(){
			this.dumpshow = false
		},
		dumpdata2(){
			this.$confirm('确定操作吗?', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(() => {
				this.dumpshow = true
				this.confirmdumpdata2()
			}).catch(() => {})
		},
		confirmdumpdata2(){
			let query = {page:this.dumppage,order:this.order,sort:this.sort}
			Object.assign(query, this.searchData,{id:this.ids.join(',')},this.urlobj)
			axios.post(base_url + '/Member/dumpdata2',query).then(res => {
				if(res.data.state == 'ok'){
					this.percentage = res.data.percentage
					this.dumppage = this.dumppage + 1
					this.confirmdumpdata2()
				}else{
					this.dumpshow = false
					this.dumppage = 1
					location.href = base_url + '/Member/dumpdata2?state=ok&'+param(query)
				}
			})
		},
		closedialog(){
			this.dumpshow = false
		},
		forbidden(row){
			this.$confirm('确定操作吗?', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(() => {
				let ids = row.id ? row.id : this.ids.join(',')
				axios.post(base_url + '/Member/forbidden',{id:ids}).then(res => {
					if(res.data.status == 200){
						this.$message({message: res.data.msg, type: 'success'})
						this.index()
					}else{
						this.$message.error(res.data.msg)
					}
				})
			}).catch(() => {})
		},
		start(row){
			this.$confirm('确定操作吗?', '提示', {
				confirmButtonText: '确定',
				cancelButtonText: '取消',
				type: 'warning'
			}).then(() => {
				let ids = row.id ? row.id : this.ids.join(',')
				axios.post(base_url + '/Member/start',{id:ids}).then(res => {
					if(res.data.status == 200){
						this.$message({message: res.data.msg, type: 'success'})
						this.index()
					}else{
						this.$message.error(res.data.msg)
					}
				})
			}).catch(() => {})
		},
		selection(selection) {
			this.ids = selection.map(item => item.id)
			this.single = selection.length != 1
			this.multiple = !selection.length
		},
		handleRowClick(row, rowIndex,event){
			if(event.target.className !== 'el-input__inner'){
				this.$refs.multipleTable.toggleRowSelection(row)
			}
		},
		rowClass ({ row, rowIndex }) {
			for(let i=0;i<this.ids.length;i++) {
				if (row.id === this.ids[i]) {
					return 'rowLight'
				}
			}
		},
		sortChange(val){
			if(val.order == 'descending'){
				this.order= 'desc'
			}
			if(val.order == 'ascending'){
				this.order= 'asc'
			}
			this.sort = val.prop
			this.index()
		},
		getSummaries(param) {
			const { columns, data } = param;
			const sums = [];
			columns.forEach((column, index) => {
				if(index === 1) {
					sums[index] = '合计'
				}
				if(column.label === '积分') {
					sums[index] = this.sum_amount
				}
			})
			return sums
		},
		fn(method){
			this[method](this.ids)
		},
	},
	mounted(){
		this.index()
	},
})
</script>

</body>
</html>