<style>
    .steps-light .step-item.active .step-count, .steps-light .step-item.active .step-progress {
        color: #fff;
        background-color: {{$web_config['primary_color']}};
    }

    .steps-light .step-count, .steps-light .step-progress {
        color: #4f4f4f;
        background-color: rgba(225, 225, 225, 0.67);
    }

    .steps-light .step-item.active.current {
        color: {{$web_config['primary_color']}}  !important;
        pointer-events: none;
    }

    .steps-light .step-item {
        color: #4f4f4f;
        font-size: 14px;
        font-weight: 400;
    }
</style>
<div class="steps steps-light pt-2 pb-2">
    <a class="step-item {{$step>=1?'active':''}} {{$step==1?'current':''}}" href="{{route('checkout-details')}}">
        <div class="step-progress">
            <span class="step-count"><i class="czi-user-circle"></i></span>
        </div>
        <div class="step-label">
            {{trans('messages.sing_in')}} / {{trans('messages.sing_up')}}
        </div>
    </a>
    <a class="step-item {{$step>=2?'active':''}} {{$step==2?'current':''}}" href="{{route('checkout-shipping')}}">
        <div class="step-progress">
            <span class="step-count"><i class="czi-package"></i></span>
        </div>
        <div class="step-label">
            {{trans('messages.Shipping')}}
        </div>
    </a>
    <a class="step-item {{$step>=3?'active':''}} {{$step==3?'current':''}}" href="{{route('checkout-payment')}}">
        <div class="step-progress">
            <span class="step-count"><i class="czi-card"></i></span>
        </div>
        <div class="step-label">
            {{trans('messages.Payment')}}
        </div>
    </a>
</div>
