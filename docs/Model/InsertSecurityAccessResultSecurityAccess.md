# # InsertSecurityAccessResultSecurityAccess

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**access_mode** | [**\OpenAPI\Client\Model\SecurityAccessAccessMode**](SecurityAccessAccessMode.md) |  | [optional]
**default_access** | [**\OpenAPI\Client\Model\SecurityAccessDefaultAccess**](SecurityAccessDefaultAccess.md) |  | [optional]
**description** | **string** | description | [optional]
**ext** | [**\OpenAPI\Client\Model\SecurityAccessExt**](SecurityAccessExt.md) |  | [optional]
**ext_description** | **string** | Description for what the Ext value means (for example, time control is on). | [optional]
**name** | **string** | name | [optional]
**parent_security_access_id** | **string** | Parent security access ID if this security access is nested and linked to parent. Null if not nested. | [optional]
**real_estate_id** | **string** | Real estate ID | [optional]
**security_access_id** | **string** | ID | [optional]
**status** | [**\OpenAPI\Client\Model\SecurityAccess2Status**](SecurityAccess2Status.md) |  | [optional]
**type** | [**\OpenAPI\Client\Model\SecurityAccess2Type**](SecurityAccess2Type.md) |  | [optional]
**version_nr** | **int** | Version number if versioned security access. Null otherwise. | [optional]
**zone_id** | **string** | Zone id if linked to a zone. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
