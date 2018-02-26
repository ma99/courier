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
                        <div class="alert-area">
                            <show-alert :show.sync="showAlert" :type="alertType"> 
                                  <!-- altert type can be info/warning/danger -->
                                  <strong>User </strong> has been 
                                  <strong> Added </strong> successfully!
                                </show-alert>
                          </div>
                          <div class="alert-area" v-show="error">
                            <div class="alert alert-warning" role="alert">
                                <div v-for="(value, key, index) in error">
                                  {{ index+1 }}. {{ value }}
                                </div>
                            </div>
                          </div>         
                        <div class="form-group row" :class="{'has-error': errors.has('name') }">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Full Name</label>

                            <div class="col-md-6">
                                <input v-model="user.name" v-validate="'required|alpha'" id="name" type="text" class="form-control" name="name" required autofocus>
                            <p class="text-danger" v-if="errors.has('email')">{{ errors.first('name') }}</p>
                            </div>

                        </div>

                        <div class="form-group row" :class="{'has-error': errors.has('username') }">
                            <label for="username" class="col-md-4 col-form-label text-md-right">User Login Name</label>

                            <div class="col-md-6">
                                <input v-model="user.username" v-validate="'required'" id="username" type="text" class="form-control" name="username" placeholder="Will be used as login to app" required autofocus>
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
            alertType: 'success',                           
            showAlert: false,
            response: '',
            error: '',
            user: {
                name: '',
                username: '',
                email: '',
                password: '123456'
            }   
          }                                 
        },                
         computed: {
            isValid() {                
                return this.user.name != '' && 
                        this.user.username != '' &&
                        this.user.email != '' &&
                        this.user.password != '' &&
                        this.errors.any() == '' 
            },
        },       
        methods: {
          reset() {
            this.user.name == '' ; 
            this.user.username == '' ;
            this.user.email == '' ;
            this.user.password == '123456';            
          },            
          save() {
            var vm = this;                                   
            axios.post('/register-user', {                
                user: this.user,                
            })            
            .then(function (response) {                  
                 response.data.error ? vm.error = response.data.error : vm.response = response.data;
                 //console.log(response.data);
                 if (vm.response == 'Success') {
                    vm. reset();
                    vm.error= '';
                    vm.showAlert = true; 
                 }                          
            })
            .catch(function (error) {
                         vm.error = error.response.data.errors;
                        console.log(error.response.data.errors);
                    });
          },
      }   
    }
</script>

<style lang="scss" scoped>
    .alert-area {
        margin: 1.5rem 1rem 2.5rem 3.5rem;
        
    }
</style>