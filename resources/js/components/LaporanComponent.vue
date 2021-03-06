<template>
  <div class="row">
       <div class="col-md-3">
      <div class="card mt-2">
        <div class="card-body text-center">
          <button @click="buat()" class="btn btn-md btn-primary m-1">
            Export PDF
          </button>
        <button @click="buat()" class="btn btn-md btn-primary m-1">
            Export Excel
          </button>
        </div>
      </div>
    </div>
    <div class="col-md-9">
        <div class="mb-2"></div>
        <div >
              <button @click="copy()" class="btn btn-sm btn-primary d-inline-block">Copy</button>
<download-excel :data="pengaduans.data" class="d-inline-block">
  <button class="btn btn-sm btn-primary d-inline-block">Excel</button>
</download-excel>
  <button @click="pdf()" class="btn btn-sm btn-primary d-inline-block">PDF</button>
  <button @click="print()" class="btn btn-sm btn-primary d-inline-block">Print</button>
</div>
        <div id="render_me" class="table-responsive mt-2">
        <table id="renderme"  class="table table-hover">
          <thead class="table-secondary">
            <tr>
              <th>No</th>
            <th>Pelapor</th>
              <th>TGL Pengaduan</th>
              <th>Isi Laporan</th>
              <th>Foto</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(pengaduan, index) in pengaduans.data"
              :key="pengaduan.id_pengaduan"
            >
            <td>{{index + 1}}</td>
             <td>{{ pengaduan.nama }}</td>
          <td>{{ pengaduan.tgl_pengaduan }}</td>
           <td v-if="pengaduan.isi_laporan.length > 20">
                {{ pengaduan.isi_laporan.substring(0, 20) + "...." }}
              </td>
              <td v-else>{{ pengaduan.isi_laporan }}</td>
              <td>
                <img
                    id="img"
                  :src="getImg(pengaduan.foto)"
                  v-bind:alt="pengaduan.foto"
                  style="max-width: 100px; max-height: 100px"
                />
              </td>
              <td v-if="pengaduan.status == '0'">Belum</td>
              <td v-else>
                {{
                  pengaduan.status.charAt(0).toUpperCase() +
                  pengaduan.status.substring(1)
                }}
              </td>
              <td>
                <button
                    @click="show(pengaduan)"
                  class="btn btn-success m-1 btn-sm"
                >
                  Show
                </button>
                <button
                @click="apus(pengaduan,index)"
                :disabled="pengaduan.id_tanggapan == null"
                  class="btn btn-danger m-1 btn-sm"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
        <!-- Modal Show -->
    <div
      class="modal fade"
      id="modalshow"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Pengaduan {{ pengaduan_ini.tgl_pengaduan }}
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div v-if="erro != 0"  v-for="(error, index) in erro" v-bind:key="erro" class="m-3 alert alert-primary" role="alert">
            {{ error }}
            </div>
          <div class="modal-body">
            <form>
              <div class="form-group-row">
                <label>Isi Laporan:</label>
              </div>
              <div class="form-group-row">
                {{ pengaduan_ini.isi_laporan }}
              </div>
              <br />
              <div class="form-group-row">
                <label>Foto</label>
              </div>
              <div class="form-group-row">
                <img
                  v-if="preview_img != 0"
                  :src="preview_img"
                  style="max-width: 100px; max-height: 100px"
                />
                <img
                  v-else
                  :src="pengaduan_ini.foto"
                  style="max-width: 100px; max-height: 100px"
                />
              </div>
              <br />
              <div class="form-group-row">
                <label>Status: </label>
        <select v-model="pengaduan_ini.status" name="stat" class="form-control selectpicker mb-2" aria-label="Default select example">
        <option value="0">Belum</option>
        <option value="proses">Proses</option>
        <option value="selesai">Selesai</option>
        </select>
              </div>
              <div class="form-group-row">
                <label >Tanggapan: </label>
               <textarea class="form-control" v-model="pengaduan_ini.tanggapan"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button
              @click="updatepengaduan()"
              type="button"
              class="btn btn-primary"
            >
              Save Changes
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Show -->
  </div>
</template>

<script>
import jsPDF from 'jspdf'
import 'jspdf-autotable';


