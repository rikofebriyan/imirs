<div class="container-fluid justify-content-center py-0">

    @if ($message = Session::get('success'))
    @endif

    <div id="field3" class="p-3 mb-3 card border" @if ($countid == 0) style="display: none;" @endif>
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#asu{{ $req->id }}"
                                style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size:
                                .75rem">
                                Edit
                            </button>

                            <div class="modal fade" id="asu{{ $req->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">

                                        <!-- form edit sealkit -->
                                        {{-- {!! Form::model($req, ['method' => 'PATCH', 'route' => ['partrepair.progresspemakaian.update', $req->id]]) !!} --}}
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
                                                                        <select class="form-select mb-3 choices"
                                                                            onchange="isi_otomatis_part2()"
                                                                            id="isiotomatis3" name="item_name"
                                                                            data-live-search="true">
                                                                            <option selected>{{ $req->item_code }}
                                                                            </option>
                                                                            @foreach ($mastersparepart as $reqs)
                                                                                <option
                                                                                    value="{{ $reqs->code_item_description }}">
                                                                                    {{ $reqs->item_code }} |
                                                                                    {{ $reqs->item_name }} |
                                                                                    {{ $reqs->description }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control"
                                                                                id="item_code3" name="item_code"
                                                                                placeholder="Item Code"
                                                                                value="{{ $req->item_code }}" readonly>
                                                                            <input type="text" class="form-control"
                                                                                id="item_name3" name="item_name"
                                                                                placeholder="Item Name"
                                                                                value="{{ $req->item_name }}" readonly>
                                                                        </div>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control"
                                                                                id="description3" name="description"
                                                                                placeholder="description"
                                                                                value="{{ $req->description }}"
                                                                                readonly>
                                                                        </div>

                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control"
                                                                                id="price3" name="price"
                                                                                placeholder="Price"
                                                                                value="{{ $req->price }}" readonly>
                                                                        </div>

                                                                        <div class="input-group">
                                                                            <select class="form-control" id="maker"
                                                                                name="maker">
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
                                                                        <input type="number" class="form-control"
                                                                            id="qty3" name="qty"
                                                                            value="{{ $req->qty }}">
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3 row">
                                                                    <label for="total_price"
                                                                        class="col-sm-3 col-form-label">Total
                                                                        Price</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control"
                                                                            id="total_price2" name="total_price"
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
                                                                        <select class="form-control"
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

                                                                <div class="mb-3 row">
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- {{ Form::open(['method' => 'DELETE', 'route' => ['partrepair.progresspemakaian.destroy', $req->id], 'style' => 'display:inline']) }} --}}
                            <form action="{{ route('partrepair.progresspemakaian.destroy', $req->id) }}"
                                method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                {{-- {{ Form::submit('Delete', [
                                    'class' => 'btn btn-danger',
                                    'style' => '--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem',
                                ]) }} --}}
                                <button type="submit" class="btn btn-danger"
                                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem"></button>
                            </form>
                            {{-- {{ Form::close() }} --}}
                        </td>
                        <td>{{ $req->item_code }}</td>
                        <td>{{ $req->item_name }}</td>
                        <td>{{ $req->description }}</td>
                        <td>{{ $req->maker }}</td>
                        <td>{{ $req->qty }}</td>
                        <td>{{ $req->price }}</td>
                        <td>{{ $req->total_price }}</td>
                        <td>{{ $req->status_part }}</td>
                        <td>{{ $req->estimasi_kedatangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center text-mute" colspan="13">Data post tidak tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="row">
        <div class="col-6">
            <div class="alert alert-primary fw-bold m-0 @if ($progresspemakaian->count() > 0) d-none @endif">
                <center>APAKAH PART REPAIR BUTUH ORDER SEAL KIT?</center>
                <center>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="radio1" id="ya" value=""
                            @if ($countid > 0) checked @endif>
                        <label class="form-check-label" for="flexRadioDefault1">
                            YA
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="radio1" id="tidak" value=""
                            @if ($countid == 0) checked @endif>
                        <label class="form-check-label" for="flexRadioDefault2">
                            TIDAK
                        </label>
                    </div>
                </center>
            </div>
        </div>
        <div class="d-grid gap-2 col">
            <button id="fieldsealkit" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#exampleModal">TAMBAHKAN SEAL KIT</button>
        </div>
        <div class="d-grid gap-2 col @if ($countid == 0) d-block @else d-none @endif" id="fieldrepair">
            <button href="{{ route('partrepair.progresspemakaian.show', $waitingrepair->id) }}"
                class="btn btn-success">REPAIR & TRIAL
                >>></button>
        </div>

        @if ($countid == 0)
        @elseif ($countid > $ready)
            <div class="d-grid gap-2 col">
                <button class="btn btn-primary disabled text-center">REPAIR & TRIAL
                    >>></button>
            </div>
        @elseif ($countid == $ready)
            <div class="d-grid gap-2 col">
                <a href="{{ route('partrepair.progresspemakaian.show', $waitingrepair->id) }}"
                    class="btn btn-success">REPAIR & TRIAL
                    >>></a>
            </div>
        @endif
    </div>






</div>

<!-- form add new sealkit -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            {{-- {{ Form::open(['route' => 'partrepair.progresspemakaian.store', 'method' => 'POST']) }} --}}
            <form action="{{ route('partrepair.progresspemakaian.store') }}" method="POST">
                @csrf

                {{-- form input --}}

                <div class="container-fluid justify-content-center py-0">
                    <div class="container-fluid">

                        <h4 class="modal-title text-center mt-2">Add Seal Kit</h4>
                        <div class="row gx-3">
                            <div class="col">
                                <div class="p-3 m-3 border">

                                    <input type="hidden" name="form_input_id" id="form_input_id"
                                        value="{{ $waitingrepair->id }}">

                                    <div class="mb-3 row">
                                        <label for="item_code" class="col-sm-3 col-form-label">Spare Part</label>
                                        <div class="col-sm-9">
                                            {{-- <select class="form-select mb-3 choices" onchange="isi_otomatis_part()"
                                            id="isiotomatis2" name="item_name" data-live-search="true">
                                            <option selected></option>
                                            @foreach ($mastersparepart as $reqm)
                                                <option value="{{ $reqm->code_item_description }}">
                                                    {{ $reqm->item_code }} |
                                                    {{ $reqm->item_name }} | {{ $reqm->description }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                            <div class="mb-3">
                                                <select class="form-select form-select-isiotomatis2"
                                                    onchange="isi_otomatis_part()" id="isiotomatis2" name="item_name"
                                                    required>
                                                    <option value="" selected></option>
                                                    @foreach ($mastersparepart as $reqm)
                                                        <option data-custom-properties="{{ $reqm->item_code }}"
                                                            value="{{ $reqm->code_item_description }}">
                                                            {{ $reqm->item_code }} |
                                                            {{ $reqm->item_name }} | {{ $reqm->description }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-secondary text-white"
                                                    id="item_code2" name="item_code" placeholder="Item Code"
                                                    readonly>
                                                <input type="text" class="form-control bg-secondary text-white"
                                                    id="item_name2" name="item_name" placeholder="Item Name"
                                                    readonly>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-secondary text-white"
                                                    id="description2" name="description" placeholder="description"
                                                    readonly>
                                            </div>

                                            <div class="input-group">
                                                <input type="text" class="form-control bg-secondary text-white"
                                                    id="price2" name="price" placeholder="Price" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="maker" class="col-sm-3 col-form-label">Maker</label>
                                        <div class="col">
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


                                    <div class="mb-3 row">
                                        <label for="qty" class="col-sm-3 col-form-label">Qty</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="qty2" name="qty"
                                                value="">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="total_price" class="col-sm-3 col-form-label">Total Price</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="total_price"
                                                name="total_price" value="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col">

                                <div class="p-3 m-3 border">
                                    <div class="mb-3 row">
                                        <label for="quotation" class="col-sm-3 col-form-label">Status Part</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="status_partbaru" name="status_part">
                                                <option value="" selected disabled>Status Part ...</option>
                                                <option value="Ready">Ready</option>
                                                <option value="Not Ready">Not Ready</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="notready" style="display: none">

                                        <div class="mb-3 row">
                                            <label for="estimasi_kedatangan" class="col-sm-3 col-form-label">Estimasi
                                                Datang</label>
                                            <div class="col-sm-9">
                                                <input type="datetime-local" class="form-control"
                                                    id="estimasi_kedatangan" name="estimasi_kedatangan">
                                            </div>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-md btn-primary">Save</button>
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
