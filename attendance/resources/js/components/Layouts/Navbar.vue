<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <div class="navbar-brand">
                勤怠管理システム
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="nav-link">{{ date }}</span>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" action="/logout" v-on:click="logout">
                                ログアウト
                            </a>

                            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                <input type="hidden" name="_token" v-bind:value="csrf.slice(1).slice(0, -1)">
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-primary bg-primary mb-5">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <div><i class="far fa-clock fa-2x"></i></div>
                <router-link class="navbar-brand text-dark" to="/attendance">出退勤画面</router-link>
            </li>
            <li class="nav-item">
                <div><i class="far fa-bell fa-2x"></i></div>
                <router-link class="navbar-brand text-dark" to="/overtime">残業申請画面</router-link>
            </li>
            <li class="nav-item">
                <div><i class="far fa-user fa-2x"></i></div>
                <router-link class="navbar-brand text-dark" to="/user">作業者情報画面</router-link>
            </li>
        </ul>
    </nav>
    <div v-if="success" class="alert alert-success">
        {{ success }}
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
    props: {
        csrf: {
            type: String,
            required: true,
      }
    },
    data() {
        return {
            name: '',
            success: '',
        }
    },
    computed: {
        date() {
            return this.$dayjs().format('YYYY年MM月DD日')
        }
    },
    created() {
        axios.get('/api/identity')
        .then(res => {
            this.name = res.data.name;
        })
        .catch(err => {
            alert(err.response.data);
        })

    },
    methods: {
        logout() {
            document.getElementById('logout-form').submit();
        },
        successDelete() {
            setTimeout(() => {
                this.success = '';
            }, 3000);
        }
    }
}
</script>
