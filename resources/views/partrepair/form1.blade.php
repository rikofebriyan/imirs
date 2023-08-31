<form action="{{ route('partrepair.waitingtable.store') }}" method="POST">
    @csrf
    <div class="container-fluid justify-content-center p-0">
        <div class="row gx-3">
            <div class="card col border mx-2">
                <div class="p-3">
                    <input type="hidden" name="id" value="{{ $waitingrepair->id }}">

                    <div class="mb-3 row">
                        <label for="tanggal" class="col-sm-3 col-form-label">Date
                            Created <sup class="text-danger">*</sup></label>
                        <div class="col-sm-9">
                            <input type="datetime-local" class="form-control" id="tanggal" name="date"
                                value="{{ $waitingrepair->date }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="parts_from" class="col-sm-3 col-form-label">Apakah part
                            pernah di repair?</label>
                        <div class="col-sm-9 col-form-label">

                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="part_from" id="radio1"
                                    value="Belum Pernah Repair"
                                    @if ($waitingrepair->part_from == 'Belum Pernah Repair') checked @else disabled @endif>
                                <label class="form-check-label" for="radio1">
                                    Belum Pernah Repair
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="part_from" id="radio2"
                                    value="Pernah Repair"
                                    @if ($waitingrepair->part_from == 'Pernah Repair') checked @else disabled @endif>
                                <label class="form-check-label" for="radio2">
                                    Pernah di Repair
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3 row" id="field2" @if ($waitingrepair->part_from == 'Belum Pernah Repair') style="display:none;" @endif>
                        <label for="code_part_repair" class="col-sm-3 col-form-label">Code Part
                            Repair</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control mb-3 bg-secondary text-white"
                                placeholder="Kode Part Repair" id="code_part_repair" name="code_part_repair"
                                value="{{ $waitingrepair->code_part_repair }}" readonly>

                            <div class="input-group">
                                <input type="text" class="form-control bg-secondary text-white" id="number_of_repair"
                                    name="number_of_repair" placeholder="Number of Repair"
                                    value="{{ $waitingrepair->number_of_repair }}" readonly>
                                <label for="number_of_repair" class="col-sm-3 col-form-label ms-3">Times</label>
                                <div id="number_of_repairFeedback" class="invalid-feedback">
                                    Part Has Been Repaired Over 5 Times. Please Scrap!
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="item_code" class="col-sm-3 col-form-label">Spare
                            Part</label>
                        <div class="col-sm-9">
                            {{-- <div class="input-group">
                                <input type="text" class="form-control" id="item_code" name="item_code"
                                    placeholder="Item Code" value="{{ $waitingrepair->item_code }}">
                                <input type="text" class="form-control" id="item_name" name="item_name"
                                    placeholder="Item Name" value="{{ $waitingrepair->item_name }}">
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" id="description" name="item_type"
                                    placeholder="Item Type" value="{{ $waitingrepair->item_type }}">
                            </div>

                            <div class="input-group">
                                <input type="text" class="form-control number" id="price" name="price"
                                    placeholder="Price" value="{{ $waitingrepair->price }}">
                                <input type="text" class="form-control" id="qty" name="stock_spare_part"
                                    placeholder="Stock" value="{{ $waitingrepair->stock_spare_part }}">
                            </div> --}}
                            <div class="input-group">
                                <input type="hidden" class="form-control" name="item_id" id="item_id">
                            </div>

                            <div class="input-group">
                                <label for="item_code" class="col-sm-3 col-form-label">Item Code <sup
                                        class="text-danger">*</sup></label>
                                <input type="text" class="form-control col-9" id="item_code" name="item_code"
                                    placeholder="Item Code" value="{{ $waitingrepair->item_code }}">
                            </div>

                            <div class="input-group">
                                <label for="item_name" class="col-sm-3 col-form-label">Item Name <sup
                                        class="text-danger">*</sup></label>
                                <input type="text" class="form-control col-9" id="item_name" name="item_name"
                                    placeholder="Item Name" value="{{ $waitingrepair->item_name }}">
                            </div>

                            <div class="input-group">
                                <label for="item_type" class="col-sm-3 col-form-label">Description <sup
                                        class="text-danger">*</sup></label>
                                <input type="text" class="form-control col-9" id="description" name="item_type"
                                    placeholder="Item Type" value="{{ $waitingrepair->item_type }}">
                            </div>

                            <div class="input-group">
                                <label for="price" class="col-sm-3 col-form-label">Price <sup
                                        class="text-danger">*</sup></label>
                                <input type="text" class="form-control number col-9" id="price"
                                    name="price" placeholder="Price" value="{{ $waitingrepair->price }}">
                            </div>

                            <div class="input-group">
                                <label for="qty" class="col-sm-3 col-form-label">Stock <sup
                                        class="text-danger">*</sup></label>
                                <input type="text" class="form-control number col-9" id="qty"
                                    name="stock_spare_part" placeholder="Stock"
                                    value="{{ $waitingrepair->stock_spare_part }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="maker" class="col-sm-3 col-form-label">Maker & Type <sup
                                class="text-danger">*</sup></label>
                        <div class="col">
                            <select class="form-control choices" id="maker" name="maker" required>
                                <option selected disabled>Maker ...</option>
                                @foreach ($maker as $mak)
                                    <option value="{{ $mak->name }}"
                                        @if ($waitingrepair->maker == $mak->name) selected @endif>
                                        {{ $mak->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control choices" id="type_of_part" name="type_of_part" required>
                                <option disabled>Type Of Part ...</option>
                                <option value="1" @if ($waitingrepair->type_of_part == 1) selected @endif>Mechanic
                                </option>
                                <option value="2" @if ($waitingrepair->type_of_part == 2) selected @endif>Hydraulic
                                </option>
                                <option value="3" @if ($waitingrepair->type_of_part == 3) selected @endif>Pneumatic
                                </option>
                                <option value="4" @if ($waitingrepair->type_of_part == 4) selected @endif>Electric
                                </option>
                            </select>
                        </div>

                    </div>


                    <div class="mb-3 row">
                        <label for="serial_number" class="col-sm-3 col-form-label">Serial
                            Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="serial_number" name="serial_number"
                                placeholder="Input Serial Number" value="{{ $waitingrepair->serial_number }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="problem" class="col-sm-3 col-form-label">Problem <sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="problem" name="problem" rows="4" placeholder="Input Detail Problem">{{ $waitingrepair->problem }}</textarea>
                        </div>
                    </div>



                </div>
            </div>
            <div class="card col border mx-2">
                <div class="p-3">
                    <div class="mb-3 row">
                        <label for="section" class="col-sm-3 col-form-label">Section <sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-9">

                            <select class="form-select" id="section" name="section">
                                <option disabled>Pilih ...</option>
                                @foreach ($section as $sec)
                                    <option value="{{ $sec->id }}"
                                        @if ($waitingrepair->section == $sec->name) selected @endif>
                                        {{ $sec->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="line" class="col-sm-3 col-form-label">Line <sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-9">
                            <select class="form-select" id="lineline" name="line">
                                <option disabled>Pilih ...</option>
                                @foreach ($line as $lin)
                                    <option value="{{ $lin->id }}"
                                        @if ($waitingrepair->line == $lin->name) selected @endif>
                                        {{ $lin->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="machine" class="col-sm-3 col-form-label">Machine <sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-9">
                            <select class="form-select" id="machine" name="machine">
                                <option disabled>Pilih ...</option>
                                @foreach ($machine as $mac)
                                    <option value="{{ $mac->id }}"
                                        @if ($waitingrepair->machine == $mac->name) selected @endif>
                                        {{ $mac->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="status_repair" class="col-sm-3 col-form-label">Status
                            Repair <sup class="text-danger">*</sup></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="status_repair" name="status_repair">
                                <option disabled>Pilih ...</option>
                                <option value="Normal" @if ($waitingrepair->status_repair == 'Normal') selected @endif>Normal
                                </option>
                                <option value="Urgent" @if ($waitingrepair->status_repair == 'Urgent') selected @endif>Urgent
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama_pic" class="col-sm-3 col-form-label">PIC User <sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-9">
                            <select class="form-control choices" id="nama_pic" name="nama_pic">
                                <option value="" disabled>Pilih ...</option>
                                @foreach ($user as $us)
                                    <option value="{{ $us->name }}"
                                        @if ($waitingrepair->nama_pic == $us->name) selected @endif>
                                        {{ $us->name }} | {{ $us->NPK }}
                                    </option>
                                @endforeach
                            </select>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="reg_sp" class="col-sm-3 col-form-label">Ticket
                            Number <sup class="text-danger">*</sup></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control disabledriko" id="reg_sp" name="reg_sp"
                                value="{{ $waitingrepair->reg_sp }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="progress" class="col-sm-3 col-form-label">Progress <sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control disabledriko" id="progres" name="progress"
                                value="{{ $waitingrepair->progress }}" readonly>
                        </div>
                    </div>

                    @if ($loginUser->jabatan == 'ADMIN' || $loginUser->jabatan == 'RepairMan')
                        <button type="submit"
                            class="btn btn-md btn-primary @if ($waitingrepair->progress == 'Finish') disabled @endif">Update</button>
                        <a href="{{ route('partrepair.waitingtable.index') }}"
                            class="btn btn-md btn-secondary @if ($waitingrepair->progress == 'Finish') disabled @endif">Back</a>
                        <button id="btnCetakTiket" type="button" class="btn icon btn-warning" data-bs-toggle="modal"
                            data-bs-target="#modalCetakTicket">Cetak
                            Tiket</button>
                    @else
                        <a class="btn btn-md btn-secondary disabled">Update</a>
                        <a href="/" class="btn btn-md btn-secondary">Back</a>
                        <span class="m-2"> Anda tidak punya hak akses untuk Edit Ticket</span>
                        <button type="submit" class="btn icon btn-warning">Cetak
                            Tiket</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
<form action="{{ route('ticket', $waitingrepair->reg_sp) }}" method="POST" style="display:inline">
    <div class="modal fade" id="modalCetakTicket" tabindex="-1" aria-labelledby="modalCetakTicketLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalCetakTicketLabel">Cetak Ticket</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="reg_sp" value="{{ $waitingrepair->reg_sp }}">
                    <span>Klik untuk cetak Ticket</span>
                    <button type="submit" class="btn icon btn-warning">Cetak
                        Tiket</button>
                </div>
            </div>
        </div>
</form>
