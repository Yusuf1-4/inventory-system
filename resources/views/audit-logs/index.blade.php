<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Audit Trail</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Filters --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" action="{{ route('audit-logs.index') }}" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">User</label>
                        <select name="user_id" class="text-sm border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Users</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" @selected(request('user_id') == $u->id)>
                                    {{ $u->name }} ({{ strtoupper($u->role) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Action</label>
                        <select name="action" class="text-sm border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Actions</option>
                            @foreach($actions as $act)
                                <option value="{{ $act }}" @selected(request('action') === $act)>
                                    {{ ucfirst(str_replace('_', ' ', $act)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Module</label>
                        <select name="module" class="text-sm border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Modules</option>
                            @foreach($modules as $mod)
                                <option value="{{ $mod }}" @selected(request('module') === $mod)>{{ $mod }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                               class="text-sm border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                               class="text-sm border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">
                            Filter
                        </button>
                        <a href="{{ route('audit-logs.index') }}"
                           class="bg-gray-100 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-200">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            {{-- Results count --}}
            <p class="text-sm text-gray-500 px-1">
                Showing {{ $logs->firstItem() }}–{{ $logs->lastItem() }} of {{ $logs->total() }} entries
            </p>

            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Date / Time</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($logs as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-500 whitespace-nowrap">
                                    {{ $log->created_at->format('d M Y') }}<br>
                                    <span class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($log->user)
                                        <span class="font-medium text-gray-900">{{ $log->user->name }}</span><br>
                                        @php
                                            $roleClass = match($log->user->role) {
                                                'admin'      => 'bg-red-100 text-red-700',
                                                'supervisor' => 'bg-yellow-100 text-yellow-700',
                                                'qa'         => 'bg-blue-100 text-blue-700',
                                                'qc'         => 'bg-purple-100 text-purple-700',
                                                default      => 'bg-green-100 text-green-700',
                                            };
                                        @endphp
                                        <span class="text-xs px-1.5 py-0.5 rounded {{ $roleClass }}">
                                            {{ strtoupper($log->user->role) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic">Deleted user</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $actionClass = match($log->action) {
                                            'login'                => 'bg-blue-100 text-blue-700',
                                            'logout'               => 'bg-gray-100 text-gray-600',
                                            'created'              => 'bg-green-100 text-green-700',
                                            'updated'              => 'bg-yellow-100 text-yellow-700',
                                            'deleted'              => 'bg-red-100 text-red-700',
                                            'approved'             => 'bg-emerald-100 text-emerald-700',
                                            'rejected'             => 'bg-red-100 text-red-700',
                                            'bulk_deleted'         => 'bg-red-100 text-red-700',
                                            'bulk_imported'        => 'bg-green-100 text-green-700',
                                            'permissions_updated'  => 'bg-purple-100 text-purple-700',
                                            default                => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $actionClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ $log->module }}</td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $log->description }}
                                    @if($log->old_values || $log->new_values)
                                        <div x-data="{ open: false }" class="mt-1">
                                            <button @click="open = !open"
                                                    class="text-xs text-indigo-500 hover:text-indigo-700 underline">
                                                <span x-text="open ? 'Hide changes' : 'View changes'"></span>
                                            </button>
                                            <div x-show="open" x-cloak class="mt-1 grid grid-cols-2 gap-2 text-xs">
                                                @if($log->old_values)
                                                <div class="bg-red-50 rounded p-2">
                                                    <p class="font-semibold text-red-700 mb-1">Before</p>
                                                    @foreach($log->old_values as $k => $v)
                                                        <div><span class="font-medium">{{ $k }}:</span> {{ $v }}</div>
                                                    @endforeach
                                                </div>
                                                @endif
                                                @if($log->new_values)
                                                <div class="bg-green-50 rounded p-2">
                                                    <p class="font-semibold text-green-700 mb-1">After</p>
                                                    @foreach($log->new_values as $k => $v)
                                                        <div><span class="font-medium">{{ $k }}:</span> {{ $v }}</div>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-500 whitespace-nowrap font-mono text-xs">
                                    {{ $log->ip_address }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400">No audit records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div>{{ $logs->links() }}</div>

        </div>
    </div>
</x-app-layout>
