@extends('layouts/default')

@section('title')
{{ trans('general.dashboard') }}
@parent
@stop

@push('css')
<style>
.inv-dash { padding: 20px 24px; }

/* Stat Cards */
.inv-stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 16px; }
.inv-stat-card { background: #fff; border-radius: 12px; padding: 18px; box-shadow: 0 2px 6px rgba(15,27,45,.06), 0 8px 24px rgba(15,27,45,.06); cursor: pointer; transition: transform .12s; text-decoration: none; display: block; border: 1px solid #e5e9f0; }
.inv-stat-card:hover { transform: translateY(-2px); text-decoration: none; }
.inv-stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
.inv-stat-icon i { font-size: 18px; }
.inv-stat-n { font-size: 30px; font-weight: 800; letter-spacing: -1px; color: #0f1b2d; line-height: 1; margin-bottom: 4px; }
.inv-stat-l { font-size: 13px; font-weight: 600; color: #6b7888; margin-bottom: 6px; }
.inv-stat-delta { font-size: 12px; font-weight: 600; }
.inv-stat-delta.up { color: #15803d; }
.inv-stat-delta.down { color: #c0322b; }
.inv-stat-delta.warn { color: #b45309; }

/* Two column */
.inv-two-col { display: grid; grid-template-columns: 1.55fr 1fr; gap: 16px; align-items: start; }

/* Cards */
.inv-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 6px rgba(15,27,45,.06), 0 8px 24px rgba(15,27,45,.06); border: 1px solid #e5e9f0; margin-bottom: 16px; overflow: hidden; }
.inv-card-header { padding: 14px 18px; border-bottom: 1px solid #e5e9f0; display: flex; align-items: center; justify-content: space-between; }
.inv-card-header h3 { font-size: 14px; font-weight: 700; color: #0f1b2d; margin: 0; }
.inv-card-header .inv-badge { font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 20px; }
.inv-card-footer { padding: 12px 18px; border-top: 1px solid #e5e9f0; text-align: center; }

/* Quick Actions */
.inv-quick-actions { display: flex; gap: 12px; margin-bottom: 16px; }
.inv-quick-tile { flex: 1; display: flex; align-items: center; gap: 12px; padding: 14px; border-radius: 12px; border: 1px solid #e5e9f0; background: #fff; text-decoration: none; transition: all .12s; box-shadow: 0 1px 2px rgba(15,27,45,.06); }
.inv-quick-tile:hover { transform: translateY(-2px); text-decoration: none; border-color: #1f6feb; }
.inv-quick-thumb { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.inv-quick-thumb i { font-size: 18px; color: #fff; }
.inv-quick-label { font-size: 13.5px; font-weight: 700; color: #0f1b2d; display: block; }
.inv-quick-sub { font-size: 11.5px; color: #6b7888; display: block; }

/* Due assets */
.inv-due-row { display: flex; align-items: center; gap: 12px; padding: 11px 18px; border-top: 1px solid #e5e9f0; }
.inv-due-row:first-child { border-top: none; }
.inv-due-tag { font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 6px; background: #e8f0fe; color: #164fa8; font-family: 'IBM Plex Mono', monospace; flex-shrink: 0; }
.inv-due-name { font-size: 13px; font-weight: 600; color: #0f1b2d; }
.inv-due-who { font-size: 11.5px; color: #6b7888; }
.inv-due-pill { font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 20px; margin-left: auto; flex-shrink: 0; }
.inv-due-pill.today { background: #fdefcf; color: #b45309; }
.inv-due-pill.soon { background: #dde9fd; color: #1f6feb; }
.inv-checkin-btn { font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 8px; background: #1f6feb; color: #fff; border: none; cursor: pointer; text-decoration: none; flex-shrink: 0; }
.inv-checkin-btn:hover { background: #1a5fcc; color: #fff; text-decoration: none; }

/* Activity */
.inv-act-row { display: flex; align-items: center; gap: 12px; padding: 10px 18px; border-top: 1px solid #e5e9f0; }
.inv-act-row:first-child { border-top: none; }
.inv-act-thumb { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.inv-act-thumb i { font-size: 13px; }
.inv-act-title { font-size: 13px; font-weight: 600; color: #0f1b2d; }
.inv-act-meta { font-size: 11.5px; color: #6b7888; }
.inv-act-time { font-size: 11px; color: #9aa6b6; margin-left: auto; white-space: nowrap; flex-shrink: 0; }

/* Right column */
.inv-legend-row { display: flex; align-items: center; gap: 10px; padding: 9px 18px; border-top: 1px solid #e5e9f0; font-size: 12.5px; }
.inv-legend-row:first-child { border-top: none; }
.inv-legend-dot { width: 9px; height: 9px; border-radius: 3px; flex-shrink: 0; }
.inv-legend-label { flex: 1; font-weight: 600; color: #0f1b2d; }
.inv-legend-n { font-weight: 700; color: #0f1b2d; }
.inv-legend-pct { color: #6b7888; width: 38px; text-align: right; }

/* Bar chart */
.inv-bar-row { display: flex; align-items: center; gap: 12px; padding: 8px 18px; border-top: 1px solid #e5e9f0; font-size: 12.5px; }
.inv-bar-row:first-child { border-top: none; }
.inv-bar-label { width: 80px; font-weight: 600; color: #0f1b2d; flex-shrink: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.inv-bar-track { flex: 1; height: 8px; background: #f4f6fa; border-radius: 4px; overflow: hidden; }
.inv-bar-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg, #e8f0fe, #1f6feb); }
.inv-bar-n { width: 24px; text-align: right; font-weight: 700; color: #0f1b2d; }

/* Alert rusak */
.inv-alert-rusak { background: #fbe2e0; border: 1px solid #f3cdc9; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
.inv-alert-rusak .inv-alert-icon { width: 38px; height: 38px; border-radius: 8px; background: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.inv-alert-rusak .inv-alert-icon i { color: #c0322b; font-size: 16px; }
.inv-alert-text { flex: 1; }
.inv-alert-text strong { font-size: 13.5px; font-weight: 700; color: #c0322b; display: block; }
.inv-alert-text span { font-size: 12px; color: #9b3a34; }
.inv-alert-btn { font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 8px; background: #fff; color: #c0322b; border: 1px solid #f3cdc9; text-decoration: none; flex-shrink: 0; }
.inv-alert-btn:hover { background: #fbe2e0; color: #c0322b; text-decoration: none; }
</style>
@endpush

@section('content')
<div class="inv-dash">

@if ($snipeSettings->dashboard_message != '')
<div class="inv-card" style="margin-bottom: 16px;">
    <div style="padding: 14px 18px;">{!! Helper::parseEscapedMarkedown($snipeSettings->dashboard_message) !!}</div>
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
        <div class="inv-stat-delta up">+{{ number_format($counts['asset']) }} terdaftar</div>
    </a>
    <a href="{{ route('hardware.index', ['status' => 'Deployed']) }}" class="inv-stat-card">
        <div class="inv-stat-icon" style="background: rgba(21,128,61,.12);">
            <i class="fas fa-exchange-alt" style="color: #15803d;"></i>
        </div>
        <div class="inv-stat-n">{{ number_format($counts['deployed']) }}</div>
        <div class="inv-stat-l">Sedang Dipinjam</div>
        <div class="inv-stat-delta up">{{ $counts['asset'] > 0 ? round($counts['deployed']/$counts['asset']*100) : 0 }}% terpakai</div>
    </a>
    <a href="{{ route('hardware.index', ['status' => 'Undeployable']) }}" class="inv-stat-card">
        <div class="inv-stat-icon" style="background: rgba(180,83,9,.12);">
            <i class="fas fa-wrench" style="color: #b45309;"></i>
        </div>
        <div class="inv-stat-n">{{ number_format($counts['undeployable']) }}</div>
        <div class="inv-stat-l">Perbaikan</div>
        <div class="inv-stat-delta warn">perlu tindak lanjut</div>
    </a>
    <a href="{{ route('hardware.index', ['status' => 'Archived']) }}" class="inv-stat-card">
        <div class="inv-stat-icon" style="background: rgba(192,50,43,.12);">
            <i class="fas fa-exclamation-triangle" style="color: #c0322b;"></i>
        </div>
        <div class="inv-stat-n">{{ number_format($counts['archived']) }}</div>
        <div class="inv-stat-l">Rusak / Arsip</div>
        <div class="inv-stat-delta down">perlu tindak</div>
    </a>
</div>

@if ($counts['grand_total'] == 0)
<div class="inv-card">
    <div style="padding: 32px; text-align: center;">
        <p style="font-size: 15px; font-weight: 600; color: #0f1b2d;">{{ trans('general.dashboard_empty') }}</p>
        <div style="display: flex; gap: 12px; justify-content: center; margin-top: 16px; flex-wrap: wrap;">
            @can('create', \App\Models\Asset::class)
            <a class="btn btn-primary" href="{{ route('hardware.create') }}">Tambah Aset</a>
            @endcan
        </div>
    </div>
</div>
@else

<div class="inv-two-col">

    {{-- LEFT --}}
    <div>
        {{-- Quick Actions --}}
        <div class="inv-quick-actions">
            <a href="{{ route('hardware.bulkcheckout.show') }}" class="inv-quick-tile">
                <div class="inv-quick-thumb" style="background: #1f6feb;">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div>
                    <span class="inv-quick-label">Pinjamkan Aset</span>
                    <span class="inv-quick-sub">Catat peminjaman</span>
                </div>
            </a>
            <a href="{{ url('hardware?status=RTD') }}" class="inv-quick-tile">
                <div class="inv-quick-thumb" style="background: #15803d;">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <span class="inv-quick-label">Terima Kembali</span>
                    <span class="inv-quick-sub">Proses pengembalian</span>
                </div>
            </a>
            <a href="{{ route('reports.activity') }}" class="inv-quick-tile">
                <div class="inv-quick-thumb" style="background: #0a2540;">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div>
                    <span class="inv-quick-label">Lihat Laporan</span>
                    <span class="inv-quick-sub">Aktivitas & riwayat</span>
                </div>
            </a>
        </div>

        {{-- Jatuh Tempo --}}
        <div class="inv-card">
            <div class="inv-card-header">
                <h3>Jatuh Tempo Pengembalian</h3>
                @if($due_assets->count() > 0)
                <span class="inv-badge" style="background: #fdefcf; color: #b45309;">{{ $due_assets->count() }} aktif</span>
                @endif
            </div>
            <div>
                @if($due_assets->count() == 0)
                <div style="padding: 28px; text-align: center; color: #6b7888; font-size: 13px;">
                    <i class="fas fa-check-circle" style="font-size: 24px; color: #15803d; margin-bottom: 8px; display: block;"></i>
                    Tidak ada yang jatuh tempo. 🎉
                </div>
                @else
                @foreach($due_assets as $due)
                <div class="inv-due-row">
                    <span class="inv-due-tag">{{ $due->asset_tag }}</span>
                    <div style="flex: 1; min-width: 0;">
                        <div class="inv-due-name">{{ $due->name }}</div>
                        <div class="inv-due-who">{{ $due->assignedTo ? $due->assignedTo->getFullNameAttribute() : '—' }}</div>
                    </div>
                    @php
                        $daysUntil = now()->diffInDays($due->expected_checkin, false);
                    @endphp
                    @if($daysUntil <= 0)
                    <span class="inv-due-pill today">Hari ini</span>
                    @elseif($daysUntil == 1)
                    <span class="inv-due-pill soon">Besok</span>
                    @else
                    <span class="inv-due-pill soon">{{ $daysUntil }} hari lagi</span>
                    @endif
                    <a href="{{ route('hardware.checkin.create', ['assetId' => $due->id]) }}" class="inv-checkin-btn">
                        <i class="fas fa-check" style="margin-right: 4px;"></i>Terima
                    </a>
                </div>
                @endforeach
                @endif
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="inv-card">
            <div class="inv-card-header">
                <h3>Aktivitas Terbaru</h3>
                <a href="{{ route('reports.activity') }}" style="font-size: 12.5px; color: #1f6feb; font-weight: 600; text-decoration: none;">Lihat semua →</a>
            </div>
            <div>
                @foreach($recent_activity->take(6) as $activity)
                @php
                    $actionColors = [
                        'checkout' => ['bg' => 'rgba(31,111,235,.12)', 'color' => '#1f6feb', 'icon' => 'fa-exchange-alt'],
                        'checkin from' => ['bg' => 'rgba(21,128,61,.12)', 'color' => '#15803d', 'icon' => 'fa-check'],
                        'update' => ['bg' => 'rgba(109,74,255,.12)', 'color' => '#6d4aff', 'icon' => 'fa-edit'],
                        'create' => ['bg' => 'rgba(109,74,255,.12)', 'color' => '#6d4aff', 'icon' => 'fa-plus'],
                        'delete' => ['bg' => 'rgba(192,50,43,.12)', 'color' => '#c0322b', 'icon' => 'fa-trash'],
                    ];
                    $ac = $actionColors[$activity->action_type] ?? ['bg' => 'rgba(15,27,45,.08)', 'color' => '#6b7888', 'icon' => 'fa-circle'];
                @endphp
                <div class="inv-act-row">
                    <div class="inv-act-thumb" style="background: {{ $ac['bg'] }};">
                        <i class="fas {{ $ac['icon'] }}" style="color: {{ $ac['color'] }};"></i>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div class="inv-act-title">
                            <span style="color: {{ $ac['color'] }};">{{ ucfirst($activity->action_type) }}</span>
                            @if($activity->item && $activity->item->name) · {{ $activity->item->name }}@endif
                        </div>
                        <div class="inv-act-meta">{{ $activity->user ? $activity->user->getFullNameAttribute() : 'System' }}</div>
                    </div>
                    <div class="inv-act-time">{{ $activity->created_at->diffForHumans() }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- RIGHT --}}
    <div>
        {{-- Alert Rusak --}}
        @if($counts['undeployable'] > 0)
        <div class="inv-alert-rusak">
            <div class="inv-alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="inv-alert-text">
                <strong>{{ $counts['undeployable'] }} aset rusak menunggu</strong>
                <span>Perlu keputusan perbaikan / penghapusan.</span>
            </div>
            <a href="{{ route('hardware.index', ['status' => 'Undeployable']) }}" class="inv-alert-btn">Tinjau</a>
        </div>
        @endif

        {{-- Aset per Status --}}
        <div class="inv-card">
            <div class="inv-card-header">
                <h3>Aset per Status</h3>
            </div>
            <div style="padding: 18px; display: flex; align-items: center; gap: 18px;">
                <div style="width: 130px; height: 130px; flex-shrink: 0;">
                    <canvas id="statusPieChart" width="130" height="130"></canvas>
                </div>
                <div id="statusLegend" style="flex: 1; min-width: 0;"></div>
            </div>
        </div>

        {{-- Aset per Kategori --}}
        <div class="inv-card">
            <div class="inv-card-header">
                <h3>Aset per Kategori</h3>
            </div>
            <div style="padding: 8px 0;">
                @php $maxCat = $assets_by_category->max('assets_count') ?: 1; @endphp
                @foreach($assets_by_category as $cat)
                <div class="inv-bar-row">
                    <div class="inv-bar-label" title="{{ $cat->name }}">{{ $cat->name }}</div>
                    <div class="inv-bar-track">
                        <div class="inv-bar-fill" style="width: {{ round($cat->assets_count/$maxCat*100) }}%;"></div>
                    </div>
                    <div class="inv-bar-n">{{ $cat->assets_count }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Ringkasan --}}
        <div class="inv-card">
            <div class="inv-card-header"><h3>Ringkasan</h3></div>
            <div>
                @php
                $summaries = [
                    ['label' => 'Lisensi', 'count' => $counts['license'], 'route' => route('licenses.index')],
                    ['label' => 'Aksesori', 'count' => $counts['accessory'], 'route' => route('accessories.index')],
                    ['label' => 'Konsumabel', 'count' => $counts['consumable'], 'route' => route('consumables.index')],
                    ['label' => 'Komponen', 'count' => $counts['component'], 'route' => route('components.index')],
                    ['label' => 'Pengguna', 'count' => $counts['user'], 'route' => route('users.index')],
                ];
                @endphp
                @foreach($summaries as $i => $s)
                <div style="display: flex; align-items: center; padding: 11px 18px; {{ $i > 0 ? 'border-top: 1px solid #e5e9f0;' : '' }}">
                    <span style="flex: 1; font-size: 13px; font-weight: 600; color: #6b7888;">{{ $s['label'] }}</span>
                    <a href="{{ $s['route'] }}" style="font-size: 13px; font-weight: 700; color: #0f1b2d;">{{ number_format($s['count']) }}</a>
                </div>
                @endforeach
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
    var ctx = document.getElementById("statusPieChart");
    if (ctx) {
        var statusData = {
            labels: ['Siap Pakai', 'Dipinjam', 'Pending', 'Tidak Dapat Dipakai', 'Diarsipkan'],
            datasets: [{
                data: [
                    {{ $counts['rtd'] }},
                    {{ $counts['deployed'] }},
                    {{ \App\Models\Asset::where('status_id', function($q){ $q->select('id')->from('status_labels')->where('deployable', 0)->where('pending', 1)->where('archived', 0); })->count() }},
                    {{ $counts['undeployable'] }},
                    {{ $counts['archived'] }}
                ],
                backgroundColor: ['#15803d', '#1f6feb', '#b45309', '#c0322b', '#51607a'],
                borderWidth: 0
            }]
        };
        var pieOptions = {
            responsive: false,
            maintainAspectRatio: false,
            legend: { display: false },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var counts = data.datasets[0].data;
                        var total = counts.reduce(function(a, b) { return a + b; }, 0);
                        var prefix = data.labels[tooltipItem.index] || '';
                        return prefix + ": " + counts[tooltipItem.index] + " (" + Math.round(counts[tooltipItem.index]/total*100) + "%)";
                    }
                }
            }
        };
        var myChart = new Chart(ctx, { type: 'doughnut', data: statusData, options: pieOptions });

        // Build legend
        var legend = document.getElementById('statusLegend');
        var total = statusData.datasets[0].data.reduce(function(a,b){ return a+b; }, 0);
        var html = '';
        statusData.labels.forEach(function(label, i) {
            var count = statusData.datasets[0].data[i];
            if (count == 0) return;
            var pct = total > 0 ? Math.round(count/total*100) : 0;
            html += '<div style="display:flex;align-items:center;gap:9px;padding:7px 0;font-size:12.5px;">' +
                '<span style="width:9px;height:9px;border-radius:3px;background:' + statusData.datasets[0].backgroundColor[i] + ';flex-shrink:0;display:inline-block;"></span>' +
                '<span style="flex:1;font-weight:600;color:#0f1b2d;">' + label + '</span>' +
                '<span style="font-weight:700;color:#0f1b2d;">' + count + '</span>' +
                '<span style="color:#6b7888;width:38px;text-align:right;">' + pct + '%</span>' +
                '</div>';
        });
        legend.innerHTML = html;
    }
</script>
@endpush