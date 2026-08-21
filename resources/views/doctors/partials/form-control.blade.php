<div class="mb-3">
    <input type="file" name="pp" id="pp" class="form-control">
    @error('pp')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3">
    <label for="poli" class="form-label">Poli</label>
    <select name="poli" id="poli" class="form-select">
        <option disabled selected>-- Pilih poli --</option>
        @foreach($polis as $poli)
            <option {{ $poli->id == $doctor->poli_id ? 'selected' : '' }} value="{{ $poli->id }}">{{ $poli->name }}</option>
        @endforeach
    </select>
    @error('poli')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3">
    <label for="name" class="form-label">Nama</label>
    <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan Nama Dokter" value="{{ old('name') ?? $doctor->name }}">
    @error('name')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3">
    <label for="desc" class="form-label">Deskripsi</label>
    <textarea name="desc" id="desc" class="form-control" placeholder="Masukkan Deskripsi" rows="5">{{ old('desc') ?? $doctor->desc }}</textarea>
</div>
<div class="mb-3">
    <label for="birthdate" class="form-label">Tanggal Lahir</label>
    <input type="date" name="birthdate" id="birthdate" class="form-control" value="{{ old('birthdate') ?? $doctor->birthdate }}">
    @error('birthdate')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3">
    <label for="phone" class="form-label">Nomor Telepon</label>
    <input type="text" name="phone" id="phone" class="form-control" placeholder="Masukkan Nomor Telepon" value="{{ old('phone') ?? $doctor->phone }}">
    @error('phone')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email') ?? $doctor->email }}">
    @error('email')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="mb-3">
    <label for="address" class="form-label">Alamat</label>
    <textarea name="address" id="address" class="form-control" placeholder="Masukkan Alamat" rows="5">{{ old('address') ?? $doctor->address }}</textarea>
    @error('address')
        <div class="text-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<h5>Jadwal Dokter</h5>
<hr>
<div class="row">
    <div class="col-lg-8 col-md-12 col-8">
        <div class="mb-3">
            <label for="sen_start" class="form-label">Senin</label>
            <div class="row">
                <div class="col-5">
                    <input type="time" name="sen_start" id="sen_start" class="form-control form-control-sm" value="{{ old('sen_start') ?? $doctor->sen_start }}">
                </div>
                <div class="col-sc"><label for="sen_end">-</label></div>
                <div class="col-5">
                    <input type="time" name="sen_end" id="sen_end" class="form-control form-control-sm" value="{{ old('sen_end') ?? $doctor->sen_end }}">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="sel_start" class="form-label">Selasa</label>
            <div class="row">
                <div class="col-5">
                    <input type="time" name="sel_start" id="sel_start" class="form-control form-control-sm" value="{{ old('sel_start') ?? $doctor->sel_start }}">
                </div>
                <div class="col-sc"><label for="sel_end">-</label></div>
                <div class="col-5">
                    <input type="time" name="sel_end" id="sel_end" class="form-control form-control-sm" value="{{ old('sel_end') ?? $doctor->sel_end }}">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="rab_start" class="form-label">Rabu</label>
            <div class="row">
                <div class="col-5">
                    <input type="time" name="rab_start" id="rab_start" class="form-control form-control-sm" value="{{ old('rab_start') ?? $doctor->rab_start }}">
                </div>
                <div class="col-sc"><label for="rab_end">-</label></div>
                <div class="col-5">
                    <input type="time" name="rab_end" id="rab_end" class="form-control form-control-sm" value="{{ old('rab_end') ?? $doctor->rab_end }}">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="kam_start" class="form-label">Kamis</label>
            <div class="row">
                <div class="col-5">
                    <input type="time" name="kam_start" id="kam_start" class="form-control form-control-sm" value="{{ old('kam_start') ?? $doctor->kam_start }}">
                </div>
                <div class="col-sc"><label for="kam_end">-</label></div>
                <div class="col-5">
                    <input type="time" name="kam_end" id="kam_end" class="form-control form-control-sm" value="{{ old('kam_end') ?? $doctor->kam_end }}">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="jum_start" class="form-label">Jumat</label>
            <div class="row">
                <div class="col-5">
                    <input type="time" name="jum_start" id="jum_start" class="form-control form-control-sm" value="{{ old('jum_start') ?? $doctor->jum_start }}">
                </div>
                <div class="col-sc"><label for="jum_end">-</label></div>
                <div class="col-5">
                    <input type="time" name="jum_end" id="jum_end" class="form-control form-control-sm" value="{{ old('jum_end') ?? $doctor->jum_end }}">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="sab_start" class="form-label">Sabtu</label>
            <div class="row">
                <div class="col-5">
                    <input type="time" name="sab_start" id="sab_start" class="form-control form-control-sm" value="{{ old('sab_start') ?? $doctor->sab_start }}">
                </div>
                <div class="col-sc"><label for="sab_end">-</label></div>
                <div class="col-5">
                    <input type="time" name="sab_end" id="sab_end" class="form-control form-control-sm" value="{{ old('sab_end') ?? $doctor->sab_end }}">
                </div>
            </div>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-primary">{{ $submit ?? 'Update'}}</button>