<template>
  <div>    
     <section class="content-header">
      <h3>Add/Remove Item</h3> 
      <hr>        
    </section>

    <section class="content">      
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card border-success">
              <div class="card-header text-white bg-light">
                <!-- Add New City -->
                <span class="btn-group" role="group">
                    <button class="btn btn-success" type="button" @click="expandAddItemPanel" v-show="!show">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-warning" type="button" @click="expandAddItemPanel" v-show="show">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                </span>
              </div>
              <div class="card-body" v-show="show">
                <form>
                    <div class="col-sm-10">
                      <div class="form-group">
                        <label for="itemName">Item Name</label>
                        <input v-model="itemName" type="text" class="form-control" name="code" id="itemName">
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="button-group">
                        <button v-on:click.prevent="saveItems()" class="btn btn-primary" :disabled="disableSaveButton">Save</button>                        
                      </div>
                    </div>                      
                </form>
              </div>
          </div>
        </div>  
      </div>
      
      <loader :show="loading"></loader>

      <div class="row justify-content-center item-list">
        <div class="col-md-10">
          <div class="card border-info">
            <div class="card-header text-white bg-info">
              Available Items 
              <span class="item-total"> Total: {{ pagination.total }} </span>
            </div>
            <div class="card-body">
                <!-- <div id="scroll-items"> -->
                  <table class="table table-striped table-hover">
                      <!-- <thead class="thead-light"> -->
                      <thead>
                        <tr class="table-primary">
                          <th scope="col">Sl. No.</th>
                          <th scope="col">Name
                               <!-- <span type="button" @click="isSortingAvailableBy('name')" :disabled="disableSorting">
                                  <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                              </span> -->
                          </th>                        
                          <th scope="col">Action</th>                             
                          <!-- <th>&nbsp;</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(item, index) in availableItemList">                              
                          <!-- <td>{{ index+1 }}</td>  -->                                           
                          <td>{{ slNo + index }}</td>                              
                          <td>{{ item.name }}</td>                                                      
                          <td> 
                              <button v-on:click.prevent="removeItem(item)" class="btn btn-danger">
                                <i class="fa fa-trash fa-fw"></i>Remove
                              </button>  
                          </td>                        
                        </tr>                            
                      </tbody>
                  </table>      
               <!--  </div> --> 
               <!-- <nav aria-label="Page navigation example">
                   <ul class="pagination justify-content-center">
                        <li class="page-item">
                        <button class="btn btn-default" @click="fetchAvailableItems(pagination.prev_page_url)"
                                :disabled="!pagination.prev_page_url">
                            Previous
                        </button>
                        </li>
                        <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span>
                        <button class="btn btn-default" @click="fetchAvailableItems(pagination.next_page_url)"
                                :disabled="!pagination.next_page_url">Next
                        </button>
                    </ul>
               </nav> -->
               <ul class="pagination justify-content-center">
                  <li class="page-item" v-if="pagination.current_page > 1">
                      <a class="page-link" href="javascript:void(0)" aria-label="Previous" v-on:click.prevent="changePage(pagination.current_page - 1)">
                          <span aria-hidden="true">«</span>
                          </a>
                      </li>
                  <li class="page-item" v-for="page in pagesNumber" :class="{'active': page == pagination.current_page}">
                      <a class="page-link" href="javascript:void(0)" v-on:click.prevent="changePage(page)">{{ page }}</a>
                      </li>
                  <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                      <a class="page-link" href="javascript:void(0)" aria-label="Next" v-on:click.prevent="changePage(pagination.current_page + 1)">
                          <span aria-hidden="true">»</span>
                          </a>
                      </li>
              </ul>
            </div>
            <!-- {{-- card-footer --}} -->
            <div class="card-footer">                    
              <!-- <show-alert :show="showAlert" :type="alertType" @cancel="showAlert=false">  -->
              <show-alert :show.sync="showAlert" :type="alertType"> 
                <!-- altert type can be info/warning/danger -->
                <!-- <strong>{{ itemName }} </strong> has been  -->
                <strong>{{ itemNameForAction }} </strong> has been 
                <strong> {{ actionStatus }} </strong> successfully!
              </show-alert>
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
            actionStatus: '',
            alertType: '',
            itemList: [],
            itemName: '',
            itemNameForAction: '',
            availableItemList: [], //bus service availble to the cities
            //divisionList: [],
            disableSaveButton: true,
            disableResetButton: true,
            //disableSorting: true,
            error: '',
            loading: false,
            // offset:{
            //   type: Number,
            //   default: 4
            // },
            offset: 4,
            pagination: {
              current_page: '',
              last_page: '',
              next_page_url: '',
              prev_page_url: '',
              path: '',
              total: '',
              to: '',
              from: '',
            },
            response: '',
            //selectedCityId: '',
            //selectedCity: '',
            //selectedDivisionId: '',
            //selectedDivision: '',
            show: false,
            showAlert: false,
            slNo: 1,  
          }
        },
        mounted() {           
           //this.fetchDivisions();
           this.fetchAvailableItems();           
           //this.enableSlimScroll();
        },
        watch: {
            // selectedDivision() {
            //     this.fetchCitiesByDivision(this.selectedDivision.id); // this.selectedDivisionId
            // },
            // itemList() {                
            //     this.disableSaveButton = (this.itemList.length < 1) ? true : false; 
            // },
            itemName() {
              this.disableSaveButton = (this.itemName == '') ? true : false; 
            } 
        },
        computed: {
          // slNumber(idx) {
          //   return this.slNo + idx;
          // },
          pagesNumber() {
            if (!this.pagination.to) {
              return [];
            }
            let from = this.pagination.current_page - this.offset;
            if (from < 1) {
              from = 1;
            }
            let to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
              to = this.pagination.last_page;
            }
            let pagesArray = [];
            for (let page = from; page <= to; page++) {
              pagesArray.push(page);
            }
              return pagesArray;
          }
        },
        methods: {
          slNumber(pageNumber) {
            //case*5 - offset
            this.slNo = pageNumber*5- this.offset;            
          },
          changePage(page) {
            this.pagination.current_page = page;
            //this.$emit('paginate');            
            //let pageUrl = `/user/api?page=${this.pagination.current_page}`;
            let pageUrl = `${this.pagination.path}?page=${this.pagination.current_page}`;
            this.fetchAvailableItems(pageUrl);
            this.slNumber(page)
          },
          enableSlimScroll() {
                $('#scroll-items').slimScroll({
                  color: '#00f',
                  size: '8px',
                  height: '500px', //300px
                  //height: auto,
                  wheelStep: 10                  
                });
          },
          expandAddItemPanel() {
            this.show = !this.show;
          },
         
          fetchAvailableItems(page_url) {
            this.loading = true;
            //this.availableItemList= [];            
            var vm = this;
            page_url  = page_url || '/api/items';              
            axios.get(page_url)  //--> api/bus?q=xyz        (right)
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.availableItemList = response.data.data;
                   vm.makePagination(response.data);
                  //vm.availableItemsSortByItemName(vm.busAvailableToCityList); 
                   vm.availableItemsSortByItemName(vm.availableItemList);                 
                   vm.loading = false;
            });
          },
          makePagination(data){
                // this.current_page= data.current_page;
                // this.last_page= data.last_page;
                // this.next_page_url= data.next_page_url;
                // this.prev_page_url= data.prev_page_ur;
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url,
                    path: data.path,
                    total: data.total,
                    to: data.to,
                    from: data.from
                }
                //this.$set('pagination', pagination);
                this.pagination = pagination;
          },
          /*isSortingAvailableBy(val) {
            if (val== 'name') {
                this.availableItemsSortByItemName(this.busAvailableToCityList);
                this.disableSorting = true;
                return;
            }
            this.SortByDivisionBusAvailableToCityList(this.busAvailableToCityList);
            this.disableSorting = false;
          },*/

          removeItem(item) {  // role id of user/staff in roles table
            var vm = this;
            //this.itemName = item.name; 
            this.itemNameForAction = item.name; 
            swal({
              title: "Are you sure?",
              text: "This item will be Removed!",
              icon: "error",                 
              dangerMode: true,
              buttons: {
                  cancel: "cancel",
                  confirm: {
                    text: "Remove It!",
                    value: true,
                  },                                
              },
            })
            .then((value) => {
              if (value) {

                vm.loading = true;
                vm.response = '';
                vm.showAlert = false;
                axios.post('/delete', {                            
                    item_id: item.id, 
                })          
                .then(function (response) {                                           
                    // response.data.error ? vm.error = response.data.error : vm.busAvailableToCityList = response.data;
                    response.data.error ? vm.error = response.data.error : vm.response = response.data;

                    if (vm.response) {                                
                        vm.removeItemFromAvailableItemList(item.id); // update the array after removing
                        vm.updatePaginationTotal(vm.pagination.total);
                        vm.loading = false;
                        vm.actionStatus = 'Removed';
                        vm.alertType = 'danger';
                        vm.showAlert= true;
                        return;                                                      
                    }                            
                    vm.loading = false;

                });       
                
              } 
              
            }); 
          },
         
          removeItemFromAvailableItemList(itemId) {
            var indx = this.availableItemList.findIndex(function(item){ 
                // here 'city' is array object 
                 return item.id == itemId;
            });        
            this.availableItemList.splice(indx, 1);            
            //return;
          },
          updatePaginationTotal(total) {
            this.pagination.total = total - 1;
          },
          saveItems() {
            var vm = this;
            //this.loading = true;
            // console.log('itemId',this.selectedCity.id);
            // console.log('itemName',this.selectedCity.name);
            axios.post('/items', {
                //item_id: this.item.id,
                item_name: this.itemName,               

            })          
            .then(function (response) {
                //console.log(response.data);
                response.data.error ? vm.error = response.data.error : vm.response = response.data;
                if (vm.response) {
                   //console.log(vm.response);
                   vm.fetchAvailableItems();
                   vm.availableItemsSortByItemName(vm.availableItemList);
                   vm.loading = false;
                   vm.disableSaveButton = true;
                   vm.itemAddedAlert(vm.itemName);
                   vm.reset();
                   return;                   
                }
                vm.loading = false;
                vm.disableSaveButton = true;
            });
          },
          availableItemsSortByItemName(arr) {
            // sort by name            
                arr.sort(function(a, b) {
                  var nameA = a.name.toUpperCase(); // ignore upper and lowercase
                  var nameB = b.name.toUpperCase(); // ignore upper and lowercase
                  if (nameA < nameB) {
                    return -1;
                  }
                  if (nameA > nameB) {
                    return 1;
                  }

                  // names must be equal
                  return 0;
                });
          },
          reset() {
            this.itemName = '';
          },         
          itemAddedAlert(itemName) {
              swal({
                //title: "Sorry! Not Available",
                //title: '<span style="color:#A5DC86"> <strong>'+itemName+'</strong></span></br> Added successfully!',
                title: itemName,
                text: 'Added successfully!', 
                //text: '<span style="color:#F8BB86"> <strong>'+val+'</strong></span> Not Available.',
                //html: true,
                //type: "info",
                icon: "success",
                timer: 2000,
                closeOnClickOutside: false,
              });
          }
        }
    }
</script>

<style lang="scss" scoped>
    .item-list {
      margin-top: 2.5rem;
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
    span.item-total {
      float: right;
    }

</style>