# # LNKeyTimeLimitData

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**end_time** | **string** | End time (read only) | [optional]
**end_time_ms** | **int** | Start time in milliseconds when this timelimit ends on given weekdays For example 57 600 000 would be 16:00 in the afternoon. Must be divisable by 15 minutes. | [optional]
**start_time** | **string** | start time (read only) | [optional]
**start_time_ms** | **int** | Start time in milliseconds when this timelimit begins on given weekdays. For example 28 800 000 would be 8:00 in the morning. Must be divisable by 15 minutes. | [optional]
**week_day_mask** | **int** | Week days mask to inform when this timelimit is in use | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
