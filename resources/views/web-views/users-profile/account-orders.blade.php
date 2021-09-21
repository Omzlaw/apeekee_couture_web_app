@extends('layouts.front-end.app')

@section('title','My Order List')

@push('css_or_js')
    <link rel="stylesheet" media="screen"
          href="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.css"/>
@endpush

@section('content')
    <style>

        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }

        .card {
            border: none
        }


        .totals tr td {
            font-size: 13px
        }


        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spandHeadO {
            color: #FFFFFF !important;
            font-weight: 600 !important;
            font-size: 14px;

        }

        .amount {
            font-size: 15px;
            color: #030303;
            font-weight: 600;


        }

        .tdBorder {
            border-right: 1px solid #f7f0f0;
            text-align: center;
        }

        .bodytr {
            border: 1px solid #dadada;
            text-align: center;
        }

        .sellerName {
            font-size: 15px;
            font-weight: 600;
            text-align: center;
        }

        .sidebar h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}                        !important;
            transition: .2s ease-in-out;
        }

        tr td {
            padding: 3px 5px !important;
        }

        td button {
            padding: 3px 13px !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }
            .orderDate{
                display: none;
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }
    </style>
     <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9 sidebar_heading">
                <h1 class="h3  mb-0 folot-left headerTitle">{{trans('messages.my_order')}}</h1>
            </div>
        </div>
    </div>

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3">
        <div class="row">
            <!-- Sidebar-->
        @include('web-views.partials._profile-aside')
        <!-- Content  -->
            <section class="col-lg-9 mt-3 col-md-9">
                <div class="card box-shadow-sm">
                    <div style="overflow: auto">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr style="background-color: {{$web_config['secondary_color']}};">
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO ">{{trans('messages.Order#')}}</span></div>
                                </td>
                                {{--<td class="tdBorder">
                                    <div class="py-2 ml-2"><span
                                            class="d-block spandHeadO ">{{trans('messages.Seller')}}</span></div>
                                </td>--}}

                                <td class="tdBorder orderDate">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO">{{trans('messages.Order')}} {{trans('messages.Date')}}</span>
                                    </div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO"> {{trans('messages.Status')}}</span></div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO"> {{trans('messages.Total')}}</span></div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO"> {{trans('messages.action')}}</span></div>
                                </td>
                            </tr>
                            </thead>

                            <tbody>
                            
                            @foreach($orders as $order)

                        
                                <tr>
                                    @if($order['id']>0)
                                    <td class="bodytr font-weight-bold">
                                        {{trans('messages.ID')}}: {{$order['id']}}
                                    </td>
                                    {{--<td class="sellerName">
                                            <span
                                                class="">{{ $order->sellerName ? $order->sellerName->seller ? $order->sellerName->seller->f_name. ' '.$order->sellerName->seller->l_name : "Not Set" : "Not Set" }}</span>
                                    </td>--}}
                                    <td class="bodytr orderDate"><span class="">{{$order['created_at']}}</span></td>
                                    <td class="bodytr">
                                        @if($order['order_status']=='failed' || $order['order_status']=='canceled')
                                            <span class="badge badge-danger" style="padding: 10px">
                                                {{$order['order_status']}}
                                            </span>
                                            <a style="margin: 10px"
                                               href="{{route('customer.payment-mobile',['order_id'=>$order['id'],'customer_id'=>auth('customer')->id()])}}"
                                               class="btn btn-secondary btn-sm">Pay Now</a>
                                        @else
                                            <span class="badge badge-info" style="padding: 10px">
                                                {{$order['order_status']}}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="bodytr">
                                        {{\App\CPU\Helpers::currency_converter($order['order_amount'])}}
                                    </td>
                                    <td class="bodytr">
                                        <a href="{{ route('account-order-details', ['id'=>$order->id]) }}"
                                           class="btn btn-secondary p-2">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                    @else
                                    
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <center class="mt-3 mb-2"> NO Order Found</center>
                                       
                                    </td>
                                    <td></td>
                                    <td></td>
                                
                                    @endif
                                </tr>
                             
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Modal -->
    {{-- @foreach($orders as $order)
        <div class="modal fade" id="order-details-{{$order['id']}}">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{trans('messages.Order')}} {{trans('messages.ID')}}: {{$order['id']}} ,
                            <label class="badge badge-info" style="color: white">{{$order['order_status']}}</label>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0px!important;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{trans('messages.Product')}}</th>
                                <th scope="col">{{trans('messages.Price')}}</th>
                                <th scope="col">{{trans('messages.Quantity')}}</th>
                                <th scope="col">{{trans('messages.Tax')}}</th>
                                <th scope="col">{{trans('messages.shipping_charge')}}</th>
                                <th scope="col">{{trans('messages.Sub')}} {{trans('messages.Total')}} </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->details as $key=>$detail)
                                @php($product=json_decode($detail['product_details'],true))
                                @php($sh_cost=\App\Model\ShippingMethod::where(['id'=>$detail['shipping_method_id']])->first()->cost)
                                <tr>
                                    <th scope="row">{{++$key}}</th>
                                    <td>{{$product['name']}}</td>
                                    <td>{{\App\CPU\Helpers::currency_converter($detail['price'])}}</td>
                                    <td>{{$detail['qty']}}</td>
                                    <td>{{\App\CPU\Helpers::currency_converter($detail['tax'])}}</td>
                                    <td>{{$sh_cost.'$'}}</td>
                                    <td>{{\App\CPU\Helpers::currency_converter(($detail['qty']*$detail['price'])+($detail['tax']+$sh_cost))}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th scope="row"></th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{trans('messages.Discount')}} :</td>
                                <td> {{\App\CPU\Helpers::currency_converter($order['discount_amount'])}} </td>
                            </tr>
                            <tr>
                                <th scope="row"></th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{trans('messages.Total')}} :</td>
                                <td> {{\App\CPU\Helpers::currency_converter($order['order_amount'])}} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('messages.Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach --}}

@endsection

@push('script')

@endpush
