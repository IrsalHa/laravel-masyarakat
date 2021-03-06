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
              v-bind="pengaduans.data.id_pengaduan"
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
                
                  class="btn btn-success m-1 btn-sm"
                >
                  Show
                </button>
                <button
             
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
        }
    },
    mounted(){
        this.get_pengaduan()
    },
    methods: {
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

       var col = ["No","Pelapor","NIK","Isi Laporan","Foto","Status","TGL Lapor"];
       var col1 = ["No","Id Pengaduan", "Tanggapan", "Nama Petugas", "TGL Tanggapan"];
       var rows = [];
       var rows1 = [];

        let ittem = this.pengaduans.data
        let i = 1;
        let ii = 1;

        ittem.forEach(e => {      
        var temp = [i++,e.nama,e.nik,e.isi_laporan,e.foto,e.status,e.tgl_pengaduan];
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
       var col = ["No","Pelapor","NIK","Isi Laporan","Foto","Status","TGL Lapor"];
       var col1 = ["No","Id Pengaduan", "Tanggapan", "Nama Petugas", "TGL Tanggapan"];
       var rows = [];
       var rows1 = [];

        let ittem = this.pengaduans.data
        let i = 1;
        let ii = 1;

        ittem.forEach(e => {      
        var temp = [i++,e.nama,e.nik,e.isi_laporan,e.foto,e.status,e.tgl_pengaduan];
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