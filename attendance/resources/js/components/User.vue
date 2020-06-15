<template>
    <div class="col-8 mx-auto">

        <!-- ユーザー情報画面 -->
        <div v-if="showForm" class="card">
            <div class="card-header">
                ユーザー情報
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">名前</label>
                    <div class="form-control">{{ name }}</div>
                </div>
                <div class="form-group">
                    <label for="">メールアドレス</label>
                    <div class="form-control">{{ email }}</div>
                </div>
                <button type="button" class="btn btn-primary" v-on:click="changePass">編集する</button>
            </div>
        </div>

        <!-- パスワード確認画面 -->
        <div v-if="passForm" class="card">
            <div class="card-header">
                パスワードを入力してください
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">パスワード</label>
                    <input v-model="oldPass" type="password" name="password" class="form-control">
                </div>
                <button type="button" class="btn btn-primary" v-on:click="passConfirm">確定</button>
                <button type="button" class="btn btn-danger" v-on:click="changeShow">キャンセル</button>
            </div>
        </div>

        <!-- ユーザー更新画面 -->
        <div v-if="updateForm" class="card">
            <div class="card-header">
                ユーザー更新
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">名前</label>
                    <input v-model="updateName" type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">メールアドレス</label>
                    <input v-model="updateEmail" type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">新しいパスワード</label>
                    <input v-model="updatePass" type="password" name="password" class="form-control" placeholder="変更しない場合は空欄にしてください">
                </div>
                <div class="form-group">
                    <label for="">新しいパスワード(確認)</label>
                    <input v-model="updatePassConfirm" type="password" name="password_confirmation" class="form-control" placeholder="変更しない場合は空欄にしてください">
                </div>
                <button type="button" class="btn btn-primary" v-on:click="updateUser">更新</button>
                <button type="button" class="btn btn-danger" v-on:click="changeShow">キャンセル</button>
            </div>
        </div>
        
        <!-- ローディング -->
        <div class="d-flex justify-content-center">
            <div v-if="loading" class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
            </div>
        </div>
        
        <!-- エラーメッセージ -->
        <div v-if="emailError" class="alert alert-warning" role="alert">{{ emailError }}</div>
        <div v-if="passError" class="alert alert-warning" role="alert">{{ passError }}</div>
        <div v-if="errored" class="alert alert-warning" role="alert">{{ errored }}</div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showForm: true,
            passForm: false,
            updateForm: false,

            name: '',
            email: '',

            oldPass: '',

            updateName: '',
            updateEmail: '',
            updatePass: '',
            updatePassConfirm: '',
            updateData: {},

            errored: '',
            emailError: '',
            passError: '',
            loading: false,

        }
    },
    created() {
        this.getUser();
    },
    methods: {
        getUser() {
            this.loading = true;

            axios.get('/api/identity')
            .then(res => {
                this.name = res.data.name;
                this.email = res.data.email;
            })
            .catch(err => {
                console.log(err);
                this.errored = err.response.data;
            })
            .finally(() => {
                this.loading = false
            })
        },
        changePass() {
            this.showForm = false;
            this.passForm = true;
        },
        passConfirm() {
            this.errored = '';
            this.loading = true;
            axios.post('/api/identity/confirm-password', {
                old_password: this.oldPass,
            })
            .then(res => {
                this.passForm = false;
                this.updateForm = true;
                this.updateName = this.name;
                this.updateEmail = this.email;
                this.updatePass = '';
                this.updatePassConfirm = '';
            })
            .catch(err => {
                this.errored = err.response.data.errors.old_password;
            })
            .finally(() => {
                this.loading = false
            })
        },
        changeShow() {
            this.showForm = true;
            this.passForm = false;
            this.updateForm = false;
            this.oldPass = '';
            this.emailError = '';
            this.passError = '';
            this.errored = '';
        },
        updateUser() {
            this.emailError = '';
            this.passError = '';
            this.errored = '';
            this.loading = true;

            this.updateData['name'] = this.updateName;
            this.updateData['email'] = this.updateEmail;
            this.updateData['old_password'] = this.oldPass;

            if (!this.emailValidate() || !this.passValidate()) {
                return;
            } 

            axios.put('/api/identity', this.updateData)
            .then(res => {
                this.name = res.data.name;
                this.email = res.data.email;
                this.updateName = res.data.name;
                this.updateEmail = res.data.email;
                this.changeShow();
            })
            .catch(err => {
                this.errored = err.response.data;
            })
            .finally(() => {
                this.loading = false
            })
        },
        //バリデーション
        emailValidate() {
            let pattern = /.+@.+\..+/;
            if (!this.updateEmail.match(pattern)) {
                this.emailError = 'メールアドレスがおかしいです';
                this.loading = false;
                return false;
            }
            return true;
        },
        passValidate() {
            if (this.updatePass || this.updatePassConfirm) {
                if (this.updatePass.length < 4) {
                    this.passError = 'パスワードは4文字以上にしてください';
                    this.loading = false;
                    return false;
                }
                if ((this.updatePass !== this.updatePassConfirm)　||
                    (!this.updatePass || !this.updatePassConfirm)) {
                    this.passError = 'パスワードが一致していません';
                    this.loading = false;
                    return false;
                }
                this.updateData['password'] = this.updatePass;
                this.updateData['password_confirmation'] = this.updatePassConfirm;
                return true;
            }
            return true;
        }
    },
}
</script>