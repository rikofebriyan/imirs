<div class="container-fluid justify-content-center py-0">

    @if ($message = Session::get('success'))
    @endif

    <div id="field3" class="p-3 mb-3 card border">
        <table id="myTable" class="table table-striped nowrap overflow-auto display">
            <thead>
                <tr>

                    <th scope="col">Action</th>
                    <th scope="col">Item Code</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Maker</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Status Part</th>
                    <th scope="col">Estimasi Kedatangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($progresspemakaian as $req)
                    <tr>
                        <td>
                            <button type="button"
                                class="btn btn-primary @if ($waitingrepair->progress == 'Finish'  || $waitingrepair->progress == 'Scrap') disabled @endif"
                                data-bs-toggle="modal" data-bs-target="#asu{{ $req->id }}"
                                style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size:
                                .75rem">
                                Update
                            </button>

                            <div class="modal fade" id="asu{{ $req->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">

                                        <!-- form edit sealkit -->
                                        <form action="{{ route('partrepair.progresspemakaian.update', $req->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <div class="container-fluid justify-content-center py-0">
                                                <div class="container-fluid">

                                                    <h4 class="modal-title text-center mt-2">Edit Seal Kit</h4>
                                                    <div class="row gx-3">
                                                        <div class="col">
                                                            <div class="p-3 m-3 border">

                                                                <input type="hidden" name="form_input_id"
                                                                    id="form_input_id" value="{{ $waitingrepair->id }}">

                                                                <div class="mb-3 row">
                                                                    <label for="item_code"
                                                                        class="col-sm-3 col-form-label">Spare
                                                                        Part</label>

                                                                    <div class="col-sm-9">

                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control disabledriko"
                                                                                id="item_code3" name="item_code"
                                                                                placeholder="Item Code"
                                                                                value="{{ $req->item_code }}" readonly>
                                                                            <input type="text"
                                                                                class="form-control disabledriko"
                                                                                id="item_name3" name="item_name"
                                                                                placeholder="Item Name"
                                                                                value="{{ $req->item_name }}" readonly>
                                                                        </div>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control disabledriko"
                                                                                id="description3" name="description"
                                                                                placeholder="description"
                                                                                value="{{ $req->description }}"
                                                                                readonly>
                                                                        </div>

                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control disabledriko number"
                                                                                id="price3{{ $req->id }}" name="price"
                                                                                placeholder="Price"
                                                                                value="{{ $req->price }}" readonly>
                                                                        </div>


                                                                        <div class="input-group">
                                                                            <select class="form-control disabledriko"
                                                                                id="maker" name="maker">
                                                                                <option value="{{ $req->maker }}"
                                                                                    selected disabled>
                                                                                    {{ $req->maker }}</option>
                                                                                @foreach ($maker as $mak)
                                                                                    <option
                                                                                        value="{{ $mak->name }}">
                                                                                        {{ $mak->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="mb-3 row">
                                                                    <label for="qty"
                                                                        class="col-sm-3 col-form-label">Qty</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="number"
                                                                            class="form-control qty_update"
                                                                            id="qty3{{ $req->id }}" name="qty"
                                                                            value="{{ $req->qty }}">
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3 row">
                                                                    <label for="total_price"
                                                                        class="col-sm-3 col-form-label">Total
                                                                        Price</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text"
                                                                            class="form-control disabledriko number total_price_update"
                                                                            id="total_price2{{ $req->id }}" name="total_price"
                                                                            value="{{ $req->total_price }}">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col">

                                                            <div class="p-3 m-3 border">

                                                                <div class="mb-3 row">
                                                                    <label for="quotation"
                                                                        class="col-sm-3 col-form-label">Status
                                                                        Part</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control status_partbaru_update"
                                                                            id="status_partbaru2" name="status_part">
                                                                            <option value="" selected disabled>
                                                                                Choose
                                                                                ...</option>
                                                                            <option value="Ready"
                                                                                @if ($req->status_part == 'Ready') selected @endif>
                                                                                Ready</option>
                                                                            <option value="Not Ready"
                                                                                @if ($req->status_part == 'Not Ready') selected @endif>
                                                                                Not Ready</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3 row status_partbaru_update_div @if ($req->status_part == 'Ready') d-none @endif">
                                                                    <label for="estimasi_kedatangan"
                                                                        class="col-sm-3 col-form-label">Estimasi
                                                                        Datang</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="datetime-local"
                                                                            class="form-control"
                                                                            id="estimasi_kedatangan"
                                                                            name="estimasi_kedatangan"
                                                                            value="{{ $req->estimasi_kedatangan }}">
                                                                    </div>
                                                                </div>


                                                                <button type="submit"
                                                                    class="btn btn-primary">Perbarui
                                                                    Data</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('partrepair.progresspemakaian.destroy', $req->id) }}"
                                method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="btn btn-danger @if ($waitingrepair->progress == 'Finish'  || $waitingrepair->progress == 'Scrap') disabled @endif"
                                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem"
                                    onclick="return confirm('Yakin?')">Delete</button>
                            </form>

                        </td>
                        <td>{{ $req->item_code }}</td>
                        <td>{{ $req->item_name }}</td>
                        <td>{{ $req->description }}</td>
                        <td>{{ $req->maker }}</td>
                        <td>{{ $req->qty }}</td>
                        <td><span class="number">{{ $req->price }}</span></td>
                        <td><span class="number">{{ $req->total_price }}</span></td>
                        <td>{{ $req->status_part }}</td>
                        <td>{{ $req->estimasi_kedatangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center text-mute" colspan="13">Tidak ada seal kit yang diinput</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="d-flex justify-content-end">
        @if ($loginUser->jabatan == 'ADMIN' || $loginUser->jabatan == 'RepairMan')
            <div class="me-1">
                <button id="fieldsealkit" class="btn btn-primary @if ($waitingrepair->progress == 'Finish'  || $waitingrepair->progress == 'Scrap') disabled @endif"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">TAMBAHKAN SEAL KIT</button>
            </div>
        @else
            <div class="">
                <button id="" class="btn btn-primary disabled" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">TAMBAHKAN SEAL KIT</button>
            </div>
            <center><span class="m-2"> Anda tidak punya hak akses untuk Edit Ticket</span></center>
        @endif
    </div>
</div>

<!-- form add new sealkit -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('partrepair.progresspemakaian.store') }}" method="POST">
                @csrf
                <div class="container-fluid justify-content-center py-0">
                    <div class="container-fluid">
                        <div class="modal-header border-0">
                            <h4 class="modal-title text-center mt-2">Add Seal Kit</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="row gx-0 px-3">
                            <div class="col mb-3">
                                <div class="p-3 my-0 border">
                                    <input type="hidden" name="form_input_id" id="form_input_id"
                                        value="{{ $waitingrepair->id }}">

                                    <div class="input-group mb-3">
                                        <label for="storage" class="col-sm-3 col-form-label">Warehouse <sup
                                                class="text-danger">*</sup></label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="storage" name="storage">
                                                <option value="" selected>Pilih ...</option>
                                                <option value="1">Maintenance Spare Part</option>
                                                <option value="2">Tool Center</option>
                                                <option value="3">Tool Room</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="item_code" class="col-sm-3 col-form-label">Spare Part</label>
                                        <div class="col-sm-9">
                                            <div class="d-flex">
                                                <select class="form-select" id="isiotomatis2" name="item_name">
                                                </select>
                                                <button id="btnAutoMan" type="button"
                                                    class="btn btn-primary ms-1">Auto</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group">
                                            <input type="hidden" class="form-control" name="item_id"
                                                id="item_id">
                                        </div>

                                        <div class="input-group mb-3">
                                            <label for="item_code" class="col-sm-3 col-form-label">Item Code <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control col-9 disabledriko"
                                                id="item_code" name="item_code" placeholder="Item Code" readonly
                                                required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <label for="item_name" class="col-sm-3 col-form-label">Item Name <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control col-9 disabledriko"
                                                id="item_name" name="item_name" placeholder="Item Name" readonly
                                                required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <label for="description" class="col-sm-3 col-form-label">Description
                                                <sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control col-9 disabledriko"
                                                id="description" name="description" placeholder="Item Type" readonly
                                                required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <label for="price" class="col-sm-3 col-form-label">Price <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control number col-9 disabledriko"
                                                id="price" name="price" placeholder="Price" readonly required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <label for="qty" class="col-sm-3 col-form-label">Stock <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control number col-9 disabledriko"
                                                id="qty" name="stock_spare_part" placeholder="Stock" readonly
                                                required>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="maker" class="col-sm-3 col-form-label">Maker <sup
                                            class="text-danger">*</sup></label>
                                        <div class="col-sm-9">
                                            <select class="form-control choices" id="maker" name="maker"
                                                required>
                                                <option selected disabled>Maker ...</option>
                                                @foreach ($maker as $mak)
                                                    <option value="{{ $mak->name }}">{{ $mak->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="qty" class="col-sm-3 col-form-label">Qty <sup
                                            class="text-danger">*</sup></label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="qty2" name="qty"
                                                value="">
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label for="total_price" class="col-sm-3 col-form-label">Total Price <sup
                                            class="text-danger">*</sup></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control number disabledriko"
                                                id="total_price" name="total_price" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row gx-0 px-3">
                            <div class="col mb-3">
                                <div class="p-3 my-0 border">
                                    <div class="mb-3 row">
                                        <label for="quotation" class="col-sm-3 col-form-label">Status Part <sup
                                            class="text-danger">*</sup></label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="status_partbaru" name="status_part" required>
                                                <option value="" selected>Status Part ...</option>
                                                <option value="Ready">Ready</option>
                                                <option value="Not Ready">Not Ready</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="notready" style="display: none">

                                        <div class="mb-3 row">
                                            <label for="estimasi_kedatangan" class="col-sm-3 col-form-label">Estimasi
                                                Datang <sup class="text-danger">*</sup></label>
                                            <div class="col-sm-9">
                                                <input type="datetime-local" class="form-control"
                                                    id="estimasi_kedatangan" name="estimasi_kedatangan">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row gx-0 px-3">
                            <div class="col mb-3">
                                <button type="submit" class="btn btn-md btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
