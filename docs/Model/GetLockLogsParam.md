# # GetLockLogsParam

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**f_lock_ids** | **string[]** | Lock Ids. Either Key ids or Lock ids must be given, or both. | [optional]
**fn_key_ids** | **string[]** | Key Ids. Either Key ids or Lock ids must be given, or both. | [optional]
**going_end_date_utc** | **\DateTime** | Return logs where going date is before this end date. If null, then doesn&#39;t take it into account. | [optional]
**going_start_date_utc** | **\DateTime** | Returns logs where going date is after this start date. If null, then doesn&#39;t take it into account. | [optional]
**type_mask** | [**\OpenAPI\Client\Model\GetLockLogsParamTypeMask**](GetLockLogsParamTypeMask.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
