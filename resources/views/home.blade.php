@extends('layouts.app')

@section('content')
    <div class="row row-sm">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 bg-primary bg-gradient">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Total Pengajuan</p>
                                    <h4 class="my-1 text-white">1</h4>
                                </div>
                                <div class="text-white ms-auto font-35"><i class="bx bx-cart-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 bg-danger bg-gradient">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Pengajuan Bulan Ini</p>
                                    <h4 class="my-1 text-white">10</h4>
                                </div>
                                <div class="text-white ms-auto font-35"><i class="bx bx-minus-back"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card radius-10 bg-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Total OPD</p>
                                    <h4 class="my-1 text-white">54</h4>
                                    {{-- <p class="mb-0 font-13 text-white"><i class="bx bxs-up-arrow align-middle"></i>$34 from
                                        last week</p> --}}
                                </div>
                                <div class="widgets-icons bg-white text-success ms-auto"><i class="bx bxs-wallet"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 bg-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-dark">Pengajuan Selesai</p>
                                    <h4 class="my-1 text-dark">6</h4>
                                    {{-- <p class="mb-0 font-13 text-dark"><i class="bx bxs-up-arrow align-middle"></i>$24 from
                                        last week</p> --}}
                                </div>
                                <div class="widgets-icons bg-white text-dark ms-auto"><i class="bx bxs-group"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">

                <div class="card-body overflow-hidden p-relative z-index-1 scrollable">
                    <table class="table text-md-nowrap datatable-basic-subkegiatan ">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>OPD</th>
                                @foreach ($fases as $f)
                                    <th>{{ $f->nama }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 0; @endphp
                            @foreach ($opd as $o)
                                <tr>
                                    <td>{{ $no += 1 }}</td>
                                    <td>
                                        {{ $o->unit_name }}
                                    </td>
                                    @foreach ($fases as $f)
                                        @php
                                            $count = $pengajuan
                                                ->where('fase_id', $f->id)
                                                ->where('opd_id', $o->id)
                                                ->count();
                                        @endphp
                                        <td>{{ $count }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5/main.css' rel='stylesheet' />
@endpush
@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5/main.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: "{{ route('calendar_dashboard') }}", // URL to fetch events from the backend
                eventClick: function(info) {
                    // Redirect to the URL when an event is clicked
                    var eventUrl = "{{ route('pengajuan.detail', ':eventId') }}".replace(':eventId',
                        info
                        .event.id);
                    window.open(eventUrl, '_blank');
                }
            });
            calendar.render();
        });
    </script>
@endpush
