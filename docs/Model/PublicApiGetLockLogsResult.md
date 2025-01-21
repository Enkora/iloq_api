# # PublicApiGetLockLogsResult

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**lock_logs** | [**\OpenAPI\Client\Model\PublicApiDeviceLogData[]**](PublicApiDeviceLogData.md) | Device logs. Currently maximum of 2000 is returned at once. | [optional]
**total_count** | **int** | Total number of device logs on server with given parameters. Calling application can compare LockLogs.Count to this number and if they don&#39;t match, change parameters to narrow it down. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
