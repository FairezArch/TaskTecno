@extends('master')
@section('content')
    <section>
        <div class="shadow-sm p-3 bg-white rounded w-100">
            <div class="col-md-12 mt-1 mb-2 text-center">
                <a href="{{ route('task.index') }}" class="btn btn-success text-white">Buat Kegiatan</a>
            </div>
            <div class="col-md-12">
                <div class="table-responsive-md">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr>
                                <th class="text-center">Metode</th>

                                @foreach ($periodMonth as $period)
                                    <th class="text-center">{{ __('global.' . $period) }}</th>
                                @endforeach

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allData as $data)
                                <tr>
                                    <td class="table-striped">{{ $data[0]->name }}</td>
                                    @if ($data[0]->task->isEmpty())
                                        <td colspan="6" class="text-center">{{ __('global.assignment') }}</td>
                                    @else
                                        @foreach ($data[1] as $lists)
                                            <td>
                                                @foreach ($lists as $list)
                                                    <ul>
                                                        <li>
                                                            {{ $list->name }}
                                                            <br />
                                                            <small class="text-primary">({{ $list->DateFromTab }} -
                                                                {{ $list->DateToTab }})</small>
                                                            <br />
                                                            <span
                                                                class="badge rounded-pill bg-info text-white">{{ $list->NameStatus }}</span>
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            </td>
                                        @endforeach
                                    @endif
                                @empty
                                    <td colspan="7" class="text-center">{{ __('validation.no_data') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
