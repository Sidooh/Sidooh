<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Account
 *
 * @property int $id
 * @property string $phone
 * @property int $active
 * @property string|null $pin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $telco_id
 * @property int|null $referrer_id
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Referral[] $active_referrals
 * @property-read int|null $active_referrals_count
 * @property-read \App\Models\Subscription|null $active_subscription
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|Account[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\SubAccount|null $current_account
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Earning[] $earnings
 * @property-read int|null $earnings_count
 * @property-read \App\Models\SubAccount|null $interest_account
 * @property-read \App\Models\Merchant|null $merchant
 * @property-read Account|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Referral[] $pending_referrals
 * @property-read int|null $pending_referrals_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Referral[] $referrals
 * @property-read int|null $referrals_count
 * @property-read Account|null $referrer
 * @property-read \App\Models\SubAccount|null $savings_account
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SubAccount[] $sub_accounts
 * @property-read int|null $sub_accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\Voucher|null $voucher
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|static[] all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|static[] get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account newModelQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account newQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account query()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account subscribed()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account subscribedLevel($level)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account treeOf(callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account whereActive($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account whereId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account wherePhone($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account wherePin($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account whereReferrerId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account whereTelcoId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account whereUpdatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account whereUserId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Account withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 */
	class IdeHelperAccount {}
}

namespace App\Models{
/**
 * App\Models\AirtimeRequest
 *
 * @property int $id
 * @property string $errorMessage
 * @property int $numSent
 * @property string $totalAmount
 * @property string $totalDiscount
 * @property int|null $transaction_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AirtimeResponse|null $response
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AirtimeResponse[] $responses
 * @property-read int|null $responses_count
 * @property-read \App\Models\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereErrorMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereNumSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereTotalDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeRequest whereUpdatedAt($value)
 */
	class IdeHelperAirtimeRequest {}
}

namespace App\Models{
/**
 * App\Models\AirtimeResponse
 *
 * @property int $id
 * @property string $phoneNumber
 * @property string $errorMessage
 * @property string $amount
 * @property string $status
 * @property string $requestID
 * @property string $discount
 * @property int $airtime_request_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AirtimeRequest $request
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereAirtimeRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereErrorMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereRequestID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirtimeResponse whereUpdatedAt($value)
 */
	class IdeHelperAirtimeResponse {}
}

namespace App\Models{
/**
 * App\Models\CollectiveInvestment
 *
 * @property int $id
 * @property string $amount
 * @property string|null $interest_rate
 * @property string|null $interest
 * @property \Illuminate\Support\Carbon $investment_date
 * @property \Illuminate\Support\Carbon|null $maturity_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SubInvestment[] $subInvestments
 * @property-read int|null $sub_investments_count
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment query()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereInvestmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereMaturityDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectiveInvestment whereUpdatedAt($value)
 */
	class IdeHelperCollectiveInvestment {}
}

namespace App\Models{
/**
 * App\Models\Earning
 *
 * @property int $id
 * @property string|null $aggregate_transactions
 * @property string $earnings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $account_id
 * @property int $transaction_id
 * @property string $type
 * @property-read \App\Models\Account|null $account
 * @property-read \App\Models\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|Earning newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Earning newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Earning query()
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereAggregateTransactions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereEarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereUpdatedAt($value)
 */
	class IdeHelperEarning {}
}

namespace App\Models{
/**
 * App\Models\Group
 *
 * @property int $id
 * @property string $Name
 * @property float $amount
 * @property string $status
 * @property string $type
 * @property string $start_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereUpdatedAt($value)
 */
	class IdeHelperGroup {}
}

namespace App\Models{
/**
 * App\Models\Merchant
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $contact_name
 * @property string $contact_number
 * @property string $in
 * @property string $out
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property-read \App\Models\Account $account
 * @property-read mixed $balance
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereUpdatedAt($value)
 */
	class IdeHelperMerchant {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $payable_id
 * @property string $payable_type
 * @property float $amount
 * @property string $status
 * @property string $type
 * @property string $subtype
 * @property int $payment_id
 * @property string $start_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_type
 * @property-read Model|\Eloquent $payable
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @property-read \DrH\Mpesa\Entities\MpesaBulkPaymentRequest|null $b2cRequest
 * @property-read \DrH\Mpesa\Entities\MpesaStkRequest|null $stkRequest
 */
	class IdeHelperPayment {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $Name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 */
	class IdeHelperProduct {}
}

namespace App\Models{
/**
 * App\Models\ProductSetting
 *
 * @property int $id
 * @property float $g_percentage
 * @property float $u_percentage
 * @property float $o_percentage
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $product_id
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereGPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereOPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereUPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSetting whereUpdatedAt($value)
 */
	class IdeHelperProductSetting {}
}

namespace App\Models{
/**
 * App\Models\Referral
 *
 * @property int $id
 * @property int $referee_phone
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int|null $referee_id
 * @property-read \App\Models\Account|null $account
 * @property-read \App\Models\Account $referrer
 * @method static Builder|Referral active()
 * @method static Builder|Referral expired()
 * @method static Builder|Referral newModelQuery()
 * @method static Builder|Referral newQuery()
 * @method static Builder|Referral pending()
 * @method static Builder|Referral query()
 * @method static Builder|Referral timeActive()
 * @method static Builder|Referral whereAccountId($value)
 * @method static Builder|Referral whereCreatedAt($value)
 * @method static Builder|Referral whereId($value)
 * @method static Builder|Referral whereRefereeId($value)
 * @method static Builder|Referral whereRefereePhone($value)
 * @method static Builder|Referral whereStatus($value)
 * @method static Builder|Referral whereUpdatedAt($value)
 */
	class IdeHelperReferral {}
}

namespace App\Models{
/**
 * App\Models\SubAccount
 *
 * @property int $id
 * @property string $type
 * @property string $in
 * @property string $out
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property-read \App\Models\Account $account
 * @property-read mixed $balance
 * @method static Builder|SubAccount newModelQuery()
 * @method static Builder|SubAccount newQuery()
 * @method static Builder|SubAccount query()
 * @method static Builder|SubAccount type($type)
 * @method static Builder|SubAccount whereAccountId($value)
 * @method static Builder|SubAccount whereCreatedAt($value)
 * @method static Builder|SubAccount whereId($value)
 * @method static Builder|SubAccount whereIn($value)
 * @method static Builder|SubAccount whereOut($value)
 * @method static Builder|SubAccount whereType($value)
 * @method static Builder|SubAccount whereUpdatedAt($value)
 */
	class IdeHelperSubAccount {}
}

namespace App\Models{
/**
 * App\Models\SubInvestment
 *
 * @property int $id
 * @property string $amount
 * @property string|null $interest
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int $collective_investment_id
 * @property-read \App\Models\Account $account
 * @property-read \App\Models\CollectiveInvestment $collectiveInvestment
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereCollectiveInvestmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestment whereUpdatedAt($value)
 */
	class IdeHelperSubInvestment {}
}

namespace App\Models{
/**
 * App\Models\Subscription
 *
 * @property int $id
 * @property float $amount
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int $subscription_type_id
 * @property-read \App\Models\Account $account
 * @property-read \App\Models\SubscriptionType $subscription_type
 * @method static Builder|Subscription active()
 * @method static Builder|Subscription newModelQuery()
 * @method static Builder|Subscription newQuery()
 * @method static Builder|Subscription query()
 * @method static Builder|Subscription whereAccountId($value)
 * @method static Builder|Subscription whereActive($value)
 * @method static Builder|Subscription whereAmount($value)
 * @method static Builder|Subscription whereCreatedAt($value)
 * @method static Builder|Subscription whereId($value)
 * @method static Builder|Subscription whereSubscriptionTypeId($value)
 * @method static Builder|Subscription whereUpdatedAt($value)
 */
	class IdeHelperSubscription {}
}

namespace App\Models{
/**
 * App\Models\SubscriptionType
 *
 * @property int $id
 * @property string $title
 * @property string $amount
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $level_limit
 * @property int $duration
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereLevelLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType whereUpdatedAt($value)
 */
	class IdeHelperSubscriptionType {}
}

namespace App\Models{
/**
 * App\Models\Telco
 *
 * @property int $id
 * @property string $initials
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Telco newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Telco newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Telco query()
 * @method static \Illuminate\Database\Eloquent\Builder|Telco whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telco whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telco whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telco whereInitials($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telco whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Telco whereUpdatedAt($value)
 */
	class IdeHelperTelco {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property float $amount
 * @property string $status
 * @property string $type
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int|null $product_id
 * @property-read \App\Models\Account $account
 * @property-read \App\Models\AirtimeRequest|null $airtime
 * @property-read \App\Models\Payment|null $payment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \DrH\Tanda\Models\TandaRequest|null $request
 */
	class IdeHelperTransaction {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $id_number
 * @property string $status
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Account[] $accounts
 * @property-read int|null $accounts_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * App\Models\UserNotification
 *
 * @property int $id
 * @property string $type
 * @property string $content
 * @property array $to
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereUpdatedAt($value)
 */
	class IdeHelperUserNotification {}
}

namespace App\Models{
/**
 * App\Models\UssdLog
 *
 * @property int $id
 * @property string $phone
 * @property string $text
 * @property string $session_id
 * @property string $service_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog whereServiceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdLog whereUpdatedAt($value)
 */
	class IdeHelperUssdLog {}
}

namespace App\Models{
/**
 * App\Models\UssdMenu
 *
 * @property int $id
 * @property string $title
 * @property int $type
 * @property int $is_parent
 * @property string $confirmation_message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereConfirmationMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereIsParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenu whereUpdatedAt($value)
 */
	class IdeHelperUssdMenu {}
}

namespace App\Models{
/**
 * App\Models\UssdMenuItem
 *
 * @property int $id
 * @property int $menu_id
 * @property string $description
 * @property int $type
 * @property int $next_menu_id
 * @property int $step
 * @property string $confirmation_phrase
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereConfirmationPhrase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereNextMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdMenuItem whereUpdatedAt($value)
 */
	class IdeHelperUssdMenuItem {}
}

namespace App\Models{
/**
 * App\Models\UssdResponse
 *
 * @property int $id
 * @property int $user_id
 * @property int $menu_id
 * @property int $menu_item_id
 * @property string $response
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereMenuItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdResponse whereUserId($value)
 */
	class IdeHelperUssdResponse {}
}

namespace App\Models{
/**
 * App\Models\UssdUser
 *
 * @property int $id
 * @property string $phone
 * @property int $session
 * @property int $progress
 * @property int $pin
 * @property int $menu_id
 * @property int $confirm_from
 * @property int $menu_item_id
 * @property int $difficulty_level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereConfirmFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereDifficultyLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereMenuItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser wherePin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereSession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UssdUser whereUpdatedAt($value)
 */
	class IdeHelperUssdUser {}
}

namespace App\Models{
/**
 * App\Models\Voucher
 *
 * @property int $id
 * @property string $in
 * @property string $out
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property-read \App\Models\Account $account
 * @property-read mixed $balance
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereUpdatedAt($value)
 */
	class IdeHelperVoucher {}
}

namespace App\Repositories{
/**
 * App\Repositories\EarningRepository
 *
 * @property int $id
 * @property string|null $aggregate_transactions
 * @property string $earnings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $account_id
 * @property int $transaction_id
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|EarningRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EarningRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EarningRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|EarningRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EarningRepository whereAggregateTransactions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EarningRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EarningRepository whereEarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EarningRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EarningRepository whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EarningRepository whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EarningRepository whereUpdatedAt($value)
 */
	class IdeHelperEarningRepository {}
}

namespace App\Repositories{
/**
 * App\Repositories\InvestmentRepository
 *
 * @property int $id
 * @property string $amount
 * @property string|null $interest_rate
 * @property string|null $interest
 * @property string $investment_date
 * @property string|null $maturity_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentRepository whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentRepository whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentRepository whereInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentRepository whereInvestmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentRepository whereMaturityDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentRepository whereUpdatedAt($value)
 */
	class IdeHelperInvestmentRepository {}
}

namespace App\Repositories{
/**
 * App\Repositories\MerchantRepository
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $contact_name
 * @property string $contact_number
 * @property string $in
 * @property string $out
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MerchantRepository whereUpdatedAt($value)
 */
	class IdeHelperMerchantRepository {}
}

namespace App\Repositories{
/**
 * App\Repositories\PaymentRepository
 *
 * @property int $id
 * @property int $payable_id
 * @property string $payable_type
 * @property float $amount
 * @property string $status
 * @property string $type
 * @property string $subtype
 * @property int $payment_id
 * @property string $start_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository wherePayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository wherePayableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRepository whereUpdatedAt($value)
 */
	class IdeHelperPaymentRepository {}
}

namespace App\Repositories{
/**
 * App\Repositories\ReferralRepository
 *
 * @property int $id
 * @property int $referee_phone
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int|null $referee_id
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereRefereeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereRefereePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralRepository whereUpdatedAt($value)
 */
	class IdeHelperReferralRepository {}
}

namespace App\Repositories{
/**
 * App\Repositories\SubAccountRepository
 *
 * @property int $id
 * @property string $type
 * @property string $in
 * @property string $out
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubAccountRepository whereUpdatedAt($value)
 */
	class IdeHelperSubAccountRepository {}
}

namespace App\Repositories{
/**
 * App\Repositories\SubInvestmentRepository
 *
 * @property int $id
 * @property string $amount
 * @property string|null $interest
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int $collective_investment_id
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereCollectiveInvestmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubInvestmentRepository whereUpdatedAt($value)
 */
	class IdeHelperSubInvestmentRepository {}
}

namespace App\Repositories{
/**
 * App\Repositories\SubscriptionRepository
 *
 * @property int $id
 * @property float $amount
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int $subscription_type_id
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereSubscriptionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionRepository whereUpdatedAt($value)
 */
	class IdeHelperSubscriptionRepository {}
}

namespace App\Repositories{
/**
 * App\Repositories\TransactionRepository
 *
 * @property int $id
 * @property float $amount
 * @property string $status
 * @property string $type
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int|null $product_id
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereUpdatedAt($value)
 */
	class IdeHelperTransactionRepository {}
}

namespace App\Repositories{
/**
 * App\Repositories\VoucherRepository
 *
 * @property int $id
 * @property string $in
 * @property string $out
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherRepository whereIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherRepository whereOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherRepository whereUpdatedAt($value)
 */
	class IdeHelperVoucherRepository {}
}

