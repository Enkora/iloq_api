# # CalendarDataGetByCalendarDataIdResultRecurringEntry

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**calendar_data_id** | **string** | Calendar data id | [optional]
**calendar_data_title_id** | **string** | Calendar data title id for which this entry belongs to. | [optional]
**end_date_time** | **\DateTime** | End time | [optional]
**start_date_time** | **\DateTime** | Start time | [optional]
**subject** | **string** | Subject text | [optional]
**type** | [**\OpenAPI\Client\Model\CalendarDataEntryType**](CalendarDataEntryType.md) |  | [optional]
**re_id** | **string** | ID so that exceptions can be linked to correct recurring entry. | [optional]
**re_occurrence_duration_ticks** | **int** | Recurring entry&#39;s duration in ticks. | [optional]
**re_occurrence_start_time** | **\DateTime** | Occurence start time. This and Re_OccurrenceDurationTicks are used to calculate the time span of the occurence. | [optional]
**re_pattern_days_of_week** | **int** | Days of week mask which tells on which days the recurring entry happens. None &#x3D; 0 Sunday &#x3D; 1 Monday &#x3D; 2 Tuesday &#x3D; 4 Wednesday &#x3D; 8 Thursday &#x3D; 16 Friday &#x3D; 32 Saturday &#x3D; 64 | [optional]
**re_pattern_frequency** | **int** | How often entry recurs: Daily DEPRECATED &#x3D; 0 Weekly &#x3D; 1 Monthly &#x3D; 2 Yearly &#x3D; 3 | [optional]
**re_range_end_date** | **\DateTime** | Last date of recurring entry. | [optional]
**re_range_limit** | **int** | 0 &#x3D; No limit to the number of occurrences in the recurrence. 1 &#x3D; DEPRECATED The recurrence is limited to a specific number of occurrences. 2 &#x3D; The recurrence is restricted by an ending date. | [optional]
**re_range_start_date** | **\DateTime** | First date of recurring entry. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
