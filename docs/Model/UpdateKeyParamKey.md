# # UpdateKeyParamKey

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**description** | **string** | Description text | [optional]
**expire_date** | **\DateTime** | Expiration date. Null if the key doesn&#39;t expire. | [optional]
**fn_key_id** | **string** | Key Id | [optional]
**info_text** | **string** | Additional info text | [optional]
**is_programmed** | **bool** | Has key ever been programmed yet. Read only. Programming state can be other than Programmed if there has been changes made to the key after it has been programmed the first time. | [optional]
**key_type_mask** | [**\OpenAPI\Client\Model\KeyKeyTypeMask**](KeyKeyTypeMask.md) |  | [optional]
**person_id** | **string** | Person to whom the key is linked to. Null if the key isn&#39;t linked to anyone. This is **required** field for S50 phone key. | [optional]
**programming_state** | [**\OpenAPI\Client\Model\KeyProgrammingState**](KeyProgrammingState.md) |  | [optional]
**real_estate_id** | **string** | ID of the real estate where this key belongs to. | [optional]
**rom_id** | **string** | ROM ID | [optional]
**stamp** | **string** | Stamp. Number consisting of 4 digits written to the physical key. |
**stamp_source** | **int** | The source of the key labeling (Stamp). Read only.    0 &#x3D; User-entered    1 &#x3D; Read from the key. Key labeling (Stamp) can not be edited.    2 &#x3D; Retrieved from the database | [optional]
**state** | **int** | Current state    0 &#x3D; Key is in planning state.    1 &#x3D; Key is handed over to a person    2 &#x3D; Key is hidden and shouldn&#39;t be displayed by default    3 &#x3D; Key is deleted but remains in the system for logging purposes    4 &#x3D; Key is returned | [optional]
**tag_key** | **string** | RFID Tag. Empty string if not given. | [optional]
**tag_key_hex** | **string** | RFID Tag presented as HEX. Empty if TagKey is absent. Read only. | [optional]
**tag_key_source** | **int** | The source of the key&#39;s tagkey enumeration. Read only.      0 &#x3D; User-entered    1 &#x3D; Read from the key. Key&#39;s tagkey can not be edited. | [optional]
**version_code** | **string** | Version information | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
