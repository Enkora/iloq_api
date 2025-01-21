# # InsertLockParam

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**lock** | [**\OpenAPI\Client\Model\InsertLockParam1Lock**](InsertLockParam1Lock.md) |  | [optional]
**lock_options** | [**\OpenAPI\Client\Model\InsertLockParamLockOptions**](InsertLockParamLockOptions.md) |  | [optional]
**lock_relay** | [**\OpenAPI\Client\Model\InsertLockParam1LockRelay**](InsertLockParam1LockRelay.md) |  | [optional]
**lock_respects_all_time_limits** | **bool** | If true, then lock respects all timelimits and TimeLimitTitleIds doesn&#39;t need to be given. If false, then lock respects given TimeLimitTitleIds. If no timelimittitle ids are given, then lock isn&#39;t timelimited. Default is false. | [optional]
**security_accesses** | [**\OpenAPI\Client\Model\LockSecurityAccessInsert[]**](LockSecurityAccessInsert.md) | Security accesses which are set for the new lock | [optional]
**time_limit_title_ids** | **string[]** | Time limit titles for the new lock. Null or empty list of lock isn&#39;t timelimited. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
