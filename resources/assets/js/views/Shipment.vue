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
            <div v-show="showSaveButton">                
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
                  <label for="startDate" class="col-sm-3 col-form-label">Shipment Date</label>
                  <div class="col-sm-4">
                  	<div id="sandbox-container">
    	              	<!-- <div class="input-group mb-3"> -->
    	              	<div class="input-group date">	
    	                	<input type="text" class="form-control" id="startDate" placeholder="Shipment Date" v-model="startDate">
    	                	<div class="input-group-append input-group-addon">
            						    <span class="input-group-text">
            						    	<!-- <i class="fa fa-calendar-check-o" aria-hidden="true"></i> -->
            						    	<i class="fa fa-calendar" aria-hidden="true"></i>
            						    </span>
            						</div>    	                
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
                          <label for="divisionName">Division</label>
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
                          <label for="cityName">District </label>                       
                          <select v-model="selectedCity" class="form-control" id="cityName">
                              <option disabled value="">Please select one</option>                          
                              <option v-for="city in cityList" v-bind:value="{ id: city.id, name: city.name }">
                                {{ city.name }}
                              </option> 
                          </select>
                        </div>
                      </div>
                  </div>              
                </div>
            </div>

            <!-- <div id="divToPrint" style="display:none;" v-show="showPrintButton">           -->
            <div id="divToPrint" v-show="showPrintButton">          
              <div class="ref-no">
                  <p><strong>Ref: <em>{{ response.booking_ref}}</em></strong></p>
              </div>
              <div class="print-area">                
                  <p> <span> Receiver Name:</span> <strong>{{ response.receiver_name}}</strong></p>
                  <p> <span> Mobile No.:</span><strong>{{ response.receiver_phone}}</strong></p>
                  <p> <span> Address:</span><strong>{{ response.receiver_address}}</strong></p>
                  <p> <span> Gross Weight: </span><strong>{{ response.total_weight}} KGs</strong></p>
              </div>
            </div>
            
            <div class="my-buttons">              
              <div class="form-group row">
                  <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                      <button v-show="showSaveButton" type="button" class="btn btn-primary btn-lg" v-on:click.prevent="saveShipmentInfo()" :disabled="!isValid">Save</button>
                      
                    </div>
                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                      <button v-show="showPrintButton" type="button" class="btn btn-info btn-lg" v-on:click="printDiv('divToPrint')">Print</button>
                    </div>
                    <div class="btn-group" role="group" aria-label="Third group">
                      <button v-show="showPrintButton" type="button" class="btn btn-success btn-lg" v-on:click="addNew()">Add New</button>
                    </div>
                  </div>
               
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
            response: '',
            selectedBookingRef: '',            
            selectedCity: '',
            selectedDivision: '',
            startDate: '', 
            showAddNewButton: false,
            showPrintButton: false,
            showSaveButton: true,
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
        computed: {
            isValid() {              
                return this.selectedBookingRef != '' && 
                        this.startDate != '' &&
                        this.totalWeight != '' &&
                        this.selectedCity != '' && 
                        this.selectedDivision != ''
            },
        },
        methods: {

            addNew() {
                this.fetchBookingRef();
                this.selectedBookingRef= '' ; 
                this.startDate = '' ;
                this.totalWeight = '' ;
                this.selectedCity = '' ; 
                this.selectedDivision = '';

                this.showSaveButton = true;
                this.showPrintButton = false;
            },            
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

            printDiv(id) {
                var data=document.getElementById(id).innerHTML;
                var myWindow = window.open('', 'print-document', 'height=400,width=600');
                myWindow.document.write('<html><head><title>print document</title>');
                /*optional stylesheet*/ 
                //myWindow.document.write('<link rel="stylesheet" href="css/main.css" type="text/css" />');
                // Make sure the relative URL to the stylesheet works:
              // var tst = '<base href="' + location.origin + location.pathname + '">';
              // console.log('path=', tst);
              //  myWindow.document.write('<base href="' + location.origin + location.pathname + '">');
              
    // Add the stylesheet link and inline styles to the new document:
               myWindow.document.write('<link rel="stylesheet" href="css/main.css">');
    //printWindow.document.write('<style type="text/css">.style1{width: 100%;}</style>');
                myWindow.document.write('</head><body >');
                myWindow.document.write(data);
                myWindow.document.write('</body></html>');
                myWindow.document.close(); // necessary for IE >= 10

                myWindow.onload=function(){ // necessary if the div contain images

                    myWindow.focus(); // necessary for IE >= 10
                    myWindow.print();
                    myWindow.close();
                };
            },            
            // PrintDiv() {    
            //    var divToPrint = document.getElementById('divToPrint');
            //    //var popupWin = window.open('', '_blank', 'width=300,height=300');
            //    var popupWin = window.open('', '_blank');
            //    popupWin.document.open();
            //    popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            //    popupWin.document.close(); 
            // },
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
                console.log(vm.response);
                vm.showSaveButton = false;
                //vm.showAddNewButton = true;
                vm.showPrintButton = true;
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

<style lang="scss" scoped>
  div.ref-no {
    //color: red;
    font-size: 12px;
    //margin-top: 90px;
    margin-left: 90px;
  }
  div.print-area {
    margin-top: 20px;
    margin-left: 100px;    
    
    p {
      font-size: 17x;
      //font-weight: 700;
      span {
        border-bottom: 1px solid;
        margin-right: 10px;
      }
    }
  }
  .my-buttons {
    margin-left: 100px;
    margin-top: 50px;
  }
</style>