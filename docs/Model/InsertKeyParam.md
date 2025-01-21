# # InsertKeyParam

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**key** | [**\OpenAPI\Client\Model\InsertKeyParamKey**](InsertKeyParamKey.md) |  | [optional]
**key_scheduler** | [**\OpenAPI\Client\Model\GetTimeLimitsResultKeyScheduler**](GetTimeLimitsResultKeyScheduler.md) |  | [optional]
**offline_expiration_seconds** | **int** | S50 Time key works offline in seconds. Zero &#x3D; unlimited offline access. Maximum is 16761540 seconds for key fob and 8726340 seconds for phone. | [optional]
**security_access_ids** | **string[]** | Security accesses which should be linked to the new key | [optional]
**time_limit_slots** | [**\OpenAPI\Client\Model\KeyTimeLimitSlot[]**](KeyTimeLimitSlot.md) | Time limit slots | [optional]
**zone_ids** | **string[]** | Zones the new key belongs to | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
