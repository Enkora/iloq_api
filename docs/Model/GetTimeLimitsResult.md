# # GetTimeLimitsResult

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**key_scheduler** | [**\OpenAPI\Client\Model\GetTimeLimitsResultKeyScheduler**](GetTimeLimitsResultKeyScheduler.md) |  | [optional]
**key_time_limit_slots** | [**\OpenAPI\Client\Model\KeyTimeLimitSlot[]**](KeyTimeLimitSlot.md) | Time limit slots | [optional]
**offline_expiration_seconds** | **int** | S50 Time key works offline in seconds. Zero &#x3D; unlimited offline access. Maximum is 16761540 seconds for key fob and 8726340 seconds for phone. | [optional]
**outside_user_zone_time_limit_title_slots** | **int[]** | Slots which are filled by information not available for current user. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
