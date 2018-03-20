<template>
	<div>
		<section class="content-header">
      <h2>Report</h2> 
      <hr>     
    </section>

     <!-- Main content -->
    <section class="content">       
     <!-- Your Page Content Here -->   
    <!--  <p> Shipment Page </p>  -->
      <div class="row justify-content-md-center">
        <div class="col-sm-10">          
         <form>            
          <div id="sandbox-container">
            <div class="form-row">
                <div class="form-group col-sm-4">
                 <!--  <label for="inputCity">City</label>          -->       
                  <div class="input-group date">  
                    <input type="text" class="form-control" id="startDate" placeholder="Start Date" v-model="startDate">
                    <div class="input-group-append input-group-addon">
                        <span class="input-group-text">                        
                          <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>                      
                  </div>
                </div>
              
                <div class="form-group col-sm-4">
                  <!-- <label for="inputState">State</label> -->
                  <div class="input-group date">  
                    <input type="text" class="form-control" id="endDate" placeholder="End Date" v-model="endDate">
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
                    <!-- altert type can be info/warning/danger -->
                    <strong>End Date </strong> must be greater (>) than
                    <strong> Start Date </strong> 
                  </show-alert>
          </div>         
         </form>
        </div>
      </div>
        <div class="report-area" v-show="showReportArea">          
          <div class="col">
            <div class="heading">
              <em> 
                {{ date.showStartDate }} <span> &nbsp; </span> to <span> &nbsp; </span> {{ date.showEndDate }}
              </em>  
            </div>
            <table class="table table-hover">
              <thead class="thead-light">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Date</th>
                  <th scope="col">Customer Name</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Item</th>
                  <th scope="col">Weight (kg)</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(booking, index) in searchInfo.bookings">
                  <th scope="row"> {{ index+1 }} </th>
                  <td> {{booking.date}} </td>
                  <td> {{booking.customer_name}} </td>
                  <td> {{booking.customer_phone}} </td>
                  <td> {{booking.items}} </td>
                  <td> {{booking.weight}} </td>                  
                </tr> 
                <tr>
                  <td></td>
                  <!-- <td></td>                  -->
                  <td>
                    <div class="text-center">
                      <strong>Total Customers:</strong>                      
                    </div>
                  </td>
                  <td><strong> {{searchInfo.total_customer}} </strong></td>
                  <td></td>
                  <td>
                    <div class="text-center">
                      <strong>Total Weight:</strong>
                    </div>
                  </td>
                  <td><strong> {{searchInfo.total_weight}} </strong></td>                  
                </tr>                
              </tbody>
           </table>
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
            response: '',            
            startDate: '', 
            endDate: '', 
            date: {
                start:'',
                end:'',
                showStartDate: '',
                showEndDate: '',
            },
            searchButton: '',
            searchInfo: '',
            showReportArea: false,
          }
        },
        mounted() {                   
          this.showStartDate();
          this.showEndDate();          
        },
        watch: { 
            startDate() {
                var a = moment(this.startDate, "DD-MM-YYYY");
                this.date.start = a.format('YYYY-MM-DD');
                this.date.showStartDate = moment(this.date.start, "YYYY-MM-DD").format("Do MMMM, YYYY");
                this.searchInfo = '';
                //console.log(moment(this.date.start, "YYYY-MM-DD").format("Do MMMM, YYYY"));                
            },
            endDate() {
                var a = moment(this.endDate, "DD-MM-YYYY");
                this.date.end = a.format('YYYY-MM-DD');
                this.date.showEndDate = moment(this.date.end, "YYYY-MM-DD").format("Do MMMM, YYYY");
                //console.log(moment(this.date.end, "YYYY-MM-DD").format("Do MMMM, YYYY")); 
                this.searchInfo = '';                
                this.showAlertToUser();
            }              
        },
         computed: {
            isValid() {                
                return this.startDate != '' && 
                        this.endDate != '' &&                       
                        //moment(this.date.end).isAfter(this.date.start)
                        moment(this.date.end).isSameOrAfter(this.date.start)
            },
        },       
        methods: {           
          showAlertToUser() {            
            //return this.showAlert = ( moment(this.endDate, "DD-MM-YYYY").isAfter(this.startDate, "DD-MM-YYYY") ) ? true : false;
            return this.showAlert = ( moment(this.date.end).isBefore(this.date.start) ) ? true : false;
          },
          search() {
            var vm = this;                                   
            axios.post('/search', {
                start_date: this.startDate,
                end_date: this.endDate,              
                
            })            
            .then(function (response) {                  
                 response.data.error ? vm.error = response.data.error : vm.searchInfo = response.data;
                 //console.log(vm.searchInfo);
                 //vm.loading = false;
                 vm.showReportArea = true;                  
            });
          },
	        showStartDate() {
	          var vm = this;            
	          $('#sandbox-container .input-group.date').datepicker({
	                        format: 'dd-mm-yyyy',                        
                          //startDate: '0d',
	                        endDate: '0d',
	                        todayHighlight: true,
	                        autoclose: true
	                    }).on("changeDate", () => {vm.startDate = $('#sandbox-container #startDate').val()});            
	        },      
            showEndDate() {
                var vm = this;            
                $('#sandbox-container .input-group.date').datepicker({
                              format: 'dd-mm-yyyy',                        
                              //startDate: '0d',
                              endDate: '0d',
                              todayHighlight: true,
                              autoclose: true
                          }).on("changeDate", () => {vm.endDate = $('#sandbox-container #endDate').val()});            
              },
      }   
    }
</script>

<style lang="scss" scoped>
  .report-area {    
    margin-top: 1.5rem;
  }
  td.text-center {
    text-align: center;
  }
</style>