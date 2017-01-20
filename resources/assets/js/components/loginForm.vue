<template>
<form class="form-horizontal" role="form" @submit.prevent="onSubmit" method="POST">
    <div class="form-group" :class="{'has-error': errors.email}">
        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

        <div class="col-md-6">
            <input id="email" v-model="form.email" type="email" class="form-control" name="email" autofocus>
            <span class="help-block" v-if="errors.email">
                <strong v-for="error in errors.email" v-text="error"></strong>
            </span>
        </div>
    </div>

    <div class="form-group" :class="{'has-error': errors.password}">
        <label for="password" class="col-md-4 control-label">Password</label>

        <div class="col-md-6">
            <input id="password" v-model="form.password" type="password" class="form-control" name="password">
            <span class="help-block" v-if="errors.password">
                <strong v-for="error in errors.password" v-text="error"></strong>
            </span>
        </div>
    </div>

    <p class="text-danger text-center" v-if="errors.invalid">
        <strong v-text="errors.invalid"></strong>
    </p>

    <p class="text-danger text-center" v-if="errors.general">
        <strong v-text="errors.general"></strong>
    </p>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" v-model="form.remember" :checked="{'checked': form.remember}"> Remember Me
                </label>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-8 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                Login
            </button>

            <a class="btn btn-link" href="/password/reset">
                Forgot Your Password?
            </a>
        </div>
    </div>
</form>
</template>

<script>
    export default {
        data: function() {
            return {
                form: {
                    email: '',
                    password: '',
                    remember: false
                },
                errors: {}
            };
        },
        methods: {
            onSubmit() {
                this.$http.post('/api/login', this.form).then(response => {
                    window.location.replace(response.data.redirectTo);
                })
                .catch(response => {
                    if (response.data.errors) {
                        this.errors = response.data.errors;
                    } else {
                        this.errors = { general: 'An unexpected error occurred. Please try again later.' };
                    }
                });
            }
        }
    }
</script>
