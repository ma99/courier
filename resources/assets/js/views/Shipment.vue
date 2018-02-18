<template>
	<div>
		<section class="content-header">
      <h2>Shipment</h2> 
      <hr>     
    </section>

     <!-- Main content -->
    <section class="content">       
     <!-- Your Page Content Here -->   
    <!--  <p> Shipment Page </p>  -->
      <div class="row justify-content-center">
        <div class="col-8">          
         <form>
            <div class="form-group row">
              <label for="inputBookingRef" class="col-sm-3 col-form-label">Ref No</label>
              <div class="col-sm-6">              	
	              <select v-model="selectedBookingRef" class="form-control" id="cityName">
	                  <option disabled value="">Please select one</option>
	                  <option v-for="bookingRef in bookingRefList" v-bind:value="{ id: bookingRef.id, booking_ref: bookingRef.booking_ref }">
	                    {{ bookingRef.booking_ref }}
	                  </option> 
	              </select>
              </div>              
            </div>

            <div class="form-group row">
              <label for="startDate" class="col-sm-3 col-form-label">Select Date</label>
              <div class="col-sm-4">
              	<div id="sandbox-container">
	              	<!-- <div class="input-group mb-3"> -->
	              	<div class="input-group date">	
	                	<input type="text" class="form-control" id="startDate" placeholder="Select Date" v-model="startDate">
	                	<div class="input-group-append input-group-addon">
						    <span class="input-group-text">
						    	<!-- <i class="fa fa-calendar-check-o" aria-hidden="true"></i> -->
						    	<i class="fa fa-calendar" aria-hidden="true"></i>
						    </span>
						</div>
	                	<!-- <div class="input-group-append">
						    <span class="input-group-text" id="basic-addon2">Date</span>
						</div> -->
	              	</div>
              	</div>
              </div>
            </div>


            <div class="form-group row">
              <label for="totalWeight" class="col-sm-3 col-form-label">Total Weight</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="totalWeight" placeholder="Total weight" v-model="totalWeight">
              </div>
            </div>

            
            <div class="receiving-address">
              <div class="form-group row">
                <label for="receivingAddress" class="col-sm-3 col-form-label">Shipment (District)</label>                
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="divisionName">Division Name</label>
                      <select v-model="selectedDivision" class="form-control" id="divisionName">
                          <option disabled value="">Please select one</option>
                          <option v-for="division in divisionList" v-bind:value="{ id: division.id, name: division.name }">
                            {{ division.name }}
                          </option>                             
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="cityName">District Name </label>                       
                      <select v-model="selectedCity" class="form-control" id="cityName">
                          <option disabled value="">Please select one</option>                          
                          <option v-for="city in cityList" v-bind:value="{ id: city.id, name: city.name }">
                            {{ city.name }}
                          </option> 
                      </select>
                    </div>
                  </div>

                  <!-- <div class="col-sm-3">
                    <div class="form-group">
                      <label for="areaName">Area Name </label>
                      <input type="text" v-model="areaName" class="form-control" id="areaName">                        
                      </input>
                    </div>
                  </div> -->
              </div>              
            </div>
            
            <div class="form-group row">
              <div class="col-sm-4">
                <button type="submit" class="btn btn-primary" v-on:click.prevent="saveShipmentInfo()">Save</button>
              </div>
            </div>
         </form> 
        </div>
      </div>
    </section>


		
	</div>
</template>

<script>
    export default {
    	data() {
          return {           
            bookingRefList: [],
            cityList: [],
            divisionList: [],
            error: '',
            totalWeight: '',
            selectedBookingRef: '',            
            selectedCity: '',
            selectedDivision: '',
            startDate: '', 
          }
        },
        mounted() {          
          this.fetchBookingRef();
          this.fetchDivisions();
          this.showDate();
        },
        watch: {
            selectedDivision() {
                this.fetchCitiesByDivision(this.selectedDivision.id); // this.selectedDivisionId
            },            
        },
        methods: {
        	fetchBookingRef() {
        		//this.loading = true;
	            this.bookingRefList= [];            
	            var vm = this;                      
	            //axios.get('api/bus?q=' + busId) //--> admin/api/bus?q=xyz  (wrong)
	            axios.get('/api/booking')  //--> api/bus?q=xyz        (right)
	                .then(function (response) {                  
	                   response.data.error ? vm.error = response.data.error : vm.bookingRefList = response.data;
	                   //vm.loading = false;                  
	            });
        	},

        	fetchCitiesByDivision(divisionId) {
	            //this.loading = true;
	            //this.cityList= [];            
	            var vm = this;                      
	            //axios.get('api/bus?q=' + busId) //--> admin/api/bus?q=xyz  (wrong)
	            axios.get('/api/districts?q=' + divisionId)  //--> /api/bus?q=xyz        (right)
	                .then(function (response) {                  
	                   response.data.error ? vm.error = response.data.error : vm.cityList = response.data;
	                   //vm.loading = false;                  
	            });
          	}, 

          	fetchDivisions() {
	            //this.loading = true;
	            this.divisionList= [];            
	            var vm = this;                      
	            //axios.get('api/bus?q=' + busId) //--> admin/api/bus?q=xyz  (wrong)
	            axios.get('/api/divisions')  //--> api/bus?q=xyz        (right)
	                .then(function (response) {                  
	                   response.data.error ? vm.error = response.data.error : vm.divisionList = response.data;
	                   //vm.loading = false;                  
	            });
	        },
           saveShipmentInfo() {
            var vm = this;
            
            var receivingAddress = this.selectedCity.name + ', ' + 
                                   this.selectedDivision.name;

            axios.post('/shipment', {
                booking_id: this.selectedBookingRef.id,
                date: this.startDate,
                total_weight: this.totalWeight,              
                receiving_address: receivingAddress,
            })          
            .then(function (response) {
                //console.log(response.data);
                response.data.error ? vm.error = response.data.error : vm.response = response.data;
                // if (vm.response) {
                //    //console.log(vm.response);
                //    vm.fetchBusAvailableToCities();
                //    vm.SortByCityNameBusAvailableToCityList(vm.busAvailableToCityList);
                //    vm.loading = false;
                //    vm.disableSaveButton = true;
                //    vm.cityAddedAlert(vm.selectedCity.name);
                //    vm.reset();
                //    return;                   
                // }
                // vm.loading = false;
                //vm.disableSaveButton = true;
            });
          },

	        showDate() {
	          var vm = this;
	          $('#sandbox-container .input-group.date').datepicker({
	                        format: 'dd-mm-yyyy',                        
	                        startDate: '0d',
	                        todayHighlight: true,
	                        autoclose: true
	                    }).on("changeDate", () => {vm.startDate = $('#sandbox-container #startDate').val()});
	        },
        },
        
    }
</script>