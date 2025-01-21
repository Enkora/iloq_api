# OpenAPI\Client\PersonRolesApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**personRolesGetAllPersonRoles()**](PersonRolesApi.md#personRolesGetAllPersonRoles) | **GET** /api/v2/PersonRoles | /api/v2/PersonRoles |
| [**personRolesGetPersonRolesByPersonResult()**](PersonRolesApi.md#personRolesGetPersonRolesByPersonResult) | **GET** /api/v2/Persons/{id}/PersonRoles | /api/v2/Persons/{id}/PersonRoles |
| [**personRolesGetRoleById()**](PersonRolesApi.md#personRolesGetRoleById) | **GET** /api/v2/PersonRoles/{id} | /api/v2/PersonRoles/{id} |
| [**personRolesGetSecurityAccessesByPersonRoleId()**](PersonRolesApi.md#personRolesGetSecurityAccessesByPersonRoleId) | **GET** /api/v2/PersonRoles/{id}/SecurityAccesses | /api/v2/PersonRoles/{id}/SecurityAccesses |


## `personRolesGetAllPersonRoles()`

```php
personRolesGetAllPersonRoles(): \OpenAPI\Client\Model\PersonRole[]
```

/api/v2/PersonRoles

Gets all person roles in locking system user has rights to    <b>Required user rights:</b>    - Right to view person role list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PersonRolesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->personRolesGetAllPersonRoles();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PersonRolesApi->personRolesGetAllPersonRoles: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\PersonRole[]**](../Model/PersonRole.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `personRolesGetPersonRolesByPersonResult()`

```php
personRolesGetPersonRolesByPersonResult($id): \OpenAPI\Client\Model\PersonRole[]
```

/api/v2/Persons/{id}/PersonRoles

Gets all person roles linked to given Person ID    <b>Required user rights:</b>    - Right to view person role list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PersonRolesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Person ID

try {
    $result = $apiInstance->personRolesGetPersonRolesByPersonResult($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PersonRolesApi->personRolesGetPersonRolesByPersonResult: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Person ID | |

### Return type

[**\OpenAPI\Client\Model\PersonRole[]**](../Model/PersonRole.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `personRolesGetRoleById()`

```php
personRolesGetRoleById($id): \OpenAPI\Client\Model\PersonRole
```

/api/v2/PersonRoles/{id}

Gets single role by its ID    <b>Required user rights:</b>    - Right to view person role list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PersonRolesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Person role ID

try {
    $result = $apiInstance->personRolesGetRoleById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PersonRolesApi->personRolesGetRoleById: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Person role ID | |

### Return type

[**\OpenAPI\Client\Model\PersonRole**](../Model/PersonRole.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `personRolesGetSecurityAccessesByPersonRoleId()`

```php
personRolesGetSecurityAccessesByPersonRoleId($id): \OpenAPI\Client\Model\SecurityAccess[]
```

/api/v2/PersonRoles/{id}/SecurityAccesses

Gets security accesses linked to a person role    <b>Required user rights:</b>    - Right to view person role list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PersonRolesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string | Person role ID

try {
    $result = $apiInstance->personRolesGetSecurityAccessesByPersonRoleId($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PersonRolesApi->personRolesGetSecurityAccessesByPersonRoleId: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Person role ID | |

### Return type

[**\OpenAPI\Client\Model\SecurityAccess[]**](../Model/SecurityAccess.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
