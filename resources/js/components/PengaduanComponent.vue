<template>
  <div class="row">
    <div class="col-md-3">
      <div class="card mt-2">
        <div class="card-body text-center">
          <button @click="buat()" class="btn btn-md btn-primary m-1">
            Buat Pengaduan
          </button>
        </div>
      </div>
    </div>
    <div class="col-md-9">
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
              <td>{{ pengaduan.foto }}</td>
              <td v-if="pengaduan.status == '0'">Belum</td>
              <td v-else>
                {{
                  pengaduan.status.charAt(0).toUpperCase() +
                  pengaduan.status.substring(1)
                }}
              </td>
              <td>
                <button class="btn btn-success m-1 btn-sm">
                  Show
                </button>
                <button class="btn btn-danger m-1 btn-sm">
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
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
            <h5 class="modal-title" id="exampleModalLabel">
              Buat Pengaduan
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
                  style="max-width: 100px; max-height: 100px;"
                />
              </div>
              <div class="form-group-row">
                <input @change="onPreview" type="file" />
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
            <button type="button" class="btn btn-primary">
              Save changes
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      pengaduans: [],
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
    buat: () => {
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
