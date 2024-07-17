Vue.component('Update', {
	template: `
		<el-dialog title="修改" width="600px" class="icon-dialog" :visible.sync="show" @open="open" :before-close="closeForm" append-to-body>
			<el-form :size="size" ref="form" :model="form" :rules="rules" :label-width=" ismobile()?'90px':'16%'">
				<el-row >
					<el-col :span="24">
						<el-form-item label="支付方式" prop="type">
						
							<el-radio  v-model="form.type" label="1" border size="medium">
								微信支付
							</el-radio>
							<el-radio  v-model="form.type" label="2" border size="medium">
								随行付
							</el-radio>
							
						</el-form-item>
					</el-col>
				</el-row>
				
				
				<template v-if="form.type == 1">
				    
                    <el-form-item label="商户号" prop="mch_id" >
                        <el-input  v-model.trim="form.mch_id" autoComplete="off" clearable  placeholder="请输入商户号"></el-input>
                       
                    </el-form-item>
                    <el-form-item label="支付秘钥" prop="pay_secretkey" >
                        <el-input  v-model.trim="form.pay_secretkey" type="password" autoComplete="off" clearable  placeholder="请输入支付秘钥"></el-input>
                       
                    </el-form-item>
                   
                    <el-form-item label="Cert证书" prop="cert_path">
							<Upload  size="small" file_type="file" :file.sync="form.cert_path"></Upload>
				    </el-form-item>
				    <el-form-item label="Key证书" prop="key_path">
							<Upload  size="small" file_type="file" :file.sync="form.key_path"></Upload>
				    </el-form-item>
                </template>
                
                <template v-if="form.type == 2">
				    <el-form-item label="机构号" prop="orgid" >
                        <el-input  v-model.trim="form.orgid" autoComplete="off" clearable  placeholder="请输入机构号"></el-input>
                       
                    </el-form-item>
                    <el-form-item label="商户编号" prop="mno" >
                        <el-input  v-model.trim="form.mno" autoComplete="off" clearable  placeholder="请输入商户编号"></el-input>
                       
                    </el-form-item>
                    <el-form-item label="私钥" prop="privatekey">
						<el-input  type="textarea"  autoComplete="off" v-model="form.privatekey" clearable placeholder="请输入私钥"/>
					</el-form-item>
                    <el-form-item label="公钥" prop="sxfpublic">
						<el-input  type="textarea"  autoComplete="off" v-model="form.sxfpublic" clearable placeholder="请输入公钥"/>
					</el-form-item>
                   
                </template>
				
				<el-row >
					<el-col :span="24">
						<el-form-item label="状态" prop="status">
							<el-switch :active-value="1" :inactive-value="0" v-model="form.status"></el-switch>
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
				type:"1",
				status:1,
			},
			loading:false,
			rules: {
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
					axios.post(base_url + '/Pay/update',this.form).then(res => {
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
			/*if (this.$refs['form']!==undefined) {
				this.$refs['form'].resetFields()
			}*/
		},
	}
})
