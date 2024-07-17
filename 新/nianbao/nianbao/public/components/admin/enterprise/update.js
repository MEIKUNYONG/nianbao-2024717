Vue.component('Update', {
	template: `
		<el-dialog title="修改" width="600px" class="icon-dialog" :visible.sync="show" @open="open" :before-close="closeForm" append-to-body>
			<el-form :size="size" ref="form" :model="form" :rules="rules" :label-width=" ismobile()?'90px':'16%'">
				<el-row >
					<el-col :span="24">
						<el-form-item label="企业名称" prop="enterprise_name">
							<el-input  v-model="form.enterprise_name" autoComplete="off" clearable :disabled="true" placeholder="请输入企业名称"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="信用代码" prop="enterprise_code">
							<el-input  v-model="form.enterprise_code" autoComplete="off" clearable :disabled="true"  placeholder="请输入信用代码"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="法人代表" prop="legal_person">
							<el-input  v-model="form.legal_person" autoComplete="off" clearable  :disabled="true" placeholder="请输入法人代表"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="手机号" prop="mobile">
							<el-input  v-model="form.mobile" autoComplete="off" clearable  placeholder="请输入手机号"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row >
					<el-col :span="24">
						<el-form-item label="价格类别" prop="is_special">
							<el-radio-group v-model="form.is_special">
								<el-radio :label="0">正常价格</el-radio>
								<el-radio :label="1">特价</el-radio>
							</el-radio-group>
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
	`
	,
	components:{
	},
	props: {
		show: {
			type: Boolean,
			default: false
		},
		size: {
			type: String,
			default: 'small'
		},
		info: {
			type: Object,
		},
	},
	data(){
		return {
			form: {
				enterprise_name:'',
				is_special:0,
				enterprise_code:'',
				mobile:'',
				legal_person:'',
			
				status:1,
			},
			loading:false,
			rules: {
				enterprise_name:[
					{required: true, message: '企业名称不能为空', trigger: 'blur'},
				],
				enterprise_code:[
					{required: true, message: '企业代码不能为空', trigger: 'blur'},
				],
				legal_person:[
					{required: true, message: '法人代表人名称不能为空', trigger: 'blur'},
				],
				mobile:[
					{pattern:/^1[3456789]\d{9}$/, message: '手机号格式错误'}
				],
			}
		}
	},
	methods: {
		open(){
			this.form = this.info
	
		},
		submit(){
			this.$refs['form'].validate(valid => {
				if(valid) {
					this.loading = true
					axios.post(base_url + '/Enterprise/update',this.form).then(res => {
						if(res.data.status == 200){
							this.$message({message: res.data.msg, type: 'success'})
							this.$emit('refesh_list')
							this.closeForm()
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
		closeForm(){
			this.$emit('update:show', false)
			this.loading = false
			if (this.$refs['form']!==undefined) {
				this.$refs['form'].resetFields()
			}
		},
	}
})
