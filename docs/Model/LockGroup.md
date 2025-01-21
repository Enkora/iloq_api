# # LockGroup

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**adapter_version** | **int** | Adapter version which user has set in the locking system settings.    0 &#x3D; Adapter doesn&#39;t exist or it isn&#39;t recognized    1 &#x3D; Adapter which doesn&#39;t have flash memory.    2 &#x3D; Adapter which supports flash memory (if installed)    4 &#x3D; Adapter which supports the making of laundry room keys (programming packet may contain key&#39;s name) | [optional]
**address** | **string** | Street address/city where the locking system is in use | [optional]
**classification** | **string** | Classification | [optional]
**contact_person** | **string** | Contact person&#39;s name | [optional]
**country_code** | **string** | Locking system&#39;s country code. For example \&quot;FIN\&quot; for Finnish. | [optional]
**customer_id** | **string** | Customer ID who owns the lockgroup | [optional]
**description** | **string** | Description | [optional]
**expire_date_utc** | **\DateTime** | Date when locking system expires. Null if doesn&#39;t expire. | [optional]
**front_image** | **string** | User set image which is displayed on the start page of iLOQ Manager. Null if not set. | [optional]
**info_text** | **string** | General user written info text. | [optional]
**lock_group_id** | **string** | ID | [optional]
**name** | **string** | Name of the locking system | [optional]
**option_mask** | **int** | Option mask of the settings in use in the locking system.    0 &#x3D; None    1 &#x3D; Key&#39;s, which has been handed over, person can be changed without returning the key.    2 &#x3D; Zones are in use.    4 &#x3D; Real estates are in use    8 &#x3D; Is Tag field visible for key    16 &#x3D; Can keys&#39; tags be edited    32 &#x3D; Code groups are in use    64 &#x3D; Lock&#39;s time limits are split into key&#39;s time limits    128 &#x3D; Key&#39;s PIN code in use    256 &#x3D; Is locking system in 24 bit mode    512 &#x3D; Addition for CanUseSpace value. Are zones in use on keys and persons    1024 &#x3D; Can set key&#39;s packet valid from date    2048 &#x3D; Is Public API in use    4096 &#x3D; Is S50 locking system in use    8192 &#x3D; Is S10 locking system in use    16384 &#x3D; Can locking system use API access rights    32768 &#x3D; Are external RFID tags in use    65536 &#x3D; Is 5 Series locking system in use    131072 &#x3D; Is zone specific black list in use    262144 &#x3D; Is iLOQ HOME in use    524288 &#x3D; Is 23 time limit slots for keys and locks in use instead of default 10.              Locks with firmware greater than 138 support 23 time limit slots.              NOT IN USE.    1048576 &#x3D; Locking system has K5S.1-6 capability on meaning it supports keys with software version 1-199.              No restrictions to lock software versions.    2097152 &#x3D; Locking system has K5S.7-9 capability on meaning it supports keys with software version 200-99999.              C5 Locks software version must be &gt;&#x3D; 149              D5 Locks software version must be &gt;&#x3D; 148              D5i Locks software version must be &gt;&#x3D; 141              C5R software version must be &gt;&#x3D; 300              D5R software version must be &gt;&#x3D; 300    4194304 &#x3D; For development time use. Enables not finished features in 5 Series Manager.    8388608 &#x3D; Whether S50 lock closing reminder is in use.              8 388 608    16777216 &#x3D; Whether multiple time zones are in use in the locking system.              16 777 216    33554432 &#x3D; Whether key updates are blocked through gateway              33 554 432    67108864 &#x3D; Whether gateway key fob log read task is enabled              67 108 864 | [optional]
**programming_admin** | **string** | Name of the person who is responsible for programming tasks | [optional]
**state** | **int** | Is locking system in use or not    0 &#x3D; Locking system is active (in use)    1 &#x3D; Locking system is not active (not in use) | [optional]
**time_zone_standard_name** | **string** | Name of the time zone the locking system uses as default for new administrative zones. For example &#39;FLE Standard Time&#39;. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
