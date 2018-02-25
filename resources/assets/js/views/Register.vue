<template>
	<div>
		<section class="content-header">
      <h2>Add New User</h2> 
      <hr>     
    </section>

     <!-- Main content -->
    <section class="content"> 
      <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Register</div>

                <div class="card-body">
                    <form>                        

                        <div class="form-group row" :class="{'has-error': errors.has('name') }">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Full Name</label>

                            <div class="col-md-6">
                                <input v-model="user.name" v-validate="'required|alpha'" id="name" type="text" class="form-control" name="name" required autofocus>
                            <p class="text-danger" v-if="errors.has('email')">{{ errors.first('name') }}</p>
                            </div>

                        </div>

                        <div class="form-group row" :class="{'has-error': errors.has('username') }">
                            <label for="username" class="col-md-4 col-form-label text-md-right">User Name</label>

                            <div class="col-md-6">
                                <input v-model="user.userName" v-validate="'required'" id="username" type="text" class="form-control" name="username" placeholder="Will be used as login to app" required autofocus>
                            <p class="text-danger" v-if="errors.has('email')">{{ errors.first('username') }}</p>
                            </div>
                        </div>

                        <div class="form-group row" :class="{'has-error': errors.has('email') }">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input v-model="user.email" v-validate="'required|email'" id="email" type="email" class="form-control" name="email" required>
                            <p class="text-danger" v-if="errors.has('email')">{{ errors.first('email') }}</p>
                            </div>
                        </div>

                        <div class="form-group row" :class="{'has-error': errors.has('password') }">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input v-model="user.password" v-validate="'required|min:6'" id="password" type="password" class="form-control" name="password" required>
                            <p class="text-danger" v-if="errors.has('password')">{{ errors.first('email') }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" :disabled="!isValid" v-on:click.prevent="save()">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>         

    </section>
  </div>
</template>

<script>
    export default {
    	data() {
          return { 
            alertType: 'warning',                           
            showAlert: false,
            response: '',
            user: {
                name: '',
                userName: '',
                email: '',
                password: '123456'
            }   
          }                                 
        },                
         computed: {
            isValid() {                
                return this.user.name != '' && 
                        this.user.userName != '' &&
                        this.user.email != '' &&
                        this.user.password != '' &&
                        this.errors.any() == '' 
            },
        },       
        methods: {           
          save() {
            var vm = this;                                   
            axios.post('/register-user', {                
                user: this.user,                
            })            
            .then(function (response) {                  
                 response.data.error ? vm.error = response.data.error : vm.respons = response.data;
                 console.log(vm.searchInfo);
                 //vm.loading = false;                  
            });
          },
      }   
    }
</script>

<style lang="scss" scoped>
  
</style>