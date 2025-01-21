# # UpdateLockSecurityAccessesParam

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**lock_options** | [**\OpenAPI\Client\Model\UpdateLockSecurityAccessesParamLockOptions**](UpdateLockSecurityAccessesParamLockOptions.md) |  | [optional]
**lock_relay** | [**\OpenAPI\Client\Model\UpdateLockSecurityAccessesParam1LockRelay**](UpdateLockSecurityAccessesParam1LockRelay.md) |  | [optional]
**lock_respects_all_time_limits** | **bool** | If true, then lock respects all timelimits And TimeLimitTitleIds doesn&#39;t need to be given. If false, then lock respects given TimeLimitTitleIds. If no timelimittitle ids are given, then lock isn&#39;t timelimited. Default is false. | [optional]
**security_access_ids** | **string[]** | Security accesses which are set to the lock | [optional]
**time_limit_title_ids** | **string[]** | Time limit titles which are set to the lock. If null and LockRespectsAllTimeLimits&#x3D;false, then time limits are not changed | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
