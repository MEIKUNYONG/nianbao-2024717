<?php /*a:2:{s:50:"/www/wwwroot/nianbao/app/admin/view/log/index.html";i:1686984918;s:57:"/www/wwwroot/nianbao/app/admin/view/common/container.html";i:1693629258;}*/ ?>
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
		<el-form-item label="创建时间">
			<el-date-picker value-format="yyyy-MM-dd HH:mm:ss" type="daterange" v-model="searchData.create_time" clearable range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期"></el-date-picker>
		</el-form-item>
		<el-form-item label="类型">
			<el-select style="width:150px" v-model="searchData.type" filterable clearable placeholder="请选择">
				<el-option key="0" label="登录日志" value="1"></el-option>
				<el-option key="1" label="操作日志" value="2"></el-option>
				<el-option key="2" label="异常日志" value="3"></el-option>
			</el-select>
		</el-form-item>
		<search-tool :search_data.sync="searchData" @refesh_list="index"></search-tool>
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
	<el-table-column align="center"  property="application_name"  label="应用名"  width="100">
	</el-table-column>
	<el-table-column align="center"  property="username"  label="用户名"  width="100">
	</el-table-column>
	<el-table-column align="left"  property="url"  label="请求url"  width="">
	</el-table-column>
	<el-table-column align="center"  property="ip"  label="客户端ip"  width="200">
	</el-table-column>
	<el-table-column align="center"  property="create_time"  label="创建时间"  width="200">
		<template slot-scope="scope">
			{{parseTime(scope.row.create_time)}}
		</template>
	</el-table-column>
	<el-table-column align="center"  property="type"  label="类型"  width="200">
		<template slot-scope="scope">
			<el-tag type="info" v-if="scope.row.type == '1'" size="mini" effect="dark">登录日志</el-tag>
			<el-tag type="warning" v-if="scope.row.type == '2'" size="mini" effect="dark">操作日志</el-tag>
			<el-tag type="danger" v-if="scope.row.type == '3'" size="mini" effect="dark">异常日志</el-tag>
		</template>
	</el-table-column>
	<el-table-column :fixed="ismobile()?false:'right'" label="操作" align="center" width="90">
		<template slot-scope="scope">
			<div v-if="scope.row.id">
				<el-button v-if="checkPermission('/admin/Log/delete.html','<?php echo implode(",",session("admin.access")); ?>','<?php echo session("admin.role_id"); ?>',[1])" size="mini" icon="el-icon-delete" type="danger" @click="del(scope.row)" >删除</el-button>
			</div>
		</template>
	</el-table-column>
</el-table>
<Page :total="page_data.total" :page.sync="page_data.page" :limit.sync="page_data.limit" @pagination="index" />
</el-card>

<!--查看详情-->
<Detail :info="detailInfo" :show.sync="dialog.detailDialogStatus" size="small" @refesh_list="index"></Detail>
<!--导出弹窗-->
<el-dialog title="导出进度条" :visible="dumpshow" :before-close="closedialog" width="500px">
	<el-progress :percentage="percentage"></el-progress>
</el-dialog>

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
<script src="/components/admin/log/detail.js?v=<?php echo rand(1000,9999)?>"></script>
<script>
new Vue({
	el: '#app',
	components:{
	},
	data: function() {
		return {
			dialog: {
				detailDialogStatus : false,
			},
			searchData:{},
			button_group:[
				{name:'删除',color:'danger',access:'/admin/Log/delete.html',icon:'el-icon-delete',disabled:'multiple',clickname:'del'},
				{name:'查看详情',color:'info',access:'/admin/Log/detail.html',icon:'el-icon-view',disabled:'single',clickname:'detail'},
				{name:'导出',color:'warning',access:'/admin/Log/dumpdata.html',icon:'el-icon-download',disabled:'',clickname:'dumpdata'},
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
			detailInfo:{},
			exceldata:[],
			dumppage:1,
			ws:{},
			dumpshow:false,
			percentage:0,
			filename:'',
		}
	},
	methods:{
		index(){
			let param = {limit:this.page_data.limit,page:this.page_data.page,order:this.order,sort:this.sort}
			Object.assign(param, this.searchData,this.urlobj)
			this.loading = true
			axios.post(base_url + '/Log/index',param).then(res => {
				if(res.data.status == 200){
					this.list = res.data.data.data
					this.page_data.total = res.data.data.total
					this.loading = false
				}else{
					this.$message.error(res.data.msg);
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
				axios.post(base_url + '/Log/delete',{id:ids}).then(res => {
					if(res.data.status == 200){
						this.$message({message: res.data.msg, type: 'success'})
						this.index()
					}else{
						this.$message.error(res.data.msg)
					}
				})
			}).catch(() => {})
		},
		detail(row){
			this.dialog.detailDialogStatus = true
			this.detailInfo = {id:row.id ? row.id : this.ids.join(',')}
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
			axios.post(base_url + '/Log/dumpdata',query).then(res => {
				if(res.data.state == 'ok'){
					this.percentage = res.data.percentage
					this.dumppage = this.dumppage + 1
					this.confirmdumpdata()
				}else{
					this.dumpshow = false
					location.href = base_url + '/Log/dumpdata?state=ok&'+param(query)
				}
			})
		},
		closedialog(){
			this.dumpshow = false
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