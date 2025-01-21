# # KeyTimeLimitSlot

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**limit_date_lg** | **\DateTime** | If slot &#x3D; 0, this is start date in locking system&#39;s time zone. If slot &#x3D; 1, this is end date in locking system&#39;s time zone. If slot &#x3D; 2, this is null. | [optional]
**slot_no** | [**\OpenAPI\Client\Model\LNKeyTimeLimitSlotSlotNo**](LNKeyTimeLimitSlotSlotNo.md) |  | [optional]
**source_calendar_data_id** | **string** | Id of a calendar entry if lnkeytimelimitslot is created for the key by key scheduler. Read only. | [optional]
**time_limit_data** | [**\OpenAPI\Client\Model\KeyTimeLimitData[]**](KeyTimeLimitData.md) | TimeLimit data in this slot. | [optional]
**time_limit_title_id** | **string** | TimeLimitTitle ID if any. | [optional]
**time_limit_title_end_date_lg** | **\DateTime** | End date of TimeLimitTitle in locking systems&#39;s time zone or null if not defined. | [optional]
**time_limit_title_start_date_lg** | **\DateTime** | Start date of TimeLimitTitle in locking systems&#39;s time zone or null if not defined | [optional]
**time_zone_id** | **string** | Time zone of the time limit. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
