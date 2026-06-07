@extends('layouts/default')

@section('title')
{{ trans('general.dashboard') }}
@parent
@stop

@push('css')
<style>
/* ---- INV Dashboard ---- */
.inv-dash { padding: 24px; }

/* Stat Cards */
.inv-stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px; }
.inv-stat-card { background: #fff; border-radius: 12px; padding: 18px; box-shadow: 0 2px 6px rgba(15,27,45,.06), 0 8px 24px rgba(15,27,45,.06); cursor: pointer; transition: transform .12s; text-decoration: none; display: block; border: 1px solid #e5e9f0; }
.inv-stat-card:hover { transform: translateY(-2px); text-decoration: none; }
.inv-stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
.inv-stat-icon i { font-size: 18px; }
.inv-stat-n { font-size: 30px; font-weight: 800; letter-spacing: -1px; color: #0f1b2d; line-height: 1; margin-bottom: 4px; }
.inv-stat-l { font-size: 13px; font-weight: 600; color: #6b7888; }

/* Two column layout */
.inv-two-col { display: grid; grid-template-columns: 1.55fr 1fr; gap: 16px; align-items: start; }

/* Cards */
.inv-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 6px rgba(15,27,45,.06), 0 8px 24px rgba(15,27,45,.06); border: 1px solid #e5e9f0; margin-bottom: 16px; overflow: hidden; }
.inv-card-header { padding: 14px 18px; border-bottom: 1px solid #e5e9f0; display: flex; align-items: center; justify-content: space-between; }
.inv-card-header h3 { font-size: 14px; font-weight: 700; color: #0f1b2d; margin: 0; }
.inv-card-body { padding: 0; }
.inv-card-footer { padding: 12px 18px; border-top: 1px solid #e5e9f0; text-align: center; }

/* Quick Actions */
.inv-quick-actions { display: flex; gap: 12px; margin-bottom: 16px; }
.inv-quick-tile { flex: 1; display: flex; align-items: center; gap: 12px; padding: 14px; border-radius: 12px; border: 1px solid #e5e9f0; background: #fff; text-decoration: none; transition: all .12s; box-shadow: 0 1px 2px rgba(15,27,45,.06); }
.inv-quick-tile:hover { transform: translateY(-2px); text-decoration: none; }
.inv-quick-tile:hover.blue { border-color: #1f6feb; }
.inv-quick-tile:hover.green { border-color: #15803d; }
.inv-quick-tile:hover.navy { border-color: #0a2540; }
.inv-quick-thumb { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.inv-quick-thumb i { font-size: 18px; color: #fff; }
.inv-quick-label { font-size: 13.5px; font-weight: 700; color: #0f1b2d; display: block; }
.inv-quick-sub { font-size: 11.5px; color: #6b7888; display: block; }

/* Activity table */
.inv-activity-table { width: 100%; }
.inv-activity-table td { padding: 11px 18px; border-top: 1px solid #e5e9f0; font-size: 13px; color: #3c4a5e; vertical-align: middle; }
.inv-activity-table tr:first-child td { border-top: none; }
.inv-activity-table tr:hover td { background: #f8fafc; }
</style>
@endpush

@section('content')

<div class="inv-dash">

@if ($snipeSettings->dashboard_message != '')
<div class="inv-card" style="margin-bottom: 20px;">
    <div class="inv-card-body" style="padding: 16px 18px;">
        {!! Helper::parseEscapedMarkedown($snipeSettings->dashboard_message) !!}
    </div>
</div>
@endif

{{-- Stat Cards --}}
<div class="inv-stat-grid">
    <a href="{{ route('hardware.index') }}" class="inv-stat-card">
        <div class="inv-stat-icon" style="background: rgba(31,111,235,.12);">
            <i class="fas fa-box" style="color: #1f6feb;"></i>
        </div>
        <div class="inv-stat-n">{{ number_format(\App\Models\Asset::AssetsForShow()->count()) }}</div>
        <div class="inv-stat-l">Total Aset</div>
    </a>
    <a href="{{ route('hardware.index', ['status' => 'Deployed']) }}" class="inv-stat-card">
        <div class="inv-stat-icon" style="background: rgba(21,128,61,.12);">
            <i class="fas fa-exchange-alt" style="color: #15803d;"></i>
        </div>
        <div class="inv-stat-n">{{ number_format($counts['deployed'] ?? 0) }}</div>
        <div class="inv-stat-l">Sedang Dipinjam</div>
    </a>
    <a href="{{ route('hardware.index', ['status' => 'Undeployable']) }}" class="inv-stat-card">
        <div class="inv-stat-icon" style="background: rgba(180,83,9,.12);">
            <i class="fas fa-wrench" style="color: #b45309;"></i>
        </div>
        <div class="inv-stat-n">{{ number_format($counts['undeployable'] ?? 0) }}</div>
        <div class="inv-stat-l">Perbaikan</div>
    </a>
    <a href="{{ route('hardware.index', ['status' => 'Archived']) }}" class="inv-stat-card">
        <div class="inv-stat-icon" style="background: rgba(192,50,43,.12);">
            <i class="fas fa-exclamation-triangle" style="color: #c0322b;"></i>
        </div>
        <div class="inv-stat-n">{{ number_format($counts['archived'] ?? 0) }}</div>
        <div class="inv-stat-l">Rusak / Arsip</div>
    </a>
</div>

@if ($counts['grand_total'] == 0)
<div class="inv-card">
    <div class="inv-card-body" style="padding: 32px; text-align: center;">
        <p style="font-size: 15px; font-weight: 600; color: #0f1b2d;">{{ trans('general.dashboard_empty') }}</p>
        <div style="display: flex; gap: 12px; justify-content: center; margin-top: 16px; flex-wrap: wrap;">
            @can('create', \App\Models\Asset::class)
            <a class="btn btn-primary" href="{{ route('hardware.create') }}">Tambah Aset</a>
            @endcan
        </div>
    </div>
</div>
@else

{{-- Two column layout --}}
<div class="inv-two-col">

    {{-- LEFT --}}
    <div>
        {{-- Quick Actions --}}
        <div class="inv-quick-actions">
            <a href="{{ route('hardware.bulkcheckout.show') }}" class="inv-quick-tile blue">
                <div class="inv-quick-thumb" style="background: #1f6feb;">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div>
                    <span class="inv-quick-label">Pinjamkan Aset</span>
                    <span class="inv-quick-sub">Catat peminjaman</span>
                </div>
            </a>
            <a href="{{ url('hardware?status=RTD') }}" class="inv-quick-tile green">
                <div class="inv-quick-thumb" style="background: #15803d;">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <span class="inv-quick-label">Terima Kembali</span>
                    <span class="inv-quick-sub">Proses pengembalian</span>
                </div>
            </a>
            <a href="{{ route('reports.activity') }}" class="inv-quick-tile navy">
                <div class="inv-quick-thumb" style="background: #0a2540;">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div>
                    <span class="inv-quick-label">Lihat Laporan</span>
                    <span class="inv-quick-sub">Aktivitas & riwayat</span>
                </div>
            </a>
        </div>

        {{-- Recent Activity --}}
        <div class="inv-card">
            <div class="inv-card-header">
                <h3>{{ trans('general.recent_activity') }}</h3>
            </div>
            <div class="inv-card-body">
                <table
                    data-cookie-id-table="dashActivityReport"
                    data-height="400"
                    data-pagination="false"
                    data-side-pagination="server"
                    data-id-table="dashActivityReport"
                    data-sort-order="desc"
                    data-show-columns="false"
                    data-sort-name="created_at"
                    id="dashActivityReport"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.activity.index', ['limit' => 10]) }}">
                    <thead>
                    <tr>
                        <th data-field="icon" data-visible="true" style="width: 40px;" data-formatter="iconFormatter"><span class="sr-only">Icon</span></th>
                        <th data-visible="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                        <th data-visible="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.created_by') }}</th>
                        <th data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                        <th data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                        <th data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div class="inv-card-footer">
                <a href="{{ route('reports.activity') }}" class="btn btn-sm" style="background: #f4f6fa; color: #3c4a5e; border: 1px solid #e5e9f0; border-radius: 8px; font-weight: 600; font-size: 12.5px;">Lihat Semua Aktivitas</a>
            </div>
        </div>
    </div>

    {{-- RIGHT --}}
    <div>
        {{-- Status Chart --}}
        <div class="inv-card">
            <div class="inv-card-header">
                <h3>Aset per Status</h3>
            </div>
            <div class="inv-card-body" style="padding: 18px;">
                <div class="chart-responsive">
                    <canvas id="statusPieChart" height="220"></canvas>
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="inv-card">
            <div class="inv-card-header">
                <h3>Ringkasan</h3>
            </div>
            <div class="inv-card-body">
                <table style="width:100%;">
                    <tr style="border-bottom: 1px solid #e5e9f0;">
                        <td style="padding: 12px 18px; font-size: 13px; color: #6b7888; font-weight: 600;">Lisensi</td>
                        <td style="padding: 12px 18px; font-size: 13px; font-weight: 700; color: #0f1b2d; text-align: right;"><a href="{{ route('licenses.index') }}">{{ number_format($counts['license']) }}</a></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #e5e9f0;">
                        <td style="padding: 12px 18px; font-size: 13px; color: #6b7888; font-weight: 600;">Aksesori</td>
                        <td style="padding: 12px 18px; font-size: 13px; font-weight: 700; color: #0f1b2d; text-align: right;"><a href="{{ route('accessories.index') }}">{{ number_format($counts['accessory']) }}</a></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #e5e9f0;">
                        <td style="padding: 12px 18px; font-size: 13px; color: #6b7888; font-weight: 600;">Konsumabel</td>
                        <td style="padding: 12px 18px; font-size: 13px; font-weight: 700; color: #0f1b2d; text-align: right;"><a href="{{ route('consumables.index') }}">{{ number_format($counts['consumable']) }}</a></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #e5e9f0;">
                        <td style="padding: 12px 18px; font-size: 13px; color: #6b7888; font-weight: 600;">Komponen</td>
                        <td style="padding: 12px 18px; font-size: 13px; font-weight: 700; color: #0f1b2d; text-align: right;"><a href="{{ route('components.index') }}">{{ number_format($counts['component']) }}</a></td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 18px; font-size: 13px; color: #6b7888; font-weight: 600;">Pengguna</td>
                        <td style="padding: 12px 18px; font-size: 13px; font-weight: 700; color: #0f1b2d; text-align: right;"><a href="{{ route('users.index') }}">{{ number_format($counts['user']) }}</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>
@endif

</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['simple_view' => true, 'nopages' => true])
@stop

@push('js')
<script src="{{ url(mix('js/dist/Chart.min.js')) }}"></script>
<script nonce="{{ csrf_token() }}">
    var pieChartCanvas = $("#statusPieChart").get(0).getContext("2d");
    var ctx = document.getElementById("statusPieChart");
    var pieOptions = {
        legend: { position: 'top', responsive: true, maintainAspectRatio: true },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var counts = data.datasets[0].data;
                    var total = 0;
                    for(var i in counts) { total += counts[i]; }
                    var prefix = data.labels[tooltipItem.index] || '';
                    return prefix + " " + Math.round(counts[tooltipItem.index]/total*100) + "%";
                }
            }
        }
    };
    $.ajax({
        type: 'GET',
        url: '{{ (\App\Models\Setting::getSettings()->dash_chart_type == "name") ? route("api.statuslabels.assets.byname") : route("api.statuslabels.assets.bytype") }}',
        headers: { "X-Requested-With": 'XMLHttpRequest', "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') },
        dataType: 'json',
        success: function (data) {
            new Chart(ctx, { type: 'pie', data: data, options: pieOptions });
        }
    });
</script>
@endpush