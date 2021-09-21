@if(count($combinations) > 0)
    <table class="table table-bordered">
        <thead>
        <tr>
            <td class="text-center">
                <label for="" class="control-label">{{trans('messages.Variant')}}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{trans('messages.Variant Price')}}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{trans('messages.SKU')}}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{trans('messages.Quantity')}}</label>
            </td>
        </tr>
        </thead>
        <tbody>
        @endif
        @foreach ($combinations as $key => $combination)
            <tr>
                <td>
                    <label for="" class="control-label">{{ $combination['type'] }}</label>
                </td>
                <td>
                    <input type="number" name="price_{{ $combination['type'] }}" value="{{ \App\CPU\Convert::default($combination['price']) }}" min="0" step="0.01"
                           class="form-control" required>
                </td>
                <td>
                    <input type="text" name="sku_{{ $combination['type'] }}" value="{{ $combination['sku'] }}" class="form-control" required>
                </td>
                <td>
                    <input type="number" name="qty_{{ $combination['type'] }}" value="{{ $combination['qty'] }}" min="0" step="1" class="form-control"
                           required>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

