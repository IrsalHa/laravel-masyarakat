<template>
  <div class="row">
    <div class="col-md-12">
         <button @click="buat()" class="btn btn-md btn-primary m-1">
            Buat Pengaduan
          </button>
      <div class="table-responsive mt-2">
        <table class="table table-hover">
          <thead class="table-secondary">
            <tr>
              <th>No</th>
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
              <td>{{ index + 1 }}</td>
              <td>{{ pengaduan.tgl_pengaduan }}</td>
              <td v-if="pengaduan.isi_laporan.length > 20">
                {{ pengaduan.isi_laporan.substring(0, 20) + "...." }}
              </td>
              <td v-else>{{ pengaduan.isi_laporan }}</td>
              <td>
                <img
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
                  @click="hapus(pengaduan, index)"
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

    <!-- Modal Create -->
    <div
      class="modal fade"
      id="modalpengaduan"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Buat Pengaduan</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group-row">
                <label>Isi Laporan</label>
              </div>
              <div class="form-group-row">
                <textarea
                  v-model="pengaduan_ini.isi_laporan"
                  class="form-control"
                  name="isi_laporan"
                  rows="3"
                ></textarea>
              </div>
              <br />
              <div class="form-group-row">
                <label>Foto</label>
              </div>
              <div class="form-group-row">
                <img
                  v-if="preview_img"
                  :src="preview_img"
                  style="max-width: 100px; max-height: 100px:background-size: cover;"
                />
              </div>
              <div class="form-group-row">
                <input id="modalpengaduann" @change="onPreview" type="file" />
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
              @click="buatpengaduan()"
              type="button"
              class="btn btn-primary"
            >
              Create
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Create -->

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
          <div class="modal-body">
            <form>
              <div class="form-group-row">
                <label>Isi Laporan</label>
              </div>
              <div class="form-group-row">
                <textarea
                  v-model="pengaduan_ini.isi_laporan"
                  class="form-control"
                  name="isi_laporan"
                  rows="3"
                ></textarea>
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
              <div class="form-group-row">
                <input id="modalshoww" @change="onPreview" type="file" />
              </div>
              <br />
              <div class="form-group-row">
                <label
                  v-if="pengaduan_ini.status && pengaduan_ini.status != '0'"
                  >Status:
                  {{
                    pengaduan_ini.status.charAt(0).toUpperCase() +
                    pengaduan_ini.status.substring(1)
                  }}</label
                >
                <label v-else>Status: Belum</label>
              </div>
              <div class="form-group-row">
                <label v-if="pengaduan_ini.tanggapan == null"
                  >Tanggapan: Belum Ada</label
                >
                <label v-else
                  >TGL Tanggapan: {{ pengaduan_ini.tgl_tanggapan
                  }}<br />Tanggapan: {{ pengaduan_ini.tanggapan }}</label
                >
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
export default {
  data() {
    return {
      pengaduans: [],
      pengaduan_ini: [],
      user_ini: [],
      img: null,
      preview_img: null,
    };
  },
  mounted() {
    this.get_pengaduan();
    this.get_user_ini();
  },
  methods: {
    getImg: (pic) => {
      return pic;
    },
    show: function (pengaduan) {
      document.getElementById('modalpengaduann').value= null;
      document.getElementById('modalshoww').value= null;
      this.pengaduan_ini = pengaduan;
      this.preview_img = [];
      $("#modalshow").modal();
      this.get_pengaduan();
    },
    updatepengaduan() {
      this.$swal.fire({
        title: "Do you want to save the changes?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: `Save`,
        denyButtonText: `Don't save`,
      }).then((result) => {
        if (result.isConfirmed) {
          let config = {
            header: {
              "Content-Type": "image/png",
            },
          };
          let dataa = new FormData();
          dataa.append("id_pengaduan", this.pengaduan_ini.id_pengaduan);
          dataa.append("isi_laporan", this.pengaduan_ini.isi_laporan);
          //data.append('img', this.pengaduan_ini.foto)
          dataa.append("foto", this.img);

          axios.post("/api/pengaduan/update", dataa, config).then(response => {
            this.get_pengaduan();
            $("#modalshow").modal("hide");
          this.$swal.fire("Saved!", "", "success");
             document.getElementById('modalpengaduann').value= null;
      document.getElementById('modalshoww').value= null;
          });
          
        } else if (result.isDenied) {
          this.$swal.fire("Changes are not saved", "", "info");
        }
      });
    },
    hapus: function (data, i) {
      this.$swal
        .fire({
          title: "Ingin Menghapus?",
          showDenyButton: true,
          showCancelButton: false,
          confirmButtonText: `Save`,
          denyButtonText: `Don't save`,
        })
        .then((result) => {
          if (result.isConfirmed) {
            let a = new FormData();
            a.append("id_pengaduan", data.id_pengaduan);
            a.append("foto", data.foto);
            axios.post("/api/pengaduan/delete", a).then((response) => {
              this.pengaduans.data.splice(i, 1);
              this.get_pengaduan();
            });
            this.$swal.fire("Saved!", "", "success");
          } else if (result.isDenied) {
            this.$swal.fire("Changes are not saved", "", "info");
          }
        });
    },
    buatpengaduan: function () {
      let config = {
        header: {
          "Content-Type": "image/png",
        },
      };
      let data = new FormData();
      data.append("isi_laporan", this.pengaduan_ini.isi_laporan);
      data.append("foto", this.img);

      axios.post("/api/pengaduan/buat", data, config).then(response => {
        $("#modalpengaduan").modal("hide");
        this.get_pengaduan();
        this.$swal.fire("Sukses Create!");
           document.getElementById('modalpengaduann').value= null;
      document.getElementById('modalshoww').value= null;
      });
      this.get_pengaduan();
      this.pengaduan_ini = [];
      this.img = null
      this.preview_img = null
    },
    buat: function () {
         document.getElementById('modalpengaduann').value= null;
      document.getElementById('modalshoww').value= null;
      this.pengaduan_ini = [];
      this.img = null
      this.preview_img = null
      $("#modalpengaduan").modal();
    },
    onPreview(e) {
      const preview = e.target.files[0];
      this.preview_img = URL.createObjectURL(preview);
      this.img = e.target.files[0];
    },
    get_pengaduan() {
      axios.get("/api/pengaduan/get").then((response) => {
        console.log(response.data.data);
        this.pengaduans = response.data;
      });
    },
    get_user_ini() {
      axios.get("/api/user/ini").then((response) => {
        console.log(response.data);
      });
    },
  },
};
</script>

<style></style>
