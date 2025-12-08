@extends('layouts.app')

@section('header-actions')
<a href="{{ url('/analytics/export') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
    Export CSV
</a>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 font-medium border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3">Time</th>
                        <th class="px-6 py-3">Temp (°C)</th>
                        <th class="px-6 py-3">Humidity (%)</th>
                        <th class="px-6 py-3">TDS (ppm)</th>
                        <th class="px-6 py-3">pH</th>
                        <th class="px-6 py-3">Water Level (cm)</th>
                        <th class="px-6 py-3">Pumps Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sensors as $sensor)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-600">
                            {{ $sensor->created_at->format('d M Y, H:i:s') }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $sensor->temperature }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $sensor->humidity }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $sensor->tds_value }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $sensor->ph }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $sensor->water_level }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $sensor->water_pump_status ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    A: {{ $sensor->pump_a_status ? 'ON' : 'OFF' }}
                                </span>
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $sensor->nutrient_pump_status ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-500' }}">
                                    B: {{ $sensor->pump_b_status ? 'ON' : 'OFF' }}
                                </span>
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $sensor->refill_status ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    R: {{ $sensor->refill_status ? 'ON' : 'OFF' }}
                                </span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            No data available yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sensors->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $sensors->links() }}
        </div>
        @endif
    </div>
@endsection
