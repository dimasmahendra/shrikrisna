@php
    use App\Helpers;
    $pert = $data->perPage()*($data->currentPage()-1);
    $headers = isset($headers) ? $headers : array_keys($data->toArray()[0]);
    $values = isset($values) ? $values : [];
    $indexColumn = isset($indexColumn) ? $indexColumn : "No";
    $style = isset($style) ? $style : function(){
        return null;
    };
    $operator = count($_GET) > 0 ? $_SERVER['REQUEST_URI']."&" : "?";
    $firstIdx = 0;
    $lastIdx = 0;
    $table_id = isset($table) ? $table : '';
    $logo = isset($logo) ? $logo : '';
    $qrurl = env('APP_URL') . '/member/myprofile?v=';
@endphp
<div class="table-responsive">
    <table id="{{ $table_id }}" class="table table-bordered nowrap">
        <thead>
            <tr>
                @if ($indexColumn)
                    <th> {{$indexColumn}} </th>
                @endif
                @foreach ($headers as $key => $item)
                    @isset($filter)
                        @if (in_array($key, $filter))
                            @php
                                // $prehref = count($allFilter)>0 ? (isset($allFilter[$key]) ? "?" : "&") : "?";
                                $val = isset($_GET[$key]) && $_GET[$key]=="desc" ? "asc" : "desc";
                            @endphp
                            <th title="Urutkan {{ucfirst($item)}} {{ucfirst($val)}}"> <a class="head-filter" href="?{{$key}}={{$val}}"><span>{{$item}}</span> <img src="/images/{{$val}}.svg" alt="up"> </a> </th>
                        @else
                            <th>{{$item}}</th>
                        @endif
                    @else
                        <th>{{$item}}</th>
                    @endisset
                @endforeach
               @isset($actions)
                    <th style="min-width: {{count($actions)*84}}px"></th>
               @endisset
            </tr>
        </thead>
        <tbody>
            @if (count($data)==0)
                <tr>
                    <td colspan="{{count($headers)+2}}" class="text-center">
                        <div class="table-content">
                            <div id="table-empty"></div>
                            <h4>Tidak ada data</h4>
                            <small>Tambahkan data</small>
                        </div>
                    </td>
                </tr>
            @endif
            @foreach ($data as $key => $item)
                @php
                    if($key==0) {
                        $firstIdx = $key+1+$pert;
                    };
                    if($key==count($data)-1) {
                        $lastIdx = $key+1+$pert;
                    };
                @endphp
                <tr style="{{$style($item)}}" id="{{ $item->id }}">
                    @if ($indexColumn)
                    <td>{{($key+1)+$pert}}</td>
                    @endif
                    @foreach ($headers as $key2 => $item2)
                        <td style="max-width: 350px">
                            @if (array_key_exists($key2, $values))
                                @if ($key2 == 'qr')
                                    @php
                                        $qr = QrCode::format('png')->merge($logo, .2)->size(250)->generate($qrurl . $item->code);
                                    @endphp
                                    <a href="data:image/png;base64, {!! base64_encode($qr) !!}" download>
                                        <img src="data:image/png;base64, {!! base64_encode($qr) !!}" class="u-image-1">
                                    </a>
                                @else
                                    <?=$values[$key2]($item)?>
                                @endif
                            @else
                                {{$item[$key2] ? $item[$key2] : "-"}}
                            @endif
                        </td>
                    @endforeach
                    @isset($actions)
                        <td>
                            @foreach ($actions as $key3 => $item2)
                                @if (isset($item2['render']))
                                    @php
                                        if (isset($item2['urlValue'])) {
                                            $url = $item2['urlValue']($item2['url'], $item, isset($params) ?$params : null);
                                        } else {
                                            $url = route($item2['url'], Crypt::encryptString($item->id));
                                        }
                                        $item2['url'] = $url;
                                    @endphp
                                    <?= $item2['render']($item, $item2) ?>
                                @else
                                @if ($item2 != false)
                                    @php
                                        if ($item2['url'] == 'gift.detailVoucher') {
                                            $can = true;
                                        } else {
                                            if (isset($item2['urlValue'])) {
                                                $url = $item2['urlValue']($item2['url'], $item, isset($params) ?$params : null);
                                            } else {
                                                $url = route($item2['url'], Crypt::encryptString($item->id));
                                            }
                                            if (isset($item2['can'])) {
                                                $can = $item2['can']($item);
                                            } else {
                                                $can = isset($item2['render_when']) ? ( $item2['render_when']($item) && Auth::getUser()->can($item2['url']) ) : Auth::getUser()->can($item2['url']);
                                            }
                                        }
                                    @endphp
                                    @if ($can)
                                        @if (isset($item2['method']) )
                                            <form id="confirm_{{$key}}" data-text="Yakin ingin menghapus" class="d-inline mr-2 confirmBeforAction" action="{{$url}}" method="POST">
                                                @csrf
                                                {{ method_field($item2['method'])}}
                                                <button type="submit"  class="btn btn-sm btn-danger">
                                                    {{Helpers::snakeToWords($key3)}}
                                                </button>
                                            </form>
                                        @else
                                            @php
                                                $disabled = isset($item->is_disabled) ? $item->is_disabled : '';
                                            @endphp
                                            @if (isset($item2['type']))  
                                                @if ($item2['type'] == 'modal')
                                                    @if (isset($item2['attribute']))
                                                        <button 
                                                            {{ $disabled }}
                                                            type="button" 
                                                            class="{{ $item2['attribute']['target'] }} {{ $item2['attribute']['button'] }}" 
                                                            data-id="{{ Crypt::encryptString($item->id) }}"
                                                            data-resource="{{ $item2['resource'] }}"
                                                            data-toggle="modal" @isset($item2['attribute']['target'])data-target="{{$item2['attribute']['target']}}"@endisset >
                                                            {{ (!empty($item2['attribute']['caption']) ? $item2['attribute']['caption'] : '') }}
                                                        </button>
                                                    @endif
                                                @endif
                                                @if ($item2['type'] == 'alertify')
                                                    <button {{ $disabled }} type="button" class="{{ $item2['attribute']['target'] }} {{ $item2['attribute']['button'] }}"
                                                        data-url="{{ route($item2['url'], Crypt::encryptString($item->id)) }}"
                                                        data-id="{{ Crypt::encryptString($item->id) }}">
                                                        {{ (!empty($item2['attribute']['caption']) ? $item2['attribute']['caption'] : '') }}
                                                    </button>
                                                @endif
                                                @if ($item2['type'] == 'dropdown')
                                                    <div class="dropdown">
                                                        @if (empty($item->isMark) && $item->isClaimed == 1)
                                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                                <i class="bi bi-three-dots"></i>
                                                            </a>
                                                        @endif
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            @if (isset($item2['menu']))
                                                                @foreach ($item2['menu'] as $menu)
                                                                    @if ($menu['type'] == 'alertify')
                                                                        <button type="button" class="dropdown-item {{ $menu['attribute']['target'] }}"
                                                                            data-id="{{ Crypt::encryptString($item->id) }}">
                                                                            {{ $menu['attribute']['caption'] }}
                                                                        </button>
                                                                    @endif
                                                                    @if ($menu['type'] == 'link')
                                                                        @if ($menu['withencrypt'] == false)
                                                                            <a class="dropdown-item" href="{{ route($menu['url'], [$item->id]) }}">{{ $menu['caption'] }}</a>
                                                                        @else
                                                                            <a class="dropdown-item" href="{{ route($menu['url'], Crypt::encryptString($item->id)) }}">{{ $menu['caption'] }}</a>
                                                                        @endif
                                                                    @endif
                                                                    @if ($menu['type'] == 'modal')
                                                                        @if (isset($menu['attribute']))
                                                                            <button 
                                                                                {{ $disabled }}
                                                                                type="button" 
                                                                                class="dropdown-item {{ $menu['attribute']['target'] }}" 
                                                                                data-id="{{ Crypt::encryptString($item->id) }}"
                                                                                data-resource="{{ $menu['resource'] }}"
                                                                                data-toggle="modal" @isset($menu['attribute']['target'])data-target="{{$menu['attribute']['target']}}"@endisset >
                                                                                {{ (!empty($menu['attribute']['caption']) ? $menu['attribute']['caption'] : '') }}
                                                                            </button>
                                                                        @endif
                                                                    @endif
                                                                    @endforeach
                                                                    @if (isset($item->status_approval) && $item->status_approval == "menunggu")
                                                                        <a class="dropdown-item text-success" href="{{ route('anggota.verifikasi-anggota', Crypt::encryptString($item->id)) }}">Verifikasi</a>
                                                                    @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <a href="{{$url}}"
                                                    class="btn btn-sm waves-effect waves-light {{isset($item2['color']) ? $item2['color'] : 'btn-info'}}">
                                                    {{Helpers::snakeToWords($key3)}}
                                                </a>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                                @endif

                            @endforeach
                        </td>
                    @endisset
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-12 px-5">
        <div class="d-flex justify-content-between">
            <div class="mb-2">{{$firstIdx}}-{{$lastIdx}} of {{$data->total()}}</div>
            <div class="mb-2">{{$firstIdx}}-{{$lastIdx}} of {{$data->total()}}</div>
        </div>
        <div class="float-r">
            {{ $data->withQueryString()->links() }}
        </div>
    </div>
</div>
