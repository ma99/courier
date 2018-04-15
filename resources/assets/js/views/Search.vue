<template>
	<div>
		<section class="content-header">
      <h3>Search</h3> 
      <hr>     
    </section>

     <!-- Main content -->
    <section class="content">            
      <div class="row justify-content-center">        
          <div class="col-sm-10">         
            <form>
              <div class="form-group row justify-content-center">
                <!-- <label class="col-sm-2 col-form-label col-form-label-sm">Search By: </label> -->
                <div class="search-by">                  
                  <!-- <label class="col-sm-3 col-form-label col-form-label-md">Search By: </label> -->
                  <span class="search-by-label"> Search By: </span>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="searchRadios" id="searchRadios1" value="searchByBookingRef" v-model="searchBy" v-on:click="isActive=true">
                    <label class="form-check-label" v-bind:class="{ active: isActive }" for="searchRadios1">
                      Booking Reference
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="searchRadios" id="searchRadios2" value="searchByNameOrPhone" v-model="searchBy" v-on:click="isActive=false">
                    <label class="form-check-label" v-bind:class="{ active: !isActive }" for="searchRadios2">
                      Name/ Phone Number
                    </label>
                  </div>                                          
                </div>                                           
              </div>

              <div id="sandbox-container">
                <div class="form-row justify-content-center">
                    <div class="form-group col-sm-6">
                      <div class="input-group date">  
                        <input type="text" class="form-control" :placeholder="placeHolderText" v-model="searchText">
                        <div class="input-group-append input-group-addon">
                            <span class="input-group-text">                        
                              <i class="fa fa-calendar" aria-hidden="true"></i>
                            </span>
                        </div>                      
                      </div>
                    </div>
                                
                    <div class="form-group col-sm-2">                
                      <button type="submit" class="btn btn-primary" :disabled="!isValid" v-on:click.prevent="search()">
                         <i class="fa fa-search" aria-hidden="true"></i>
                      </button>
                    </div>
                </div>
              </div> 
              <div class="alert-area">
                  <show-alert :show.sync="showAlert" :type="alertType"> 
                        Found Nothing!!
                  </show-alert>
              </div>         
            </form>
          </div>
        <div class="report-area" v-show="showReportArea">  
          <div class="card border-primary">
            <div class="card-header text-white bg-primary">
              Search Result <span> &nbsp;</span>
              <!-- <em> 
                {{ date.showStartDate }} <span> &nbsp; </span> to <span> &nbsp; </span> {{ date.showEndDate }}
              </em>  --> 
            </div>
            <div class="card-body">
              <div id="scroll-items">
                <table class="table table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" class="align-top">#</th>
                        <th scope="col" class="align-top">Booking Ref.</th>
                        <th scope="col" class="align-top">Shipment Date</th>
                        <th scope="col" class="align-top">Customer Name</th>
                        <th scope="col" class="align-top">Phone</th>
                        <th scope="col" class="align-top">Item</th>
                        <th scope="col" class="align-top">Weight (kg)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(booking, index) in searchInfo">
                        <th scope="row"> {{ index+1 }} </th>
                        <td> {{booking.booking_ref}} </td>
                        <td> {{booking.date}} </td>
                        <td> {{booking.customer_name}} </td>
                        <td> {{booking.customer_phone}} </td>
                        <td> {{booking.items}} </td>
                        <td> {{booking.weight}} </td>                  
                      </tr> 
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>                                
                    </tbody>
                </table>
              </div>
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
            error: '', 
            isActive: true,
            placeHolderText: 'Enter Reference Number Here',           
            response: '',
            searchText: '',
            searchBy: 'searchByBookingRef',            
            searchButton: '',
            searchInfo: '',
            showReportArea: false,
            url: '/api/searchByBookingRef?q=',
          }
        },
        mounted() {                   
          // this.showStartDate();
          // this.showEndDate();
          // this.enableSlimScroll();          
        },
        watch: {                    
            searchBy() {
                 this.url = '/api/'+this.searchBy+'?q=';
                 this.setPlaceHolderText(this.searchBy);
            },
            searchText() {
              this.searchInfo = '';
            }

        },
         computed: {
            isValid() {                
                return this.searchText != ''
            },
        },       
        methods: {
          setPlaceHolderText(text) {
            this.placeHolderText = (text== 'searchByBookingRef') ? 'Enter Reference Number Here' : 'Enter Name Or Phone Number Here';
          },         
          search() {
            let query = this.searchText;           
            var vm = this;
            this.showAlert = false;
            //axios.get('/api/search?q=' + query)
            axios.get(this.url + query)
            .then(function (response) {                  
                 response.data.error ? vm.error = response.data.error : vm.searchInfo = response.data;
                 //console.log(vm.searchInfo);
                 //vm.loading = false;
                 if (vm.searchInfo == '') {
                  vm.showAlert = true;
                  vm.showReportArea = false;
                  return;
                 }
                 vm.showReportArea = true;                  
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
  .active {
      font-weight: 600;
  }
  .report-area {    
    margin-top: 1.5rem;
  }
  .search-by {
    // border-bottom: 1px dashed #8ab298;
    margin-bottom: 1.5rem;
    padding: 0.625rem;
    margin-left: -98px;
    width: 55%;
    color: #9d7791;
  }
  span.search-by-label {
    margin-right: 1rem;
    color: #4a91e7;
    font-weight: 600;
  }
  td.text-center {
    text-align: center;
  }
   #scroll-items {
        span {
            cursor: pointer;
            margin-left: 5px;
        }
        span[disabled] {
            cursor: not-allowed;
            opacity: 0.65;
        }
    }   
</style>