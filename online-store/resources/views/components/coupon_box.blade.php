<div class="couponTemplate">
    <div class="couponTitle">
        <label>Title: </label>
        <span>{{ $coupon->Title }}</span>
    </div>
    <div class="couponCode">
        <label>Code: </label>
        <span>{{ $coupon->Code }}</span>
    </div>
    <div class="couponDiscount">
        <label>Discount: </label>
        @if ($coupon->DiscountType == 1)
            <span> {{ $coupon->DiscountValue }}%</span>
        @else
            <span> {{ $coupon->DiscountValue }}$</span>
        @endif
    </div>
    <div class="couponDate">
        <label>Date: </label>
        @if ($coupon->StartDate != null)
            @if ($coupon->EndDate != null)
                <span>From {{ $coupon->StartDate }} to {{ $coupon->EndDate }}</span>
            @else
                <span>From {{ $coupon->StartDate }}</span>
            @endif
        @else
            @if ($coupon->EndDate != null)
                <span>To {{ $coupon->EndDate }}</span>
            @else
                <span>No expiration date</span>
            @endif
        @endif
    </div>
    <div class="couponTime">
        <label>No. Of Times: </label>
        @if ($coupon->Time != null)
            <span> {{ $coupon->Time }}</span>
        @else
            <span>Unlimited</span>
        @endif
    </div>
    <hr>
    <div class="couponCondition">
        <label>Condition:</label>
        @if ($coupon->ConditionCoupon > 0)
            <span>Total amount is at least {{ $coupon->ConditionCoupon }}$</span>
        @else
            <span>No condition</span>
        @endif
    </div>
    @if (($coupon->Time == 0 || now() < $coupon->StartDate || now() > $coupon->EndDate)&&($coupon->StartDate != null || $coupon->EndDate != null))
        <div class="couponExpired" style="background-color: red">
            <span>Expired</span>
        </div>
    @else
        <div class="couponExpired" style="background-color: green">
            <span>Available</span>
        </div>
    @endif
</div>