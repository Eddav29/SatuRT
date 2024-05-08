<!-- CSS -->
<style>
  :root {
      font-family: 'Calibri', sans-serif;
      color: #000;
  }
  
  .container {
      width: 595px;
      height: 842px;
      background: #fff;
      padding: 50px;
      position: relative;
  }
  
  .neighborhood-header {
      border-bottom: 2px solid #000;
      display: flex;
      flex-direction: column;
      text-align: center;
      padding: 10px 0;
  }
  
  .neighborhood-header h1,
  .neighborhood-header p {
      margin: 0;
  }
  
  .title {
      text-align: center;
      font-weight: 700;
      text-decoration: underline;
      margin-top: 20px;
      font-size: 16px;
  }
  
  .document-number,
  .statement {
      text-align: center;
      font-weight: 400;
      font-size: 12px;
  }
  
  .surat-section {
      padding: 20px;
  }
  
  .form-group {
      display: flex;
      justify-content: space-between;
      padding: 5px;
      font-size: 12px;
  }
  
  .form-group label {
      font-weight: 700;
  }
  
  .form-group .field {
      flex: 1;
      border-bottom: 1px #000;
  }
  
  .signature-section {
      display: flex;
      justify-content: space-between;
      padding-top: 30px;
      margin-left: 2rem;
  }
  
  .signature-block {
      text-align: center;
  }
  
  .notes {
      font-size: 10px;
      margin-top: 20px;
  }
  
  .notes p {
      margin: 0;
  }
  
  </style>
  
  <!-- HTML -->
  <div class="container">
      <div class="neighborhood-header">
          <h1>RUKUN TETANGGA 01 RUKUN WARGA 03</h1>
          <p>KELURAHAN TUNJUNGSEKAR KECAMATAN LOWOKWARU<br/>KOTA MALANG</p>
      </div>
      
      <div class="title">SURAT PENGANTAR</div>
      <div class="document-number">Nomor: .... / RT 01 / RW 03 / TS / 2024 / 20</div>
      <div class="statement">Yang bertandatangan di bawah ini menerangkan bahwa:</div>
      
      <div class="surat-section">
          <div class="form-group">
              <label>Nama:</label>
              <span class="field"> {{ $persuratan->pengajuan->penduduk->nama }}</span>
          </div>
          <div class="form-group">
              <label>Tempat, Tanggal Lahir:</label>
              <span class="field">{{ $persuratan->pengajuan->penduduk->tanggal_lahir }}, {{ $persuratan->pengajuan->penduduk->tanggal_lahir }}</span>
          </div>
          <div class="form-group">
              <label>Jenis Kelamin:</label>
              <span class="field">{{ $persuratan->pengajuan->penduduk->jenis_kelamin }}</span>
          </div>
          <div class="form-group">
              <label>Agama:</label>
              <span class="field">{{ $persuratan->pengajuan->penduduk->agama }}</span>
          </div>
          <div class="form-group">
              <label>Status Perkawinan:</label>
              <span class="field">{{ $persuratan->pengajuan->penduduk->status_perkawinan }}</span>
          </div>
          <div class="form-group">
              <label>Pekerjaan:</label>
              <span class="field">{{ $persuratan->pengajuan->penduduk->pekerjaan }}</span>
          </div>
          <div class="form-group">
              <label>Nomor KTP / KK:</label>
              <span class="field">{{ $persuratan->pengajuan->penduduk->nik }}</span>
          </div>
          <div class="form-group">
              <label>Alamat:</label>
              <span class="field">{{ $persuratan->pengajuan->penduduk->alamat }}</span>
          </div>
          
          <div class="form-group">
              <span>
                  Surat ini dipergunakan untuk mengurus:
              </span>
          </div>
          
          <div class="form-group">
              <span>
                  <strong>a.</strong> KTP
              </span>
              <span>
                  <strong>b.</strong> KK
              </span>
              <span>
                  <strong>c.</strong> Akte Kelahiran
              </span>
              <span>
                  <strong>d.</strong> Akte Kematian
              </span>
          </div>
          
          <div class="form-group">
              <span>
                  <strong>e.</strong> SKCK
              </span>
              <span>
                  <strong>f.</strong> Persyaratan Nikah
              </span>
              
          </div>
          <div class="form-group">
            <span>
                <strong>g.</strong> Lainnya {{ $persuratan->pengajuan->keterangan }}
            </span>
          </div>
      </div>
      
      <div class="signature-section">
          <div class="signature-block">
              <div>Malang,{{ $persuratan->pengajuan->accepted_at }}</div>
              <div style="height: 50px;"></div> <!-- Ruang untuk tanda tangan -->
              <div>Solih Kusaeri</div> <!-- Nama Ketua RT -->
          </div>
      </div>
      
      <div class="notes">
          <p><strong>Catatan:</strong></p>
          <p>1. Semua pengurusan surat di Kelurahan harus melampirkan Fotokopi KTP / KK / Pelunasan PBB Tahun 2018</p>
          <p>2. Untuk pengurusan KTP dilampiri: Pas Foto Berwarna ukuran 4 x 6 sebanyak 4 lembar (Background sesuai Tahun Kelahiran: Warna Biru = Tahun Genap, Warna Merah = Tahun Ganjil)</p>
          <p>3. *) Lingkari huruf a, b, c, d, e, atau g sesuai dengan yang diinginkan</p>
      </div>
      
  </div>
  