export default {
    components: {
      
    },
    data(){
        return {
            pengaduans: [],
            pengaduan_ini: [],
            preview_img: {},
            erro: []
        }
    },
    mounted(){
        this.get_pengaduan()
    },
    methods: {
    updatepengaduan(){
        this.$swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: `Save`,
        denyButtonText: `Don't save`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            let data = new FormData()
            data.append('id_pengaduan', this.pengaduan_ini.id_pengaduan)
            data.append('status', this.pengaduan_ini.status)
            data.append('tanggapan', this.pengaduan_ini.tanggapan)
            data.append('id_tanggapan', this.pengaduan_ini.id_tanggapan)
            axios.post('/api/petugas/tanggapan/create',data)
            .then(response => {
                this.get_pengaduan()
                this.erro = []
            })
            .catch(error => {
                this.erro = error.response.data.errors.tanggapan
                console.log("ERRRR:: ",error.response.data.errors);
            });
             $("#modalshow").modal('hide');
            this.$swal.fire('Saved!', '', 'success')
        } else if (result.isDenied) {
            this.$swal.fire('Changes are not saved', '', 'info')
        }
        })

    },
    apus(pengaduan,index){
             this.$swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: `Save`,
        denyButtonText: `Don't save`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
             let data = new FormData()
            data.append('id_pengaduan',pengaduan.id_pengaduan)
            data.append('id_tanggapan',pengaduan.id_tanggapan)
            axios.post('/api/petugas/tanggapan/delete',data)
            .then(response => {
                this.get_pengaduan()
            })
            this.$swal.fire('Saved!', '', 'success')
        } else if (result.isDenied) {
            this.$swal.fire('Changes are not saved', '', 'info')
        }
        })
    },
    show: function (pengaduan) {
        this.pengaduan_ini = []
      this.preview_img = [];
       $('select[name=stat]').val(pengaduan.status);
      $("#modalshow").modal();
      this.pengaduan_ini = pengaduan;
      this.get_pengaduan();
    },
        copy(){
              var dummy = document.createElement("input");
    //dummy.style.display = 'none';
    document.body.appendChild(dummy);
 
    dummy.setAttribute("id", "dummy_id");
    let str = JSON.stringify(this.pengaduans.data);
    //console.log(str.replace(/\[|]|}|{|"/g,''));
   // console.log(str)
    document.getElementById("dummy_id").value=str.replace(/\[|]|}|{|"/g,'')
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
        },
        pdf(){
       //window.print()
      // document.getElementById("#renderme").print()
        var doc = new jsPDF();

         var img = document.getElementById('img');
        //  doc.addImage(img.src);

       var col = ["No","Id Pengaduan","Pelapor","NIK","Isi Laporan","Foto","Status","TGL Lapor"];
       var col1 = ["No","Id Pengaduan", "Tanggapan", "Nama Petugas", "TGL Tanggapan"];
       var rows = [];
       var rows1 = [];

        let ittem = this.pengaduans.data
        let i = 1;
        let ii = 1;

        ittem.forEach(e => {      
        var temp = [i++,e.id_pengaduan,e.nama,e.nik,e.isi_laporan,e.foto,e.status,e.tgl_pengaduan];
        var temp1 = [ii++,e.id_pengaduan,e.tanggapan,e.nama_petugas,e.tgl_tanggapan];
        rows.push(temp);
        rows1.push(temp1);

        });        
        doc.autoTable(col, rows, { startY: 10 });
        doc.autoTable(col1, rows1, { startY: 60 });
        //doc.autoPrint();
        //doc.output('dataurlnewwindow');
        doc.save('Test.pdf');
        },
         print(){
       //window.print()
      // document.getElementById("#renderme").print()
        var doc = new jsPDF();
       var col = ["No","Id Pengaduan","Pelapor","NIK","Isi Laporan","Foto","Status","TGL Lapor"];
       var col1 = ["No","Id Pengaduan", "Tanggapan", "Nama Petugas", "TGL Tanggapan"];
       var rows = [];
       var rows1 = [];

        let ittem = this.pengaduans.data
        let i = 1;
        let ii = 1;

        ittem.forEach(e => {      
        var temp = [i++,e.id_pengaduan,e.nama,e.nik,e.isi_laporan,e.foto,e.status,e.tgl_pengaduan];
        var temp1 = [ii++,e.id_pengaduan,e.tanggapan,e.nama_petugas,e.tgl_tanggapan];
        rows.push(temp);
        rows1.push(temp1);

        });        
        doc.autoTable(col, rows, { startY: 10 });
        doc.autoTable(col1, rows1, { startY: 60 });
        doc.autoPrint();
        doc.output('dataurlnewwindow');
    //    doc.save('Test.pdf');
        },
        get_pengaduan(){
            axios.get('/api/petugas/pengaduan/get')
                .then(response => {
                    console.log(response.data)
                    this.pengaduans = response.data
                })
        },
        getImg(foto){
            return foto;
        }
    }
}
</script>

<style>

</style>