{{-- {{ Form::open(['route' => 'partrepair.finishrepair.store', 'method' => 'POST']) }} --}}
<form action="{{ route('partrepair.finishrepair.store') }}" method="POST">
    @csrf
    <div class="container-fluid justify-content-center py-0">
        <div class="row">
            <div class="card col border mx-2">
                <div class="p-3">
                    <div class="d-flex justify-content-between">
                        <div class="p-0">
                            <h3>Summary Finish Details</h3>
                        </div>
                        <div class="p-0">
                            <a href="{{ route('home') }}"><img width="120" height="30"
                                    src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo"></a>
                        </div>
                    </div>

                    <div class="divider m-0">
                        <div class="divider-text">Repair Information</div>
                    </div>

                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">No. Ticket</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_reg_sp" class="form-control border-0"
                                value="{{ $waitingrepair->reg_sp }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Date Created</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_date" class="form-control border-0"
                                value="{{ $waitingrepair->date }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Part Name</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_item_name" class="form-control border-0"
                                value="{{ $waitingrepair->item_name }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Part Type</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_item_type" class="form-control border-0"
                                value="{{ $waitingrepair->item_type }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Maker</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_maker" class="form-control border-0"
                                value="{{ $waitingrepair->maker }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Price</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_price" class="form-control number border-0"
                                value="{{ $waitingrepair->price }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">PIC repair</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_nama_pic" class="form-control border-0"
                                value="{{ $waitingrepair->nama_pic }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Place of Repair</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_place_of_repair" class="form-control border-0"
                                value="{{ $formFinish_progressrepair->place_of_repair }}" readonly>
                        </div>
                    </div>

                    <div class="divider m-0">
                        <div class="divider-text">Detail Analisa & Action</div>
                    </div>
                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Analisa</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_analisa" class="form-control border-0"
                                value="{{ $formFinish_progressrepair->analisa }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Action</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_action" class="form-control border-0"
                                value="{{ $formFinish_progressrepair->action }}" readonly>
                        </div>
                    </div>

                    <div class="divider m-0">
                        <div class="divider-text">Cost</div>
                    </div>
                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Subcont Cost</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_subcont_cost" class="form-control number border-0"
                                value="{{ $formFinish_progressrepair->subcont_cost }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Labor Cost</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_labour_cost" class="form-control number border-0"
                                value="{{ $formFinish_progressrepair->labour_cost }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Seal Kit Cost</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_seal_kit_cost" class="form-control number border-0"
                                value="{{ $formFinish_progresspemakaian->sum('total_price') }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Total Cost Repair</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_total_cost_repair" class="form-control number border-0"
                                value="{{ $formFinish_progressrepair->subcont_cost + $formFinish_progressrepair->labour_cost + $formFinish_progresspemakaian->sum('total_price') }}"
                                readonly>
                        </div>
                    </div>

                    <div class="divider m-0 mb-3">
                        <div class="divider-text">Trial Result</div>
                    </div>

                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Item Check</th>
                                    <th class="text-center">Operation</th>
                                    <th class="text-center">Standard Min</th>
                                    <th class="text-center">Standard Max</th>
                                    <th class="text-center">Unit Measurement</th>
                                    <th class="text-center">Actual</th>
                                    <th class="text-center">Judgement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($formFinish_progresstrial as $item)
                                    <tr>
                                        <td>{{ $item->item_standard }}</td>
                                        <td>{{ $item->operation }}</td>
                                        <td class="text-center">{{ $item->standard_pengecekan_min }}</td>
                                        <td class="text-center">{{ $item->standard_pengecekan_max }}</td>
                                        <td class="text-center">{{ $item->unit_measurement }}</td>
                                        <td class="text-center">{{ $item->actual_pengecekan }}</td>
                                        <td class="text-center">{{ $item->judgement }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="divider m-0">
                        <div class="divider-text">Cost Saving</div>
                    </div>
                    <div class="row">
                        <label for="disabledInput" class="col-sm-3 col-form-label">Total Cost Saving</label>
                        <div class="col-sm-9 align-items-center d-flex">
                            <input type="text" name="f_total_cost_saving" class="form-control number border-0"
                                value="{{ $waitingrepair->price - ($formFinish_progressrepair->subcont_cost + $formFinish_progressrepair->labour_cost + $formFinish_progresspemakaian->sum('total_price')) }}"
                                readonly>
                        </div>
                    </div>


                </div>
            </div>

            <div class="card col-4 border p-3 mx-2">

                <input type="hidden" name="form_input_id" id="form_input_id" value="{{ $waitingrepair->id }}">
                <input type="hidden" name="progressrepair_id" id="progressrepair_id"
                    value="{{ $formFinish_progressrepair->id }}">

                <div id="finishForm">
                    <div class="mb-3 row" @if ($progressrepair2->place_of_repair == 'Trade In') style="display:none;" @endif>
                        <div class="col-sm-3">
                            <label for="category" class="col-form-label">Category</label>
                        </div>
                        <div class="col-sm-5">
                            <select class="form-select choices" onchange="categorycodeajax()" id="categorycodejs"
                                name="category">
                                <option value="" selected>Pilih ...</option>
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->category_code }}">
                                        {{ $cat->category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="number" id="number">

                    <div class="mb-3 row" @if ($progressrepair2->place_of_repair == 'Trade In') style="display:none;" @endif>
                        <label for="code_part_repair" class="col-sm-3 col-form-label">Code Part
                            Repair</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="code_part_repair2"
                                name="code_part_repair" value="{{ $waitingrepair->code_part_repair }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="delivery_date" class="col-sm-3 col-form-label">Delivery
                            Date</label>
                        <div class="col-sm-9">
                            <input type="datetime-local" class="form-control" id="delivery_date"
                                name="delivery_date" value="{{ $formFinish_totalFinish->delivery_date }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="pic_delivery" class="col-sm-3 col-form-label">PIC
                            Delivery</label>
                        <div class="col-sm-9">
                            <select class="form-select choices" id="isiotomatis" onchange="isi_otomatis()"
                                name="pic_delivery">
                                <option value="" selected>Pilih ...</option>
                                @foreach ($user as $us)
                                    <option value="{{ $us->name }}"
                                        @if ($formFinish_totalFinish->pic_delivery == $us->name) selected @endif>
                                        {{ $us->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="mb-3 row">
                    <div class="p-3">
                        @if (Auth::user()->jabatan == 'ADMIN' || Auth::user()->jabatan == 'RepairMan')
                            <button type="submit" class="btn btn-md btn-primary">Save</button>
                            <a href="{{ route('partrepair.waitingtable.index') }}"
                                class="btn btn-md btn-secondary">Back</a>
                        @else
                            <a class="btn btn-md btn-secondary disabled">Save</a>
                            <a href="{{ route('partrepair.waitingtable.index') }}"
                                class="btn btn-md btn-secondary">Back</a>
                            <span class="m-2"> Anda tidak punya hak akses untuk Edit Ticket</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
