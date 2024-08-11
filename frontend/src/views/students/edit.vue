<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Edit Student</h4>
            </div>
            <div class="card-body">
                <ul class="alert alert-warning" v-if="Object.keys(this.errorList).length > 0">
                    <li class="mb-0 ms-3" v-for="(error, index) in this.errorList" :key="index">{{ error[0] }}</li>
                </ul>
                <div class="mb-3">
                    <label for="">Name</label>
                    <input type="text" v-model="model.student.name" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Age</label>
                    <input type="text" v-model="model.student.age" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Gender</label>
                    <input type="text" v-model="model.student.gender" class="form-control" />
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" @click="updateStudent(this.studentId)">save</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    name: 'studentCreate',
    data() {
        return {
            errorList: {},
            model: {
                student: {
                    name: '',
                    gender: '',
                    age: ''
                }
            }
        }
    },
    mounted() {
        this.studentId = this.$route.params.id;
        this.getStudent(this.studentId);
    },
    methods: {
        getStudent(studentId) {
            axios.get(`http://127.0.0.1:8000/api/students/${studentId}`)
                .then(res => {
                    if(res.data.status==400){
                        alert(res.data.message);
                    }else{
                        this.model.student = res.data.student;
                    }
                })
        },
        updateStudent(studentId) {
            let $this = this;
            axios.patch(`http://127.0.0.1:8000/api/students/${studentId}`, this.model.student)
                .then(res => {
                    console.log(res.data.message);
                    if(res.data.status==400){
                    }else{
                        $this.errorList='';
                        alert(res.data.message);
                        this.$router.push({ path: '/students' });
                    }
                    
                })
                .catch(function (error) {
                    if(error){
                        console.log(error);
                        if (error.response.status === 422) {
                            $this.errorList = error.response.data.errors;
                        }else if(error.response.status === 400){
                            alert(res.data.message);
                        }
                    }
                })
        }
    }
}
</script>