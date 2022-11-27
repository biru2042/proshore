<template>
    <div class="container my-5">
        <div class="row justify-content-center">
            
            <div class="col-md-8">
                <div class="form-group my-3">
                    <select v-on:change="onChange($event)" class="form-control" >
                        <option value="">Sort Event</option>
                        <option value="finished">Finished Event</option>
                        <option value="upcomming">Upcomming Event</option>
                        <option value="upcomming_seven_days">Upcomming Event within 7 days</option>
                        <option value="finished_seven_days">Finished Event of 7 days</option>
                    </select>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(event, index) in events">
                        <th scope="row">{{ index+1 }}</th>
                        <td>{{ event.title }}</td>
                        <td>{{ event.description }}</td>
                        <td>{{ event.startDate }}</td>
                        <td>{{ event.endDate }}</td>
                        <td>
                            <button class="alert alert-sm alert-info" v-on:click="editEvent(event, index)">Edit</button>
                            <button class="alert alert-sm alert-danger mx-2" v-on:click="deleteEvent(event.id, index)">Delete</button>
                        </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div v-for="(errorArray, idx) in errorss" :key="idx">
                    <div v-for="(allErrors, idx) in errorArray" :key="idx">
                        <span class="text-danger">{{ allErrors}} </span>
                    </div>
                </div>

                <p class="errors" v-if="errors.length">
                    <ul>
                        <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </p>

                <form ref="submitEventData" action="" @submit.prevent="submitForm">
                    <input type="hidden" v-model="id">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" v-model="title" class="form-control" >
                        <p v-if="errors.length">
                            <p>{{ errors.title }}</p>
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="" v-model="description" id="" cols="10" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Start Date</label>
                        <input type="date" v-model="startDate" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="">End Date</label>
                        <input type="date" v-model="endDate" class="form-control" >
                    </div>
                    <button v-if="!isEdit" type="submit" class="btn btn-primary my-3">Save</button>
                    
                    <button v-else type="submit" class="btn btn-primary my-3" >Update</button>
                    
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {  
        name:'EventComponent',
        data(){
            return{
                id:'',
                title:'',
                description:'',
                startDate:'',
                endDate:'',
                events:[],
                errors: [],
                isEdit:false,
                errorss:''
            }
        },
        methods:{
            onChange(e){
                let val = e.target.value;
                axios.get('/backend/api/event?name='+val)
                .then((response) => {
                console.log(response.data.data.data)
                    this.events = response.data.data.data;
                })
            },
            getEvents(){
                axios.get('/backend/api/event')
                .then((response) => {
                console.log(response.data.data.data)
                    this.events = response.data.data.data;
                })
            },
            deleteEvent(id, index){
                
                if(confirm("Do you really want to delete?")){
                    
                    axios.delete('/backend/api/event/'+id)
                    .then(resp => {
                        this.getEvents()
                        console.log(resp)
                    })
                    .catch(error => {
                        console.log(error);
                    })
                }
            },

            editEvent(event, index){
                // alert(id)
                this.id = event.id;
                this.title = event.title;
                this.description = event.description;
                this.startDate = event.startDate;
                this.endDate = event.endDate;
                this.isEdit = true
                console.log(this.title)
            },

            submitForm(e){
                
                
                if (this.title && this.description && this.startDate && this.endDate) {
                    this.errors = [];
                    if(!this.id){
                    axios.post('/backend/api/event', {
                        title:this.title,
                        description:this.description,
                        startDate:this.startDate,
                        endDate:this.endDate
                    })
                    .then(response => {
                        console.log(response.data)
                        this.title = '';
                        this.description = '';
                        this.startDate = '';
                        this.endDate = '';

                        this.getEvents()
                    })
                    .catch(error => {
                        let errorMsg = error.response.data.data;
                        this.errorss = errorMsg
                        // console.log(errorMsg);

                        for(let i=0; i<=errorMsg; i++ ){
                            console.log(errorMsg[i])
                            this.errors.push(errorMsg[i]);
                        }
                    })
                }else{
                    let id = this.id;
                    
                    axios.put("/backend/api/event/"+id, {
                        title:this.title,
                        description:this.description,
                        startDate:this.startDate,
                        endDate:this.endDate,
                        // _method:'put'
                    })
                    .then(response => {
                        console.log(response.data)
                        this.title = '';
                        this.description = '';
                        this.startDate = '';
                        this.endDate = '';
                        this.isEdit = false;
                        
                        this.getEvents()
                    })
                    .catch(error => {
                        let errorMsg = error.response.data.data;
                        console.log(errorMsg.length);

                        for(let i=0; i<=errorMsg.length; i++ ){
                            console.log(errorMsg[i])
                            this.errors.push(errorMsg[i]);
                        }
                    })
                }
                    return true;
                }
                this.validateData();                
            },
            validateData(){
                this.errors = [];

                if (!this.title) {
                    this.errors.push('Title field is required.');
                }
                if (!this.description) {
                    this.errors.push('Description field is required.');
                }
                if (!this.startDate) {
                    this.errors.push('Start date field is required.');
                }
                if (!this.endDate) {
                    this.errors.push('End date field is required.');
                }

            }
        },
        created(){
            this.getEvents()
        }
    }
</script>
<style scoped>
button{
    padding:5px;
}
.errors li{
    color: red;
}
</style>
