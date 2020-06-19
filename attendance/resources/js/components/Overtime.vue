<template>
    <div class="col-8 mx-auto">
        <div class="card">
            <div class="card-header h3">
                <span v-on:click="changeApplyForm" role="button" v-bind:class="applyClass">残業申請</span>
                <span v-on:click="changeListForm" role="button" v-bind:class="listClass">申請一覧</span>
            </div>

            <div v-if="applyForm">

                <div v-for="(error, index) in errors" class="mt-3" v-bind:key="index">
                    <div class="alert alert-danger" role="alert">{{ error }}</div>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="date" class="h4">勤務日</label>
                        <div class="row">
                            <input v-model="date" class="form-control col-5" type="date" id="date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="overtime" class="h4">残業時間(時間：分)</label>
                        <div class="row">
                            <input v-model="overtime" class="form-control col-5" type="time" id="overtime" step="900" min="00:00" max="10:00" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reason" class="h4">申請理由</label>
                        <div class="row">
                            <textarea v-model="reason" class="form-control" id="reason" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <button v-on:click="apply" class="btn btn-primary">申請</button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else>
                <div v-if="deleteErr" class="alert alert-danger" role="alert">{{ deleteErr }}</div>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">勤務日</th>
                            <th scope="col">残業時間</th>
                            <th scope="col">許可</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="!applyLists.length">
                            <td>なし</td>
                            <td>なし</td>
                            <td>なし</td>
                        </tr>
                        <tr v-for="(applyList, index) in applyLists" v-bind:key="index">
                            <td>{{ applyList.date }}</td>
                            <td>{{ applyList.overtime.slice(0, -3) }}</td>
                            <td>{{ applyList.is_permitted ? '許可された' : '申請中' }}</td>
                            <td><button v-on:click="deleteApply(index)" class="btn btn-danger">削除</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            applyForm: true,
            applyClass: 'border-bottom border-primary mr-4',
            listClass: '',

            date: '',
            overtime: '00:00',
            reason: '',

            applyLists: {},

            errors: [],
            deleteErr: '',
        }
    },
    created() {
        this.getApply();
    },
    methods: {
        changeApplyForm() {
            this.applyForm = true;
            this.applyClass = 'border-bottom border-primary mr-4';
            this.listClass = '';
        },
        changeListForm() {
            this.errors = [];
            this.applyForm = false;
            this.applyClass = '';
            this.listClass = 'border-bottom border-primary ml-4'
        },
        getApply() {
            axios.get('/api/overtimes')
            .then(res => {
                this.applyLists = res.data;
            })
        },
        apply() {
            this.errors = [];
            if (!(this.overtime > '00:00' && this.overtime <= '10:00')) {
                this.errors.push('残業時間を10時間以内にしてください');
                return;
            }
            axios.post('/api/overtimes', {
                date: this.date,
                overtime: this.overtime,
                reason: this.reason,
            })
            .then(res => {
                this.$router.push('/attendance');
                this.$parent.success = '申請しました';
                this.$parent.successDelete();
            })
            .catch(err => {
                Object.keys(err.response.data.errors).forEach(function(element) {
                    this.errors.push(err.response.data.errors[element]);
                }, this);
            })
        },
        deleteApply(index) {
            axios.delete('/api/overtimes/' + this.applyLists[index].id)
            .then(res => {
                this.getApply();
            })
            .catch(err => {
                this.deleteErr = '削除に失敗しました';
            })
        }
    }
}
</script>
