@extends('seller.layouts.app')

@section('panel_content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Set CategoryWise Product Discount')}}</h1>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header d-block d-md-flex">
        <h5 class="mb-0 h6">{{ translate('Categories') }}</h5>
        <form class="" id="sort_categories" action="" method="GET">
            <div class="box-inline pad-rgt pull-left">
                <div class="" style="min-width: 200px;">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th data-breakpoints="lg">{{translate('Icon')}}</th>
                    <th>{{translate('Name')}}</th>
                    <th data-breakpoints="lg">{{ translate('Parent Category') }}</th>
                    <th data-breakpoints="lg" width="15%">{{ translate('Discount') }}</th>
                    <th data-breakpoints="lg" width="20%">{{ translate('Discount Date Range') }}</th>
                    <th data-breakpoints="lg" class="text-right">{{ translate('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $key => $category)
                    <tr>
                        <td>{{ ($key+1) + ($categories->currentPage() - 1)*$categories->perPage() }}</td>
                        <td>
                            @if($category->icon != null)
                                <span class="avatar avatar-square avatar-xs">
                                    <img src="{{ uploaded_asset($category->icon) }}" alt="{{translate('icon')}}">
                                </span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="align-items-center d-flex fw-800">
                            {{ $category->getTranslation('name') }}
                            @if($category->digital == 1)
                                <img src="{{ static_asset('assets/img/digital_tag.png') }}" alt="{{translate('Digital')}}" class="ml-2 h-25px" style="cursor: pointer;" title="DIgital">
                            @endif
                         </td>
                        <td class="fw-600">
                            @php
                                $parent = \App\Models\Category::where('id', $category->parent_id)->first();
                            @endphp
                            @if ($parent != null)
                                {{ $parent->getTranslation('name') }}
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" class="form-control" id="discount_{{ $category->id }}" step="0.01" value="0" min="0" placeholder="{{translate('Discount')}}"
                                    style="border-radius: 8px 0 0 8px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-left-0" id="inputGroupPrepend" style="border-radius: 0 8px 8px 0;">%</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control aiz-date-range rounded-2" id="date_range_{{ $category->id }}" placeholder="{{translate('Select Date')}}" data-time-picker="true" data-format="DD-MM-Y HH:mm:ss" data-separator=" to " autocomplete="off">
                        </td>
                        <td class="text-right">
                            <div class="form-group mb-0 text-right">
                                <button type="button" onclick="setDiscount({{ $category->id }})" class="btn btn-primary btn-sm rounded-2 w-120px">{{translate('Set')}}</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $categories->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">

        $(document).ready(function() {
            setTimeout(() => {
                AIZ.plugins.dateRange();
            }, "2000");
        });

        function setDiscount(CategoryId){
            var CategoryId = CategoryId;
            var discount =  $("#discount_" + CategoryId).val();
            var dateRange =  $("#date_range_" + CategoryId).val();

            if(discount < 0) {
                AIZ.plugins.notify('danger', '{{ translate('Discount can not be less than 0') }}');
            }
            else{
                $.post('{{ route('seller.set_product_discount') }}', {
                    _token:'{{ csrf_token() }}', 
                    category_id:CategoryId, 
                    discount:discount, 
                    date_range:dateRange
                }, function(data) {
                    if(data == 1){
                        AIZ.plugins.notify('success', '{{ translate('Category Wise Product Discount Set Successfully') }}');
                    }
                    else{
                        AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    }
                    location.reload();
                });
            }   
        }
    </script>
@endsection


