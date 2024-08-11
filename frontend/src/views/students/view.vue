<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Students</h4>
                <RouterLink to="/students/create" class="btn btn-primary float-end">
                    Add Student
                </RouterLink>
                <button @click="deleteMultiple()" class="btn btn-danger">Delete multiple</button>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Select</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody v-if="this.students.length > 0">
                            <tr v-for="(student, index) in this.students" :key="index">

                                <td>{{ student.id }}</td>
                                <td><input type="checkbox" class="multicheck" @click="selectMultipleStudents"
                                        :data-id="student.id" /> </td>
                                <td>{{ student.name }}</td>
                                <td>{{ student.age }}</td>
                                <td>{{ student.gender }}</td>
                                <td>{{ student.created_at || 'N/A' }}</td>
                                <td>
                                    <RouterLink :to="{ path: `/students/${student.id}/edit` }" class="btn btn-success">
                                        Edit
                                    </RouterLink>
                                    <button class="btn btn-danger float-end"
                                        @click="deleteStudent(`${student.id}`)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="6">
                                    <div class="spinner-border text-success text-center mx-auto" role="status">
                                        <span class="visually-hidden text-center">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    name: 'students',
    data() {
        return {
            checkedMultiple: [],
            students: []
        }
    },
    mounted() {
        this.getStudents();
    },
    methods: {
        getStudents() {
            axios.get('http://127.0.0.1:8000/api/students').then(res => {
                this.students = res.data.students
                //console.log(this.students);
            });
        },
        deleteStudent(studentId) {
            axios.delete(`http://127.0.0.1:8000/api/students/${studentId}`).then(res => {
                alert(res.data.message);
                this.getStudents();
            });
        },
        selectMultipleStudents() {
            this.checkedMultiple = [];
            let el = document.getElementsByClassName('multicheck');
            for (var i = 0, l = el.length; i < l; ++i) {
                if (el[i].checked) {
                    this.checkedMultiple.push(el[i].getAttribute('data-id'))
                }
            }
            console.log(this.checkedMultiple);
        },
        deleteMultiple() {
            axios.post('http://127.0.0.1:8000/api/students/deleteMultiple', { mcb: this.checkedMultiple }).then(res => {
                alert(res.data.message);
                if (res.data.status == 200) {
                    this.getStudents();
                    const clist = document.getElementsByClassName("multicheck");
                    for (var i = 0; i < clist.length; ++i) { clist[i].checked = false; }
                }
            });
        }
    }
}
</script>