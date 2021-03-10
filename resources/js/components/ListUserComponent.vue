<template>
  <div>
      <p>
  <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">User List</a>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Petugas</button>
</p>
<div class="row table-responsive">
  <div class="container d-block">
    <div class="collapse multi-collapse" id="multiCollapseExample1">
        <h3>User</h3>
        <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama</th>
      <th scope="col">Nik</th>
      <th scope="col">Username</th>
      <th scope="col">Status</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(user,index) in users.data" :key="user.nik">
      <th scope="row">{{ index+1 }}</th>
      <td>{{ user.nama }}</td>
      <td>{{ user.nik }}</td>
      <td>{{ user.username }}</td>
      <td>{{ user.status_user }}</td>
      <td><button @click="verif(user.nik)" class="btn btn-success btn-sm">Verif!</button></td>
    </tr>
  </tbody>
</table>

    </div>
  </div>
</div>
  <div class="row table-responsive">
  <div class="container mt-2">
    <div class="collapse multi-collapse" id="multiCollapseExample2">
      <p><h3>Petugas</h3><button class="btn btn-primary">+ Petugas</button></p>
              <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama</th>
      <th scope="col">Id Petugas</th>
      <th scope="col">Username</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(petuga,index) in petugas.data" :key="petugas.id_petugas"> 
      <th scope="row">{{ index+1}}</th>
      <td>{{ petuga.nama_petugas }}</td>
      <td>{{ petuga.id_petugas }}</td>
      <td>{{ petuga.username }}</td>
      <td>
          <button @click="show(petuga)" class="btn btn-success m-1 btn-sm">Show</button>
          <button class="btn btn-danger m-1 btn-sm">Delete</button>
      </td>
    </tr>
  </tbody>
</table>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalpetugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Petugas </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label>ID Petugas</label>
        <input v-model="p.id_petugas" class="form-control" type="text">
        <label>Nama</label>
        <input class="form-control" type="text">
        <label>Username</label>
        <input class="form-control" type="text">
        <label>Password</label>
        <input class="form-control" type="password">
        <label>Telp</label>
        <input class="form-control" type="text">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!--- Modal end -->
  </div>
</template>

<script>
export default {
    data(){
        return {
            users: [],
            petugas: [],
            petugas_ini: []
        }
    },
    mounted(){
        this.getUser()
        this.getPetugas()
    },
    methods: {
        show(p) {
            this.petugas_ini = p
            $('#modalpetugas').modal()
        },
        verif(nik){
            axios.post('/api/petugas/user/verif',{
                nik: nik
            }).then(response => {
                this.getUser()
            })
        },
           getPetugas(){
            axios.get('/api/petugas/petugas/get')
                .then(response => {
                    console.log(response.data)
                    this.petugas = response.data
                })
        },
        getUser(){
            axios.get('/api/petugas/user/get')
                .then(response => {
                    console.log(response.data)
                    this.users = response.data
                })
        }
    }

}
</script>

<style>

</style>