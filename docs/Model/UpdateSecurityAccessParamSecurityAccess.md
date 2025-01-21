# # UpdateSecurityAccessParamSecurityAccess

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**access_mode** | **int** | Access mode    0 &#x3D; show as default    1 &#x3D; hide as default | [optional]
**default_access** | **int** | Is security access set for locks as default    0 &#x3D; Security access is not set for locks as default    1 &#x3D; Security access is set for locks as default | [optional]
**description** | **string** | Description text | [optional]
**ext** | **int** | Option if time control/additional conditions are on.    0 &#x3D; Time control is not in use    1 &#x3D; Time control is in use | [optional]
**ext_description** | **string** | Description for what the Ext value means (for example, time control is on). | [optional]
**name** | **string** | Name | [optional]
**real_estate_id** | **string** | Real estate ID | [optional]
**security_access_id** | **string** | ID | [optional]
**type** | **int** | Type. Read only, can&#39;t be changed.    0 &#x3D; Key security access. This is only for keys which are in blocklist and is created automatically when Key is blocklisted.    1 &#x3D; Standard access    2 &#x3D; Mask. Not in use.    3 &#x3D; API Access | [optional]
**zone_id** | **string** | Zone id if linked to a zone. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
