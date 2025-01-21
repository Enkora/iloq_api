# # LockLogData

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**access_type_mask** | [**\OpenAPI\Client\Model\LockLogDataAccessTypeMask**](LockLogDataAccessTypeMask.md) |  | [optional]
**device_log_id** | **string** | Log ID | [optional]
**error_code** | **int** | Error code. 0 means no error | [optional]
**error_description** | **string** | Error Description | [optional]
**f_lock_id** | **string** | Lock Id | [optional]
**f_lock_log_fn_key_id** | **string** | Log ID. Deprecated field, use DeviceLog_ID instead. | [optional]
**fn_key_id** | **string** | Key&#39;s ID which accessed lock | [optional]
**going_counter** | **int** | Counter of how many times lock has been used | [optional]
**going_date** | **\DateTime** | Date And time when Key accessed lock (UTC time) | [optional]
**key_id** | **int** | Key&#39;s KeyId info | [optional]
**location_code** | **string** | Lock&#39;s location code | [optional]
**lock_group_id** | **string** | Locking system ID | [optional]
**locking_object** | **string** | Lock&#39;s Locking object info | [optional]
**reading_date** | **\DateTime** | Date And time when log was read | [optional]
**timestamp_utc** | **\DateTime** | Time when log arrived to the server and was added to the database | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
