# OpenAPI\Client\PersonsApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**personsCanDelete()**](PersonsApi.md#personsCanDelete) | **GET** /api/v2/Persons/{id}/CanDelete | /api/v2/Persons/{id}/CanDelete |
| [**personsDelete()**](PersonsApi.md#personsDelete) | **DELETE** /api/v2/Persons/{id} | /api/v2/Persons/{id} |
| [**personsGetAllPersons()**](PersonsApi.md#personsGetAllPersons) | **GET** /api/v2/Persons | /api/v2/Persons |
| [**personsGetNortecCode()**](PersonsApi.md#personsGetNortecCode) | **GET** /api/v2/Persons/{id}/NortecActivationCode | /api/v2/Persons/{id}/NortecActivationCode |
| [**personsGetPerson()**](PersonsApi.md#personsGetPerson) | **GET** /api/v2/Persons/{id} | /api/v2/Persons/{id} |
| [**personsGetPersonsByExternalPersonIds()**](PersonsApi.md#personsGetPersonsByExternalPersonIds) | **GET** /api/v2/Persons/GetByExternalPersonIds | /api/v2/Persons/GetByExternalPersonIds |
| [**personsInsert()**](PersonsApi.md#personsInsert) | **POST** /api/v2/Persons | /api/v2/Persons |
| [**personsUpdate()**](PersonsApi.md#personsUpdate) | **PUT** /api/v2/Persons | /api/v2/Persons |


## `personsCanDelete()`

```php
personsCanDelete($id): \OpenAPI\Client\Model\PniPersonCanDeleteErrorType
```

/api/v2/Persons/{id}/CanDelete

Checks if person can be deleted.    <b>Required user rights:</b>    - Right to edit persons

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PersonsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $result = $apiInstance->personsCanDelete($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PersonsApi->personsCanDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\PniPersonCanDeleteErrorType**](../Model/PniPersonCanDeleteErrorType.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `personsDelete()`

```php
personsDelete($id): \SplFileObject
```

/api/v2/Persons/{id}

Deletes a person    <b>Required user rights:</b>    - Right to edit persons

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PersonsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $result = $apiInstance->personsDelete($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PersonsApi->personsDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/octet-stream`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `personsGetAllPersons()`

```php
personsGetAllPersons(): \OpenAPI\Client\Model\Person[]
```

/api/v2/Persons

Gets all persons user has rights to. Requires CanBrowsePersonList right.    <b>Required user rights:</b>    - Right to view person list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PersonsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->personsGetAllPersons();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PersonsApi->personsGetAllPersons: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\Person[]**](../Model/Person.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `personsGetNortecCode()`

```php
personsGetNortecCode($id): string
```

/api/v2/Persons/{id}/NortecActivationCode

Get's Nortec activation code    <b>Required user rights:</b>    - Right to view person list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PersonsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $result = $apiInstance->personsGetNortecCode($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PersonsApi->personsGetNortecCode: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

**string**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `personsGetPerson()`

```php
personsGetPerson($id): \OpenAPI\Client\Model\Person
```

/api/v2/Persons/{id}

Gets a single person by its ID. Requires CanBrowsePersonList right    <b>Required user rights:</b>    - Right to view person list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PersonsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 'id_example'; // string

try {
    $result = $apiInstance->personsGetPerson($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PersonsApi->personsGetPerson: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**|  | |

### Return type

[**\OpenAPI\Client\Model\Person**](../Model/Person.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `personsGetPersonsByExternalPersonIds()`

```php
personsGetPersonsByExternalPersonIds($external_person_ids): \OpenAPI\Client\Model\Person[]
```

/api/v2/Persons/GetByExternalPersonIds

Gets persons by their external person ids    <b>Required user rights:</b>    - Right to view person list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PersonsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$external_person_ids = array('external_person_ids_example'); // string[]

try {
    $result = $apiInstance->personsGetPersonsByExternalPersonIds($external_person_ids);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PersonsApi->personsGetPersonsByExternalPersonIds: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **external_person_ids** | [**string[]**](../Model/string.md)|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\Person[]**](../Model/Person.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `personsInsert()`

```php
personsInsert($insert_person_param): \OpenAPI\Client\Model\InsertResult
```

/api/v2/Persons

Inserts new persons    <b>Required user rights:</b>    - Right to edit persons

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PersonsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$insert_person_param = new \OpenAPI\Client\Model\InsertPersonParam(); // \OpenAPI\Client\Model\InsertPersonParam

try {
    $result = $apiInstance->personsInsert($insert_person_param);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PersonsApi->personsInsert: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **insert_person_param** | [**\OpenAPI\Client\Model\InsertPersonParam**](../Model/InsertPersonParam.md)|  | |

### Return type

[**\OpenAPI\Client\Model\InsertResult**](../Model/InsertResult.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `personsUpdate()`

```php
personsUpdate($update_person_param)
```

/api/v2/Persons

Updates existing persons    <b>Required user rights:</b>    - Right to edit persons

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PersonsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$update_person_param = new \OpenAPI\Client\Model\UpdatePersonParam(); // \OpenAPI\Client\Model\UpdatePersonParam

try {
    $apiInstance->personsUpdate($update_person_param);
} catch (Exception $e) {
    echo 'Exception when calling PersonsApi->personsUpdate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **update_person_param** | [**\OpenAPI\Client\Model\UpdatePersonParam**](../Model/UpdatePersonParam.md)|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
