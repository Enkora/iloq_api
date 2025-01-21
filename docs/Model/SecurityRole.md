# # SecurityRole

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**description** | **string** | Description | [optional]
**name** | **string** | Name | [optional]
**online_access_code** | **string** | Online access code. Empty when retrieving security roles and must be retrieved with a different method. If given as empty string during update, uses previous code. | [optional]
**online_relay_operating_time_ms** | **int** | How long the relay is on after access is granted. In milliseconds. | [optional]
**real_estate_id** | **string** | Real estate id | [optional]
**security_role_id** | **string** | ID | [optional]
**type_mask** | [**\OpenAPI\Client\Model\SecurityRoleTypeMask**](SecurityRoleTypeMask.md) |  | [optional]
**zone_id** | **string** | Zone id | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
