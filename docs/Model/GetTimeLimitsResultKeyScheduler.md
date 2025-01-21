# # GetTimeLimitsResultKeyScheduler

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**renew_end_date** | **\DateTime** | When renewing ends | [optional]
**renew_gap_count** | **int** | Gap in days/weeks before key is renewed. (depending on RenewGapType) | [optional]
**renew_gap_type** | [**\OpenAPI\Client\Model\KeySchedulerRenewGapType**](KeySchedulerRenewGapType.md) |  | [optional]
**renew_minute** | **int** | How long before key&#39;s expiration it is renewed. Time is in minutes. For example if value is 120, new programming packet is made about 2 hours before expiration. Minimum is 70 minutes. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
