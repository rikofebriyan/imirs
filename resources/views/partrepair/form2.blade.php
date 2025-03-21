<form action="{{ route('partrepair.progresstable.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="container-fluid justify-content-center p-0">
        <div class="row gx-3">
            <div class="col card border mx-2">
                <div class="p-3">
                    <input type="hidden" name="form_input_id" id="form_input_id" value="{{ $waitingrepair->id }}">
                    <input type="hidden" id="user_id" name="user_id" value="{{ $waitingrepair->nama_pic }}">

                    <div class="mb-3 row">
                        <label for="place_of_repair" class="col-sm-3 col-form-label">Place
                            Repair <sup class="text-danger">*</sup></label>
                        <div class="col-sm-5">
                            <select class="form-select choices" id="showsubcont" name="place_of_repair">
                                <option value="">Pilih ...</option>
                                <option value="In House" @if ($progressrepair2->place_of_repair == 'In House') selected @endif>In House
                                </option>
                                <option value="Subcont" @if ($progressrepair2->place_of_repair == 'Subcont') selected @endif>Subcont
                                </option>
                                <option value="Trade In" @if ($progressrepair2->place_of_repair == 'Trade In') selected @endif>Trade In
                                </option>
                            </select>
                        </div>
                    </div>



                    <div class="mb-3 row">
                        <label for="analisa" class="col-sm-3 col-form-label">Analisa <sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="analisa" name="analisa" rows="5" placeholder="Input Analisa" required>{{ $progressrepair2->analisa }}</textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="action" class="col-sm-3 col-form-label">Action <sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="action" name="action" rows="5" placeholder="Input Action" required>{{ $progressrepair2->action }}</textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="judgement" class="col-sm-3 col-form-label">Judgement <sup
                                class="text-danger">*</sup></label>
                        <div class="col-sm-9">
                            <select class="form-select choices" id="judgement_scrap" name="judgement" required>
                                <option value="">Pilih ...</option>
                                <option value="Continue Repair" @if ($progressrepair2->judgement == 'Continue Repair') selected @endif>
                                    Continue
                                    Repair</option>
                                <option value="Scrap" @if ($progressrepair2->judgement == 'Scrap') selected @endif>Scrap</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-sm-3">
                            <label for="pic_repair" class="col-form-label">PIC Repair <sup
                                    class="text-danger">*</sup></label>
                        </div>
                        <div class="col-sm-5">
                            <select class="form-select choices" id="isiotomatis" onchange="isi_otomatis()"
                                name="pic_repair" required>
                                <option value="">Pilih ...</option>
                                @foreach ($user as $us)
                                    <option value="{{ $us->name }}"
                                        @if ($progressrepair2->pic_repair == $us->name) selected @endif>
                                        {{ $us->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col card border mx-2">
                <div class="p-3">
                    <div id="inHouse"
                        @if ($progressrepair2->place_of_repair == 'In House') style="display: block;" @else style="display: none;" @endif>
                        <div class="mb-3 row">
                            <label
                                class="col-form-label col-sm-12 bg-secondary text-white rounded-3 text-center mb-2">Plan
                                Repair</label>
                            <label for="plan_start_repair" class="col-sm-3 col-form-label">Start <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control" name="plan_start_repair"
                                    id="plan_start_repair" value="{{ $progressrepair2->plan_start_repair }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="plan_finish_repair" class="col-sm-3 col-form-label">Finish <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control" name="plan_finish_repair"
                                    id="plan_finish_repair" value="{{ $progressrepair2->plan_finish_repair }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label
                                class="col-form-label col-sm-12 bg-success text-white rounded-3 text-center mb-2">Actual
                                Repair</label>
                            <label for="actual_start_repair" class="col-sm-3 col-form-label">Start <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control asu" id="datepicker"
                                    name="actual_start_repair" value="{{ $progressrepair2->actual_start_repair }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="actual_finish_repair" class="col-sm-3 col-form-label">Finish <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control asu" id="datepicker2"
                                    name="actual_finish_repair" value="{{ $progressrepair2->actual_finish_repair }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="total_time_repair" class="col-sm-3 col-form-label">Time
                                Repair <sup class="text-danger">*</sup></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control disabledriko" id="selisih"
                                    name="total_time_repair" placeholder="Hours"
                                    value="{{ $progressrepair2->total_time_repair }}" readonly>
                            </div>
                            <label for="total_time_repair" class="col-sm-2 col-form-label">Hours</label>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-3">
                                <label for="labour_cost" class="col-form-label">Labour Cost <sup
                                        class="text-danger">*</sup></label>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control number disabledriko" id="labour_cost"
                                    name="labour_cost" value="{{ $progressrepair2->labour_cost }}"
                                    placeholder="Labour Cost" readonly>
                            </div>
                        </div>
                    </div>

                    <div id="subcont"
                        @if ($progressrepair2->place_of_repair == 'Subcont' || $progressrepair2->place_of_repair == 'Trade In') style="display: block;" @else style="display: none;" @endif>
                        <div class="mb-3 row">
                            <label for="subcont_name" class="col-sm-3 col-form-label">Subcont
                                Name <sup class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="subcont_name" name="subcont_name">
                                    <option value="">Pilih ...</option>
                                    @foreach ($subcont as $sub)
                                        <option value="{{ $sub->name }}"
                                            @if ($progressrepair2->subcont_name == $sub->name) selected @endif>{{ $sub->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="surat_jalan" class="col-sm-3 col-form-label">No. Surat Jalan <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="surat_jalan" name="surat_jalan"
                                    value="{{ $progressrepair2->nomor_pp }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="no_quotation" class="col-sm-3 col-form-label">No. Quotation <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="no_quotation" name="no_quotation"
                                    value="{{ $progressrepair2->quotation }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="subcont_cost" class="col-sm-3 col-form-label">Cost <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control number" id="subcont_cost"
                                    name="subcont_cost" value="{{ $progressrepair2->subcont_cost }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="lead_time" class="col-sm-3 col-form-label">Lead Time <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="lead_time" name="lead_time"
                                    value="{{ $progressrepair2->lead_time }}">
                            </div>
                            <div class="col-sm-3">
                                <select class="form-select" name="time_period" id="time_period">
                                    <option value="" selected>Pilih ...</option>
                                    <option value="Week" @if ($progressrepair2->time_period == 'Week') selected @endif>Weeks
                                    </option>
                                    <option value="Month" @if ($progressrepair2->time_period == 'Month') selected @endif>Month
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label
                                class="col-form-label col-sm-12 bg-secondary text-white rounded-3 text-center mb-2">Plan
                                Repair</label>
                            <label for="plan_start_repair" class="col-sm-3 col-form-label">Start <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control" name="plan_start_repair_subcont"
                                    id="plan_start_repair_subcont" value="{{ $progressrepair2->plan_start_repair }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="plan_finish_repair_subcont" class="col-sm-3 col-form-label">Finish <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control" id="plan_finish_repair_subcont"
                                    name="plan_finish_repair_subcont"
                                    value="{{ $progressrepair2->plan_finish_repair }}">
                            </div>
                        </div>
                    </div>

                    @if ($loginUser->jabatan == 'ADMIN' || $loginUser->jabatan == 'RepairMan' || $loginUser->jabatan == 'Die Maintenance')
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <button id="scrap" type="submit" class="btn btn-md btn-danger"
                                style="display: none">Scrap</button>
                            <button id="saveit" type="submit"
                                class="btn btn-md btn-primary @if ($waitingrepair->progress == 'Finish' || $waitingrepair->progress == 'Scrap') disabled @endif">Save</button>
                            <a href="{{ route('partrepair.waitingtable.index') }}"
                                class="btn btn-md btn-secondary @if ($waitingrepair->progress == 'Finish' || $waitingrepair->progress == 'Scrap') disabled @endif">Back</a>
                        </div>
                    @else
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <a class="btn btn-md btn-secondary disabled" style="display: none">Scrap</a>
                            <a class="btn btn-md btn-secondary disabled">Save</a>
                            <a href="{{ route('partrepair.waitingtable.index') }}"
                                class="btn btn-md btn-secondary">Back</a>
                            <span class="m-2"> Anda tidak punya hak akses untuk Edit Ticket</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
